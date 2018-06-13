<?php
//匿名函数
$anonyFunc = function ($name) {
    return 'Hello '.$name;
};
echo $anonyFunc("Join");
echo "\n";
echo $anonyFunc->__invoke("Josh");
echo "\n";
//闭包
//例子一：在函数里定义一个匿名函数，并调用它

function printStr() {
    $func = function($str){
        echo $str;
    }; //；结束符非常关键
    $func('hello world, I am Chinese');
}
printStr();
echo "\n";

//例子二：在函数中把匿名函数返回并调用它
function getPrintStrFunc() {
    $func = function($str) {
        echo $str;
    };
    return $func;
}
$printStrFunc = getPrintStrFunc();//调用方法必须加括号（），否则不生效
$printStrFunc('I love China!');
echo "\n";

//例子三：把匿名函数当做参数传递，并且调用它
function callFunc($func) {
    $func('Where are you from?');
}
$printStrFunc = function($str) {
    echo $str;
}; //还是注意分号！说白了，匿名函数就是变量值的一种类型
callFunc($printStrFunc);
echo "\n";

//也可以直接将匿名函数进行传递。如js
callFunc(function($str) {
    echo $str;
});

//以上输出值为：
/*
Hello Join
Hello Josh
hello world, I am Chinese
I love China!
Where are you from?
Where are you from?
*/
