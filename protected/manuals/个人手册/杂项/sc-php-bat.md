

sc-php-start.bat
-----------------------------

	:: Bat file for PHP related services' starting
	:: @since 2012-05-30
	
	SC START apache2.4
	SC START mysql
	
	:: Do seperate the path info and the file name by suing argument "/D"
	START /D "C:\Program Files\Apache24\bin\" ApacheMonitor.exe
	
	EXIT



sc-php-stop.bat
------------------------------

	:: Bat file for PHP related services' stopping
	:: @since 2012-05-30
	
	SC STOP apache24
	SC STOP mysql
	
	:: Just use the name but not including the path of the pragrame
	TASKKILL /F /IM ApacheMonitor.exe /T
	
	EXIT