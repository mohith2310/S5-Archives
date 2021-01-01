#include "header.h"

int main()
{
	mkfifo("f2",0666);
	mkfifo("f3",0666);
	char temp[10];
	float a[5];
	int fd;

	for(int i=0;i<5;i++)
	{
		fd = open("f2",O_RDONLY);

		sleep(1);
		read(fd,temp,10);
		close(fd);
		a[i] = atoi(temp);

		printf("In P3 %s\n",temp);
	}	

	float avg,sd;

	fd = open("f2",O_RDONLY);
	sleep(1);
	read(fd,temp,10);
	close(fd);
	avg = atoi(temp);
	printf("In p3: avg = %s\n",temp );

	fd = open("f2",O_RDONLY);
	sleep(1);
	read(fd,temp,10);
	close(fd);
	sd = atoi(temp);
	printf("In p3: sd = %s\n",temp );

	for(int i=0;i<5;i++)
	{
		if(a[i] == avg)
		{
			;
		}
		else if( (avg+sd) < a[i] )
		{
			a[i] -= 3.0;
		}
		else if( (avg < a[i] ) && ( a[i] < (avg+sd)) )
		{
			a[i] -= 1.5;
		}
		else if(((avg-sd) < a[i]) && (a[i] < avg) )
		{
			a[i] += 2.0;
		}
		else if( a[i] < (avg-sd) )
		{
			a[i] += 2.5;
		}

		char str[10];

		
		int fd = open("f3",O_WRONLY);

		sprintf(str,"%f",a[i]);
		
		sleep(1);
		write(fd,str,strlen(str)+1);
		close(fd);
		printf("sending %s to p1\n",str);
	}

	return 0;
}