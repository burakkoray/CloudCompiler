CC = javac
CFLAGS = -g
SOURCES = Main.java

default: main
main: Main.java
	${CC} ${SOURCES} ${CFLAGS} 

run: Main.class
	java Main

clean:
	rm -f *.class
