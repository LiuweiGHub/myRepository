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

 ```composer
composer create-project laravel/laravel laravel56 --prefer-dist
//laravel56为项目名称
//--prefer-dist 下载指定版本，默认会下载最新稳定版本

//下载指定版本，eg: 5.5
composer create-project laravel/laravel laravel55 5.5.* --prefer-dist

 ```

修改homestear.yaml文件后，需要重新启动vituralbox,命令如下：

```
vagrant provision && vagrant reload
```

然后浏览器输入 homestead.test 即可访问laravel框架



三、vagrant常用命令及注意事项

- vagrant up   启动Ubuntu || 重建homestead
- Vagrant halt  关机
- vagrant destroy —force   删除homestead
- vagrant provision  重启provision
- vagrant reload     重启Ubuntu

注意事项：

- Homestead跑的就是Ubuntu，若我們想讓Ubuntu關機，也須依照正常程序關機，否则很容易造成VM損毀。
- Homestead雖然好用，但有一個致命傷 : **非常耗電**，建議外出使用筆記型電腦時，若沒開發Laravel，一定要記得關閉Homestead。




> Laravel项目部署及valet后续再研究



## 核心架构

### 1.请求周期

- 创建应用程序实例
- 注册服务提供器
- 将请求交给被引导的应用程序

### 2.服务容器

- 用于管理类的依赖和执行依赖注入的工具【依赖注入：类的依赖项通过构造函数，或者setter方法注入到类中】
- 几乎所有的服务容器都是在服务提供器中注册绑定的

### 3.服务提供器

- 服务提供器是所有laravel应用程序的引导[注册®️]中心，包括laravel自己的所有核心服务
- Config/app.php 中 providers数组为应用程序要加载的所有服务提供器
- 许多服务提供器并不会在每次请求时都被加载，实际需要时才会被加载【延迟加载】

### 4.Facades

- 读音 /fəˈsäd/
- 为应用程序的服务容器中可用的类提供了一个静态接口
- Facades实际上是服务容器中底层类的【静态代理】，提供了简介而又富有表现力的语法
- Facades比传统的静态方法更具可测试性和扩展性
- 注意：
  - 最主要的风险：会引起类作用范围的膨胀
  - 所以使用Facades时，要特别注意控制好类的大小，让类的作用范围保持短小

**Facades工作原理**：在laravel应用中，Facade就是一个可以从容器访问对象的类。核心部件Facade类，Facade基类使用了__callStatic()魔术方法将Facades调用延迟，直到对象从容器中被解析出来。

### 5.契约（Contracts）

- laravel的契约是一组定义框架提供的核心服务的接口
- 框架对每个契约都提供了相应的实现
- 所有的laravel契约都有自己的GitHub库，这为所有可用的契约提供了快速参考指南，同时也可单独作为低耦合的扩展包给其他开发者使用
- 在大多数情况下，每个Facades都有一个等效的契约

## 基础功能

### 1.路由

### 2.中间件

### 3.CSRF保护

- CSRF，跨站请求伪造攻击，指请求者凭借已通过身份验证的用户身份来运行未经过授权的命令
- laravel会自动为每个活跃用户的会话生成一个CSRF令牌，该令牌用于验证经过身份验证的用户是否是向应用程序发出请求的用户
- 任何情况下当你在应用程序中定义 HTML 表单时，都应该在表单中包含一个隐藏的 CSRF 令牌字段，以便 CSRF 保护中间件可以验证该请求。可以使用辅助函数 `csrf_field` 来生成令牌字段

### 4.控制器

### 5.请求

### 6.响应

### 7.视图

### 8.URL

### 9.Session

### 10.表单验证

### 11.错误与日志



