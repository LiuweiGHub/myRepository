<?php
//配置信息
$conn_args = [
    'host' => '127.0.0.1',
    'port' => '15672',
    'login' => 'guest',
    'password' => 'guest',
    'vhost' => '/'
];

$e_name = 'e_liuwei'; //交换机名

$k_route = 'key_1'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
    exit('Cannot connect to the broker!\n');
}

$channel = new AMQPChannel($conn);

//message data
$message = "TEST MESSAGE!测试消息？HELLO WORLD";

//创建交换机对象
$ex = new AMQPExchange($channel);
$ex->setName($e_name);

//发送消息
//$channel->startTransaction(); //开始事务
for($i = 0; $i < 10; $i++) {
    echo "send Message:".$ex->publish($message, $k_route)."\n";
}

//$channel->commitTransaction(); //提交事务
//
$conn->disconnect();
