#include <linux/module.h>
#include <linux/string.h>
#include <linux/fs.h>
#include <linux/uaccess.h>
#include <linux/init.h>
#include <linux/device.h>
#include <linux/kernel.h>
#include <linux/slab.h>
#include <linux/kfifo.h>

#define DEVICE_NAME "encdev"
#define MAJOR_NUMBER 184

MODULE_LICENSE("GPL");

static int my_open(struct inode *, struct file *);
static int my_close(struct inode *, struct file *);
static ssize_t my_read(struct file *, char *, size_t, loff_t *);
static ssize_t my_write(struct file *,  const char *, size_t, loff_t *);
static int write_call = 0;
static int num_writes = 0;
static int file_opens = 0;
static int major_number;
char key[256] = {0};
char encrypted_data[256];
static int encrypt_index = 0;
static struct file_operations file_ops = 
{
	.read = my_read,
	.write = my_write,
	.open = my_open,
	.release = my_close,
};

static int __init encdev_init(void)
{
	major_number = register_chrdev(MAJOR_NUMBER, DEVICE_NAME, &file_ops);
	if (major_number >= 0) printk(KERN_INFO "encdev: Device Registered\n");
	else printk(KERN_INFO "encdev: Device Registration failed\n");
	return 0;
}

static void __exit encdev_exit(void)
{
	unregister_chrdev(MAJOR_NUMBER, DEVICE_NAME);
	printk(KERN_INFO "encdev: Unregistered the device\n");
}

static ssize_t my_write(struct file *fp, const char *buffer, size_t length, loff_t *offset)
{
	int message_index = length - 1;
	char encrypt[256];
	int g = 0, error = 0;
	if (write_call == 0)
	{
		copy_from_user(key, buffer, length);
		write_call = 1;
		return 1;
	}	
	error = copy_from_user(encrypt, buffer, length);
	if (error == 0)
	{
		printk(KERN_INFO "decdev: Successfully encrypted block %d of data", num_writes+1);
	}
	else
	{
		printk(KERN_INFO "decdev: Failed to encrypt block %d of data", num_writes+1);	
		return 0;
	}
	for ( ; encrypt_index < num_writes * 16 + length ; ++encrypt_index)
	{
		encrypted_data[encrypt_index] = (int)encrypt[g] ^ (int)key[g];
		key[g++] = encrypted_data[encrypt_index];
	}
	num_writes++;
	return message_index;
}

static int my_open(struct inode *ip, struct file *fp)
{
	file_opens++;
	printk(KERN_INFO "encdev: device was opened\n");
	return 0;
}

static int my_close(struct inode *ip, struct file *fp)
{
	printk(KERN_INFO "encdev: device was closed\n");
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
		printk(KERN_INFO "encdev: Read the encrypted text successfully\n");
		return 0;
	}
	else
	{
		printk(KERN_INFO "encdev: Failed to read the encrypted text\n");
		return -EFAULT;
	}
}

module_init(encdev_init);
module_exit(encdev_exit);
