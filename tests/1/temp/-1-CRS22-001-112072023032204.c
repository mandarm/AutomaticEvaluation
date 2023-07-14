/*
 * C Program to Print Diamond Pattern using For Loop
 */
 
  #include <stdio.h>
#include <stdlib.h>
#include <string.h>
 
int main(int argc, char* argv[])
{

    FILE *fp = fopen(argv[1], "r")
    
    if(fp == NULL) {
         perror("Unable to open input file!");
         exit(1);
    }
 	char *line = NULL;
 	size_t len = 0;

	getline(&line, &len, fp);

   	int number=atoi(line), i, k, count = 0;
 
    for(i=1;i<=number;i++){
    	
    	printf("%d\n ",i);
    	
    }
    printf("\n");
    
   
      fclose(fp); 
      free(line);
      return 0;
}


