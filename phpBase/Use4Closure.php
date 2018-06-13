<?php
function getMoney() {
    $rmb = 1;
    $dollar = 8;
    $func = function() use ($rmb, $dollar, $yen) {
        echo $rmb."\n";
        echo $dollar."\n";
        echo $yen;
    };
    $yen = 10000; //变量在匿名函数下面定义，即使use引用也不能输出
    $func();
}
getMoney();


//使用匿名函数是否可以更改上文变量？不能
function getMoneyNew() {
    $rmb = 1;
    $func = function() use (&$rmb) {
        echo $rmb;
        $rmb++;
    };
    $func();
    echo $rmb;
}
getMoneyNew();

//将匿名函数返回给外界，匿名函数会保存use所引用的变量
function getMoneyFunc() {
    $ren = 1000;
    $func = function() use (&$ren) {
        echo $ren;
        $ren += 1000;
    };
    return $func;
}
$getMoney = getMoneyFunc();
$getMoney();
$getMoney();
$getMoney();
$getMoney();
