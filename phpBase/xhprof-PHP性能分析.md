1.ʲô��xhprof������ʲô
��1��xhprof��Facebook��Դ��������PHP���ܷ�������

��2���鿴�ܹ���������Ч�ʣ�����ʱ�䣬������Դ״��

��3���鿴�������ģ��˳�򣬴Ӷ�����Ѹ������ܵĽṹ�����л���

2.xhprof��ҳ��չʾ
 

 

 

3.��װ���ô�򿪷�������
��װxhprof 
(1). ����XHProf��Ŀǰ�����Ϊxhprof-0.9.4.tgz

      wget http://pecl.php.net/get/xhprof-0.9.4.tgz

(2). ��ѹ

      tar -zxvf xhprof-0.9.4.tgz

(3). ����xhprof-0.9.4/extensionִ��phpize

      cd xhprof-0.9.4/extension

      /Data/apps/php/bin/phpize

(4). ִ��configure��ָ��php-config·��

      ./configure --with-php-config=/Data/apps/php/bin/php-config

(5). ִ��

      make

      sudo make install

(6). �޸�php�����ļ�

  sudo vi /Data/apps/php/lib/php.ini

  ����xhprof.so��ָ��XHProf���������ݴ��Ŀ¼

      extension=xhprof.so

      xhprof.output_dir=/tmp/xhprof_data 

      mkdir /tmp/xhprof_data

     ���� php-fpm��

     sudo /Data/apps/php/sbin/php-fpm restart

   

(7). ����puppet�ع�php.ini

    �޸�puppet�����ļ�

    vim /etc/puppet/modules/php/manifests/config.pp
    ɾ�����php.ini�����ã�
    file { '/Data/apps/php/lib/php.ini':  
        ensure => present,

 
        owner => 'root',

 
        group => 'root',

 
        mode => 0644,

 
        content => template("php/php.$template.ini.erb"),

 
        notify => Service['php-fpm'],

 
    }

 
 

 ��װgraphviz
 Graphviz��һ�����������еĻ�ͼ���ߣ�XHProf��ʹ��Graphviz�����������ƺ�������ͼ��
 Graphviz�İ�װ���̺�����linux�����װ���졣ͬ����configure��make��make install�Ȳ��衣

(1). ����Graphviz

      wget http://www.graphviz.org/pub/graphviz/stable/SOURCES/graphviz-2.38.0.tar.gz

(2017.12.18 ������ʧЧ��ʹ�� wget http://graphviz.gitlab.io/pub/graphviz/stable/SOURCES/graphviz.tar.gz)

(2). ��ѹ

      tar -zxvf graphviz-2.38.0.tar.gz

(3). ִ��configure

     cd graphviz-2.38.0

     ./configure

(4). ִ��

    make 

    sudo  make install

(5). ���뻷������

��Ҫע����ǣ���װ�ɹ�����Ҫ��dot�����·�����뵽������������Ϊxhprof���ɺ�������ͼʱ��ֱ��ִ��dot����������ͼƬ��

     sudo vi  /etc/profile

Ȼ������һ�У�

     export PATH=$PATH:/usr/local/bin/ 

ִ��

    source /etc/profile

 (6)�ô�����ļ������޸�

�������п�����нϵͰ汾��xhpro����Ҫ����,

�滻xhprof_runs.php��xhprof_lib.php

���ɱ����������������⣬��Ҫע���˳���

vim ~/xhprof-0.9.4/xhprof_lib/utils/callgraph_utils.php

ɾ����121�������е��˳�

cp ~/xhprof-0.9.4/xhprof_lib/utils/*  /home/dev/svn/sparta/tags/v6.2.6/vendor/lox/xhprof/xhprof_lib/utils/

(7)����������

ln -s /home/dev/xhprof-0.9.4   /home/dev/svn/avatar/trunk/wwwfront/root/xhprof

���������ļ���Ŀ¼ �� mkdir /tmp/xhprof_data

4.ʹ�÷���
 

����ʵ��
 //  ��/home/dev/svn/avatar/trunk/libs/service_common/dal.php�ļ��м���   
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
error_log(date('Y-m-d H:i:s') . ' Xhprofͳ��' . "\n", 3, "/tmp/lihaibin.log");        
$url = 'http://' . $xhprof_root . "/xhprof/xhprof_html/index.php?run=$run_id&source=$source";        
error_log("$url\n", 3, "/tmp/lihaibin.log");        
$s = <<<EOF
<p style="position:absolute;left:0;top:0;padding:8px;background:orange">                
<a href="$url" target="_blank">xhprof</a>                
</p>
EOF;        
echo $s;    
}
 
//ʹ��ʱ
//��root�ļ����µ�index.php�м���
require(__DIR__.'/../assembly.php');
include(__DIR__.'/../mywebapp.php');
$application = new MyWebApplication(__DIR__.'/..');
Dal::xhprof();
$application->run();
 
 5.������
(1)��error_log������ļ���tail�����URL

���磺 http://www.dev.haodf.com/xhprof/xhprof_html/callgraph.php?run=569e20dc17c54&source=youhua
