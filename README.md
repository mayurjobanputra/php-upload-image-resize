# PHP Resize Upload Image File

An adaption of Joe Lau's script located at https://github.com/joelau71/php-upload-image-resize

UploadResizeImage - is the free and make upload image file resize easily

<h1>How to use</h1>
1. Take all the files in this repo and drop it into a public folder on your WAMP server
2. Visit the folder you just made in your web browser
3. Smile

### mode:(According to the percentage of targetWidth and targetHeight set)<br>
default: cover<br>
cover: It will crop the image, but there will be no white or transparent background color.<br>
contain: No crop, but white or transparent background color<br>
byWidth: zoom according to width<br>
byHeight: Scale according to height<br>
autoHeight: Scale according to width, but the height is not targetHeight, but the height based on the percentage of width<br>

### property:
Default: According the width resize image<br>
If provide targetHeight value, it will have cropped effect

## If you upload no result, try to change php.ini file settings as below.

- upload_max_filesize = 64M
- post_max_size = 64M
- max_execution_time = 300
- memory_limit = 256M
