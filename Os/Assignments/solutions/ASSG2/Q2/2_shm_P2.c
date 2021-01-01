#include "header.h"

int main()
{
	key_t key = ftok("shmfile",65);

	
	int shmid = shmget(key,1024,0666 | IPC_CREAT);

	sleep(1);
	char *str = (char *) shmat(shmid,(void *)0,0);

	printf("Data Read from memory: %s in p2\n",str);
	
	int al_num=0,spl_chr=0;
	for(int i=0;i<strlen(str);i++)
	{
		if(isalnum(str[i]))
			al_num++;
		else
			spl_chr++;
	}

	sleep(2);
	sprintf(str,"%d",al_num);
	//printf("before%s\n",str );
	str = (char *)shmat(shmid,(void *)0,0);
	//printf("after%s\n",str );

	//shmdt(str);

	//key = ftok("shmfile",65);	
	//shmid = shmget(key,1024,0666 | IPC_CREAT);
	sleep(6);
	sprintf(str,"%d",spl_chr);
	//printf("before%s\n",str );
	str = (char *)shmat(shmid,(void *)0,0);
	//printf("after%s\n",str );

	shmdt(str);

	return 0;
}