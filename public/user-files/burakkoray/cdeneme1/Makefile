CC = gcc
CFLAGS = -Wall -O3
SOURCES = main.c

default: main
main: main.c
	${CC} ${SOURCES} ${CFLAGS} -o exec

run: exec
	./exec

clean:
	rm -f exec
