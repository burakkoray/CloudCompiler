#include <stdio.h>
int main()
{
  
  printf("Hello World!!!\n");
  FILE *ptr_file;
		int x;

		ptr_file =fopen("input.txt", "w");

		if (!ptr_file)
			return 1;

		for (x=1; x<=10; x++)
			fprintf(ptr_file,"%d\n", x);

		fclose(ptr_file);
	
	return 0;
}