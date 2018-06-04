To wen:
一、技术选型

- Laravel5.5 [目前最新5.6]
- Laravel Homestead虚拟机[避免调试本地环境，实现快速开发]

二、Homestead安装

   如果你不使用 Homestead，则需要确保你的服务器符合以下要求：

- PHP >= 7.0.0
- PHP OpenSSL 扩展
- PHP PDO 扩展
- PHP Mbstring 扩展
- PHP Tokenizer 扩展
- PHP XML 扩展

  homestead集成了laravel运行需要的所有条件，debug不必再担心环境问题。使用ruby实现。安装详细流程：http://oomusou.io/laravel/homestead/homestead-macos/

```php
//安装homestead时报错 ：OpenSSL SSL_read: SSL_ERROR_SYSCALL, errno 54
vagrant box add laravel/homestead -c --insecure  
//-c或--clean清除任何临时下载文件
//--insecure 不要验证SSL证书
```





二、安装laravel

Laravel 利用 [Composer](https://getcomposer.org/) 来管理依赖。所以，在使用 Laravel 之前，请确保你的机器上安装了 Composer。

