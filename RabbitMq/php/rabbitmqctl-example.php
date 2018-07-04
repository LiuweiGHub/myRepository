<?php
$conn_args = [
    'host' => '127.0.0.1',
    'port' => '15672',
    'login' => 'guest',
    'password' => 'guest',
    'vhost' => '/'
];

$conn = new AMQPConnection($conn_args);
var_dump($conn->connect());exit;

$channel = new AMQPChannel($conn);
var_dump($channel);exit;
