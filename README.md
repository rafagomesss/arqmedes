![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![version](https://img.shields.io/badge/v.8.2-php-blueviolet)




Xampp v.3.3.0



#### C:\xampp\apache\conf\extra\httpd-vhosts.conf
```xml
<VirtualHost *:80>
    DocumentRoot "C:/arqmedes/app/public"
    ServerName www.arqmedes.com.br
    <Directory "C:/arqmedes/app/public">
        Options All
	  AllowOverride All
	  Require all granted
    </Directory>
</VirtualHost>
```

#### C:\Windows\System32\drivers\etc\hosts
```
127.0.0.1	www.arqmedes.com.br
```

