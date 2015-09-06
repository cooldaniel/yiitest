
# PHP基础

1.在函数中使用static变量不错和类的静态属性作用一样。

2.函数是功能单元，类是行为和数据的封装。

3.web和cls两种情况的$_SERVER['DOCUMENT_ROOT']不一样。

4.$_SERVER["HTTP_REFERER"]困惑

	链接到当前页面的前一页面的 URL 地址。不是所有的用户代理（浏览器）都会设置这个变量，  
	而且有的还可以手工修改 HTTP_REFERER。因此，这个变量不总是真实正确的。
	
	只有点击超链接（即<A href=...>） 打开的页面才有HTTP_REFERER环境变量， 其它如 window.open()、    
	window.location=...、window.showModelessDialog()等打开的窗口都没有HTTP_REFERER 环境变量。

5.PECL

	PECL是一个php扩展库，通过PEAR包起作用。
	设计pear命令：pear命令同样适用于pecl。
	加载php扩展的方法：（1）在php.ini文件中使用extension指令；（2）使用dl()函数。
	使用SVN更新自己的php模块：通过SVN可以访问最新的php源文件目录树，这样可以获取最新的php更改动态，这有助于及时升级自己的php，
	而不用等到官方正式发布正式版；风险是可能获取的最新动态可能不稳定或者有错误。要将获取的php动态更新到自己的php中，
	需要autoconf, automake, libtool这些工具，参见http://php.net/svn.php。
	PECL官网：http://pecl.php.net/，使用pecl命令下载。也可以在SVN网站http://svn.php.net/viewvc/pecl/下载，此时使用命令：
	$ svn checkout http://svn.php.net/repository/pecl/extname/trunk extname
	windows下pear安装：http://hi.baidu.com/zr443/blog/item/5cfbfdf360ebb557342acc14.html

