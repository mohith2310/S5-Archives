#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <fcntl.h>
#include <string.h>
#include <unistd.h>

int main()
{
	int fd;
	char key[16], message[256], encryption[256];
	size_t key_len = 0;
	int write_ret_status, read_ret_status;
	FILE *fp;
	fp = fopen("key", "r");
	fread(&key, 1, 16, fp);
	fclose(fp);
	key[16] = '\0';
	printf("%s %s\n", "Key that was used for decryption is:", key);
	fp = fopen("encryption.enc", "r");
	fread(&encryption, 1, 256, fp);
	close(*(int *)fp);
	encryption[strlen(encryption) - strlen(encryption) % 16] = '\0';

	fd = open("/dev/decdev", O_RDWR);
	if (fd < 0)
	{
		perror("open");
		return errno;
	}
	write_ret_status = write(fd, key, strlen(key));
	if (write_ret_status < 0)
	{
		perror("write");
		return errno;
	}
	int index = 0;
	printf("%s %s\n", "Your Encrypted message is:",encryption);
	while (index < strlen(encryption))
	{
		char tempmsg[16];
		int i = 0;
		for (i = 0 ; i < 16 ; ++i)
			tempmsg[i] = encryption[index++];
		tempmsg[i] = '\0';
		write_ret_status = write(fd, tempmsg, strlen(tempmsg));			
		if (write_ret_status < 0)
		{
			perror("write");
			return errno;
		}
	}	
	read_ret_status = read(fd, message, strlen(encryption));
	if (read_ret_status < 0)
	{
		perror("read");
		return errno;
	}
	close(fd);
	int v = 0;
	for ( ; v < strlen(message) ; ++v)
	{
		if (message[v] == '0')
		{
			message[v] = '\0';
			break;
		}
	}
	printf("%s %s\n", "Your Decrypted message is:", message);
	return 0;
}
