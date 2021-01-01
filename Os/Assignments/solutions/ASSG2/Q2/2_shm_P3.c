#include "header.h"

int main() 
{ 
 
    key_t key = ftok("shmfile",65); 
  
 
    int shmid = shmget(key,1024,0666|IPC_CREAT); 
  
    sleep(3);
    char *str = (char*) shmat(shmid,(void*)0,0); 
  	
  	printf("%s\n",str );
    int al_num = atoi(str);

    //shmdt(str); 
      
    sleep(10);
    str = (char*) shmat(shmid,(void*)0,0); 
	printf("%s\n",str );
    int spl_chr = atoi(str);
    
    //shmdt(str); 
   
   	printf("In p3 : al_num = %d | spl_chr = %d\n",al_num,spl_chr );
	
	if(al_num >= spl_chr)
	{
		//sleep(15);
		strcpy(str,"Weak");
		str = (char *)shmat(shmid,(void *)0,0);
	}
	else
	{
		//sleep(15);
		strcpy(str,"Strong");
		str = (char *)shmat(shmid,(void *)0,0);
	}

	shmdt(str); 

    return 0; 
}