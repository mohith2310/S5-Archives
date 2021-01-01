#include "header.h"

float average(float a[],int n)
{
	float res=0;
	for(int i=0;i<n;i++)
	{
		res += a[i];
	}

	res = res/(float)n;

	return res;
}

double variance(float a[], int n) 
{ 
    int sum = 0; 
    for (int i = 0; i < n; i++) 
        sum += a[i]; 
    double mean = (double)sum / (double)n; 
  
    double sqDiff = 0; 
    for (int i = 0; i < n; i++)  
        sqDiff += (a[i] - mean) * (a[i] - mean); 
    return sqDiff /(double) n; 
}

double findSD(float arr[], int n) 
{ 
    return sqrt(variance(arr, n)); 
}

int main()
{
	mkfifo("f1",0666);
	mkfifo("f2",0666);

	float end_t[5];
	int fd;
	char temp[3];
	char str[10];
	for(int i=0;i<5;i++)
	{
		sleep(2);
		fd = open("f1",O_RDONLY);
		read(fd,temp,sizeof(temp));
		close(fd);

		printf("User1:%s\n",temp);
		
		end_t[i] = atoi(temp);
		
		fd = open("f2",O_WRONLY);
		sprintf(str,"%f",end_t[i]);

		printf("In P2 %s\n",str);
		sleep(2);
		write(fd,str,strlen(str)+1);
		close(fd);
	}

	float avg,sd;

	sleep(2);
	fd = open("f2",O_WRONLY);
	avg = average(end_t,5);
	sprintf(str,"%f",avg);
	printf("In P2 avg : %s\n",str);
	write(fd,str,strlen(str)+1);
	close(fd);

	sleep(2);
	fd = open("f2",O_WRONLY);
	sd = findSD(end_t,5);
	sprintf(str,"%f",sd);
	printf("In P2 avg : %s\n",str);
	write(fd,str,strlen(str)+1);
	close(fd);

	return 0;
}