CC = gcc
CFLAGS = -Wall -O3
SOURCES = main.c deneme.c

default: main
main: main.c
	${CC} ${SOURCES} ${CFLAGS} -o exec

run: main
	./exec

clean:
	rm -f exec
