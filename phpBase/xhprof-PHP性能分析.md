1.什么是xhprof，能做什么
（1）xhprof是Facebook开源的轻量级PHP性能分析工具

（2）查看架构代码运行效率，消耗时间，消耗资源状况

（3）查看框架运行模块顺序，从而可以迅速理解框架的结构，运行机制

2.xhprof的页面展示
 

 

 

3.安装（好大夫开发环境）
安装xhprof 
(1). 下载XHProf，目前最近版为xhprof-0.9.4.tgz

      wget http://pecl.php.net/get/xhprof-0.9.4.tgz

(2). 解压

      tar -zxvf xhprof-0.9.4.tgz

(3). 进入xhprof-0.9.4/extension执行phpize

      cd xhprof-0.9.4/extension

      /Data/apps/php/bin/phpize

(4). 执行configure，指定php-config路径

      ./configure --with-php-config=/Data/apps/php/bin/php-config

(5). 执行

      make

      sudo make install

(6). 修改php配置文件

  sudo vi /Data/apps/php/lib/php.ini

  引入xhprof.so并指定XHProf的性能数据存放目录

      extension=xhprof.so

      xhprof.output_dir=/tmp/xhprof_data 

      mkdir /tmp/xhprof_data

     重启 php-fpm：

     sudo /Data/apps/php/sbin/php-fpm restart

   

(7). 避免puppet回滚php.ini

    修改puppet配置文件

    vim /etc/puppet/modules/php/manifests/config.pp
    删掉监控php.ini的配置：
    file { '/Data/apps/php/lib/php.ini':  
        ensure => present,

 
        owner => 'root',

 
        group => 'root',

 
        mode => 0644,

 
        content => template("php/php.$template.ini.erb"),

 
        notify => Service['php-fpm'],

 
    }

 
 

 安装graphviz
 Graphviz是一个基于命令行的绘图工具，XHProf中使用Graphviz的命令来绘制函数调用图。
 Graphviz的安装过程和其他linux软件安装无异。同样是configure、make、make install等步骤。

(1). 下载Graphviz

      wget http://www.graphviz.org/pub/graphviz/stable/SOURCES/graphviz-2.38.0.tar.gz

(2017.12.18 链接已失效，使用 wget http://graphviz.gitlab.io/pub/graphviz/stable/SOURCES/graphviz.tar.gz)

(2). 解压

      tar -zxvf graphviz-2.38.0.tar.gz

(3). 执行configure

     cd graphviz-2.38.0

     ./configure

(4). 执行

    make 

    sudo  make install

(5). 引入环境变量

需要注意的是，安装成功后需要将dot命令的路径加入到环境变量，因为xhprof生成函数调用图时会直接执行dot命令来生成图片。

     sudo vi  /etc/profile

然后增加一行：

     export PATH=$PATH:/usr/local/bin/ 

执行

    source /etc/profile

 (6)好大夫框架文件引入修改

由于现有框架中有较低版本的xhpro，需要覆盖,

替换xhprof_runs.php和xhprof_lib.php

依旧报错是由于字体问题，需要注释退出。

vim ~/xhprof-0.9.4/xhprof_lib/utils/callgraph_utils.php

删除第121行括号中的退出

cp ~/xhprof-0.9.4/xhprof_lib/utils/*  /home/dev/svn/sparta/tags/v6.2.6/vendor/lox/xhprof/xhprof_lib/utils/

(7)制作软链接

ln -s /home/dev/xhprof-0.9.4   /home/dev/svn/avatar/trunk/wwwfront/root/xhprof

创建生成文件的目录 ： mkdir /tmp/xhprof_data

4.使用方法
 

代码实例
 //  在/home/dev/svn/avatar/trunk/libs/service_common/dal.php文件中加入   
public static function xhprof()
{        
static::xhprofstart();        
register_shutdown_function(array("Dal", "xhprofend"));    
}
public static function xhprofstart() {        
xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);    
}
public static function xhprofend() {        
$xhprof_data = xhprof_disable();        
$xhprof_runs = new XHprofRuns_Default();        
$source = 'youhua';        
$run_id = $xhprof_runs->save_run($xhprof_data, "$source");        
$xhprof_root = 'www.dev.haodf.com';
error_log(date('Y-m-d H:i:s') . ' Xhprof统计' . "\n", 3, "/tmp/lihaibin.log");        
$url = 'http://' . $xhprof_root . "/xhprof/xhprof_html/index.php?run=$run_id&source=$source";        
error_log("$url\n", 3, "/tmp/lihaibin.log");        
$s = <<<EOF
<p style="position:absolute;left:0;top:0;padding:8px;background:orange">                
<a href="$url" target="_blank">xhprof</a>                
</p>
EOF;        
echo $s;    
}
 
//使用时
//在root文件夹下的index.php中加入
require(__DIR__.'/../assembly.php');
include(__DIR__.'/../mywebapp.php');
$application = new MyWebApplication(__DIR__.'/..');
Dal::xhprof();
$application->run();
 
 5.打开链接
(1)在error_log输出的文件中tail输出的URL

例如： http://www.dev.haodf.com/xhprof/xhprof_html/callgraph.php?run=569e20dc17c54&source=youhua
