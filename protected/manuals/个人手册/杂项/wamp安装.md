# wamp安装

## apache 2.4

1.[下载](<http://www.apachelounge.com/download/>)，解压到C:\Program Files\Apache24.

2.下载安装vcredist:

 -	[vcredist_x86.exe](<http://www.microsoft.com/zh-cn/download/confirmation.aspx?id=5638>).
 -	[vcredist_64.exe](<http://www.microsoft.com/zh-cn/download/confirmation.aspx?id=30679>).

3.安装路径修改: 修改文件C:\Program Files\Apache24\conf\httpd.conf，将其中的C:\Apache24路径修改为C:\Program Files\Apache24.

4.安装: 打开cmd（管理员权限），cd到目录C:\Program Files\Apache24\bin下执行：httpd -k install.

5.应用配置:

	LoadModule rewrite_module modules/mod_rewrite.so
	LoadModule log_config_module modules/mod_log_config.so
	LoadModule php5_module "C:/Program Files/php/php5apache2_4.dll"
	PHPIniDir "C:/Program Files/php"
	
	<Directory />
		AllowOverride none
		Require all granted
	</Directory>
	
	<IfModule dir_module>
		DirectoryIndex index.php index.html
	</IfModule>
	
	<IfModule mime_module>
		AddType application/x-httpd-php .php
	</IfModule>
	
	Include conf/extra/httpd-vhosts.conf

6.虚拟主机配置
    
    <VirtualHost *:80>
        DocumentRoot "D:/php/projects/test"
        ServerName www.hi.com
        ServerAlias hi.com
        
        <Directory "D:/php/projects/test">
            AllowOverride All
            Require all granted
        </Directory>
        
        ErrorLog "logs/hi.log"
        CustomLog "logs/hi-access.log" common
    </VirtualHost>

## php 5.4

1.下载[线程安全版](<http://windows.php.net/download/#php-5.4>)，解压到C:\Program Files\php.

2.应用配置:

	extension_dir = "C:/Program Files/php/ext"
	date.timezone = "Asia/Shanghai"
	include_path = ".;C:\Program Files\php\pear"

## php pear

## php markdown

1.[下载](<https://github.com/michelf/php-markdown>).





