CC = gcc
CFLAGS1 = -Wall -g -c
CFLAGS2 = -g
# Link the two object files together.
main: main.o %s
	${CC} ${CFLAGS2} -o main main.o Functions.o
# Compile each source file to an object.
main.o: main.c
	${CC} ${CFLAGS1} -o main.o main.c

Functions.o: Functions.c
	${CC} ${CFLAGS1} -o Functions.o Functions.c

run: gcc -c main.c

clean:
	rm -f main
