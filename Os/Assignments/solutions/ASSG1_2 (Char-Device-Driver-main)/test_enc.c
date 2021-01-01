#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <fcntl.h>
#include <string.h>
#include <unistd.h>

int main()
{
	int fd;
	char key[16], message[256], userinp[256];
	size_t key_len = 0;
	int write_ret_status, read_ret_status;
	FILE *fp;
	fp = fopen("/dev/urandom", "r");
	do
	{
		fread(&key, 1, 16, fp);	
	} while(strlen(key) < 16);
	
	fclose(fp);
	key[16] = '\0';

	int key_data = open("./key", O_RDWR | O_CREAT);
	write(key_data, key, strlen(key));
	close(key_data);
	printf("%s %s\n", "Key for enc is:", key);
	fd = open("/dev/encdev", O_RDWR);
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
	int len = 0;

	printf("Enter the message you wish to encrypt (max size 200): ");
	fgets(userinp, 200, stdin);
	len = strlen(userinp);
	userinp[strlen(userinp)] = '\0';
	if (len % 16 != 0)
	{
		int h = 0;
		for ( ; h < 16 - len % 16; ++h)
		{
			userinp[len + h] = '0';
		}
	}
	userinp[len + 16 - len % 16] = '\0';
	printf("%s %s\n", "Your padded message is:", userinp);

	int index = 0;
	while (index < strlen(userinp))
	{
		char tempmsg[16];
		int i = 0;
		for (i = 0 ; i < 16 ; ++i)
			tempmsg[i] = userinp[index++];
		tempmsg[i] = '\0';
		write_ret_status = write(fd, tempmsg, strlen(tempmsg));			
		if (write_ret_status < 0)
		{
			perror("write");
			return errno;
		}
	}
	read_ret_status = read(fd, message, strlen(userinp));
	if (read_ret_status < 0)
	{
		perror("read");
		return errno;
	}
	close(fd);
	printf("%s %s\n","Your encrypted message is:", message);
	int enc_write = open("./encryption.enc",  O_WRONLY | O_TRUNC | O_CREAT);
	write(enc_write, message, strlen(message));
	close(enc_write);
	return 0;
}
