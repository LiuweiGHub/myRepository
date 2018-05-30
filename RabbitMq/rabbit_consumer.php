<?php
//消费者代码
//创建连接-->创建channel-->创建交换机-->创建队列-->绑定交换机/队列/路由键-->接收消息
//配置信息
$conn_args = [
    'host' => '127.0.0.1',
    'port' => '15672',
    'login' => 'guest',
    'password' => 'guest',
    'vhost' => '/'
];

$e_name = 'e_liuwei'; //交换机名
$q_name = 'q_liuwei'; //队列名
$k_route = 'key_1'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
    die("Cannot connect to the broker!\n");
}

$channel = new AMQPChannel($conn);

//创建交换机
$ex = new AMQPExchange($channel);

$ex->setName($e_name);
$ex->setType(AMQP_EX_TYPE_DIRECT); //direct类型
$ex->setFlags(AMQP_DURABLE); //持久化
echo "Exchange Status:".$ex->declare()."\n";

//创建队列
$q = new AMQPQueue($channel);
$q->setName($q_name);
$q->setFlags(AMQP_DURABLE);
echo "Message TOTAL:".$q->declare()."\n";

//绑定交换机与队列，并指定路由
echo "Queue Bind:".$q->bind($e_name, $k_route)."\n";

//阻塞模式接收消息
echo "Message:\n";
while(True){
    $q->consume('processMessage');
 //   $q->consume('processMessage', AMQP_AUTOACK) //自动ACK应答
}
$conn->disconnect();

/*
 * 消费回调函数
 * 处理消息
 */
function processMessage($envelope, $queue) {
    $msg = $envelope->getBody();
    echo $msg."\n";//处理消息
    $queue->ack($envelope->getDeliverTag()); //手动推送ACK应答
}



//需要注意的地方是：
//queue对象有两个方法可用于取消息：consume和get。前者是阻塞的，无消息时会被挂起，适合循环中使用；
//后者则是非阻塞的，取消息时有则取，无则返回false。
