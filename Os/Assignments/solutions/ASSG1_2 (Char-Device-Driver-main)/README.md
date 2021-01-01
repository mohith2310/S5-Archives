Pre-requisites - 

Latest compiled Linux Kernel.
The latest stable Linux kernel can be downloaded from https://www.kernel.org/. kernel.org is the main distribution point of source code for the Linux kernel, which is the base of the Linux operating system.The latest version is Linux-5.8.14(as of now) and one can retrieve it using wget (retrieves content from web servers) in the required directory.

................................................................................................................................................................

Steps to be followed for execution:

a) Boot the Linux kernel which was compiled through GRUB and selected the Kernel we compiled. To access the GRUB : Long press the SHIFT key while it is booting. This launches the GRUB menu.			

b) Open Terminal. And install the relevant Linux Headers. Using the command:
$ sudo apt-get install linux-headers-$(uname -r) 
This is just to ensure you have the relevant header files installed for successful compilation and execution.

c) run setup.sh after giving it appropriate permissions. This will create the character devices encdev and decdev. This will also run the makefile. The makefile will create executables for the test programs as well. This will then insert the modules as well.

d) run run.sh to compile test_enc.c and test_dec.c to generate the object files

e) run the corresponding user object files to test the functionality and correctness of the Character Driver




