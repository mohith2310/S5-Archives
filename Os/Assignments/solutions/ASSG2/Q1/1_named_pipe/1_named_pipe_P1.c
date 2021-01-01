#include "header.h"

int main()
{
	mkfifo("f1",0666);
	mkfifo("f3",0666);

	char temp[3];
	
	for(int i=0;i<5;i++)
	{
		int fd = open("f1",O_WRONLY);

		scanf("%s",temp);
		sleep(3);
		write(fd,temp,strlen(temp)+1);
		close(fd);	
	}

	char str[10];
	for(int i=0;i<5;i++)
	{

		sleep(2);
		int fd = open("f3",O_RDONLY);

		read(fd,str,10);
		printf("Final temp%d : %s\n",i+1,str);
		close(fd);
	}

	return 0;
}