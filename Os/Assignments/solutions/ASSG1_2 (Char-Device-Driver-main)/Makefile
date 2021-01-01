obj-m+=encdev.o
obj-m+=decdev.o

all: test
	make -C /lib/modules/$(shell uname -r)/build M=$(PWD) modules
clean:
	make -C /lib/modules/$(shell uname -r)/build M=$(PWD) clean
	rm encrypt
	rm decrypt
	rm encryption.enc
	rm key
test: test_enc.c test_dec.c 
	gcc -o encrypt test_enc.c
	gcc -o decrypt test_dec.c
