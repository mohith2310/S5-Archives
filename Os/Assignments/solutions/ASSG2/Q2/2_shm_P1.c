#include "header.h"

int main()
{
	key_t key = ftok("shmfile",65);

	int shmid = shmget(key,1024,0666 | IPC_CREAT );

	//sleep(1);
	char *str = (char *)shmat(shmid,(void *)0,0);
	printf("Enter data: \n");
	scanf("%s",str);
	
	printf("Written in memory in p1:%s\n",str);

	//shmdt(str);

	sleep(20);
	str = (char *) shmat(shmid,(void *)0,0);
	printf("Strength of password is : %s\n",str);

	shmdt(str);
	shmctl(shmid,IPC_RMID,NULL); 

	return 0;
}