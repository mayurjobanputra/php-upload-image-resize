UPDATE: At the moment, this script doesn't work and I'm unsure why. I'm getting blank, white images during upload. I hope to fix that soon. 

# A self-hosted PHP Script to resize images

This is an adaption of Joe Lau's script located at https://github.com/joelau71/php-upload-image-resize.

This script takes any image that you upload, resizes the image (defaults 1200 pixels wide or 1200 pixels high) and redirects you to the new image made. This script is useful for quick image resizing online without needing to use a desktop app.

# How to use
1. Take all the files in this repo and drop it into a public folder on your WAMP server<br>
2. Visit the folder you just made in your web browser<br>
3. Smile<br>

# Demo?

Visit http://mayur.ca/image-resize

# Security Note

DO NOT remove the .htaccess from the images folder or the images folder. This is very important as it prevents rogue users from uploading a php file and executing it. Some suggestions also say to use the following in addition the two lines I already provided in the .htaccess file. In my case, I found that when I did that in a Wordpress subfolder, I was getting a 404 (I guess Wordpress takes over)<br>

<code>php_flag engine off</code>

