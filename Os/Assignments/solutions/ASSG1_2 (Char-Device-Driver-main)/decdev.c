#include <linux/module.h>
#include <linux/string.h>
#include <linux/fs.h>
#include <linux/uaccess.h>
#include <linux/init.h>
#include <linux/device.h>
#include <linux/kernel.h>
#include <linux/slab.h>
#include <linux/kfifo.h>

#define DEVICE_NAME "decdev"
#define MAJOR_NUMBER 185

MODULE_LICENSE("GPL");

static int my_open(struct inode *, struct file *);
static int my_close(struct inode *, struct file *);
static ssize_t my_read(struct file *, char *, size_t, loff_t *);
static ssize_t my_write(struct file *,  const char *, size_t, loff_t *);
static int write_call = 0;
static int file_opens = 0;
static int major_number;
char key[256] = {0};
char encrypted_data[256] = {0};
static int encrypt_index = 0;
static int num_writes = 0;
static struct file_operations file_ops = 
{
	.read = my_read,
	.write = my_write,
	.open = my_open,
	.release = my_close,
};

static int __init decdev_init(void)
{
	major_number = register_chrdev(MAJOR_NUMBER, DEVICE_NAME, &file_ops);
	if (major_number >= 0) printk(KERN_INFO "decdev: Device Registered\n");
	else printk(KERN_INFO "decdev: Device Registration failed\n");
	return 0;
}

static void __exit decdev_exit(void)
{
	unregister_chrdev(MAJOR_NUMBER, DEVICE_NAME);
	printk(KERN_INFO "decdev: Unregistered the device\n");
}

static ssize_t my_write(struct file *fp, const char *buffer, size_t length, loff_t *offset)
{
	int message_index = length - 1;
	int g = 0, error = 0;
	char encrypt[256];
	if (write_call == 0)
	{
		copy_from_user(key, buffer, length);
		write_call = 1;
		return 1;
	}	
	error = copy_from_user(encrypt, buffer, length);
	if (error == 0)
	{
		printk(KERN_INFO "decdev: Successfully decrypted block %d of data", num_writes+1);
	}
	else
	{
		printk(KERN_INFO "decdev: Failed to decrypt block %d of data", num_writes+1);	
		return 0;
	}
	for ( ; encrypt_index < num_writes * 16 + length ; ++encrypt_index)
	{
		
		char temp = encrypt[g];
		encrypted_data[encrypt_index] = (int)encrypt[g] ^ (int)key[g];
		key[g++] = temp;
	}
	num_writes++;
	return message_index;
}

static int my_open(struct inode *ip, struct file *fp)
{
	file_opens++;
	printk(KERN_INFO "decdev: device was opened\n");
	return 0;
}

static int my_close(struct inode *ip, struct file *fp)
{
	printk(KERN_INFO "decdev: device was closed\n");
	write_call = 0;
	num_writes = 0;
	encrypt_index = 0;
	return 0;
}

static ssize_t my_read(struct file *fp, char *buffer, size_t length, loff_t *offset)
{
	int error = 0;
	encrypted_data[encrypt_index] = '\0';
	error = copy_to_user(buffer, encrypted_data, encrypt_index);
	if (error == 0)
	{
		printk(KERN_INFO "decdev: Successfully read decrypted data");
		return 0;
	}
	else
	{
		printk(KERN_INFO "decdev: Failed to read decrypted data");
		return -EFAULT;
	}
}

module_init(decdev_init);
module_exit(decdev_exit);
