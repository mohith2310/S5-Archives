#include "header.h"

float average(int a[],int n)
{
	float res=0;
	for(int i=0;i<n;i++)
	{
		res += a[i];
	}

	res = res/(float)n;

	return res;
}

double variance(int a[], int n) 
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

double findSD(int arr[], int n) 
{ 
    return sqrt(variance(arr, n)); 
}

int main()
{

	int fd12[2],fd23[2],fd31[2];

	pipe(fd12);
	pipe(fd23);
	pipe(fd31);

	int n1 = fork();
	int n2 = fork();
	
	if(n1>0 && n2>0)
	{
		//parent
		char temp[3];
		for(int i=0;i<5;i++)
		{
			//send to p2
			sleep(3);
			printf("Enter %d element:",i+1);
			scanf("%s",temp);
			write(fd12[1],temp,3);

			printf("sending %s to p2\n",temp);
		}

		//sleep(3);
		for(int i=0;i<5;i++)
		{
			char str[10];
			sleep(1);
			read(fd31[0],str,10);

			printf("Final elements are %s\n",str);
		}
		//sleep(3);
	}

	else if(n1==0 && n2>0)
	{
		//child1
		char temp[3];

		int a[5];
		for(int i=0;i<5;i++)
		{
			//read from p1
			sleep(2);
			read(fd12[0],temp,3);
			printf("reading from p1 %s done\n",temp);

			a[i] = atoi(temp);

			//send to p3
			sleep(2);
			write(fd23[1],temp,3);
			printf("sending to p3 %s done\n",temp);
		}

		char str[10];

		float avg = average(a,5);
		sprintf(str,"%f",avg);

		sleep(2);
		write(fd23[1],str,strlen(str)+1);
		printf("sending to p3 %s avg\n",str);

		float SD = findSD(a,5);
		sprintf(str,"%f",SD);
	
		sleep(2);
		write(fd23[1],str,strlen(str)+1);
		printf("sending to p3 %s sd\n",str);
	}

	else if(n1>0 && n2==0)
	{
		//child2
		char temp[3];
		float a[5];
		for(int i=0;i<5;i++)
		{
			sleep(1);
			read(fd23[0],temp,3);
		
			a[i] = atoi(temp);
			printf("reading from p2 %f element\n",a[i]);
		}

		char str[10];
		float avg,sd;
		
		sleep(1);
		read(fd23[0],str,10);
		avg = atoi(str);
		printf("reading from p2 %s avg\n",str);
		
		sleep(1);
		read(fd23[0],str,10);
		sd = atoi(str);
		printf("reading from p2 %s sd\n",str);

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

			sleep(1);
			sprintf(str,"%f",a[i]);
			write(fd31[1],str,10);
			printf("sending %s to p1\n",str);
		}
	}
	return 0;
}
