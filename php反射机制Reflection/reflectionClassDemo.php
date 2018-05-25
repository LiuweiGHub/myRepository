<?php
namespace app;

//注释注释
class Person {
    /*
     * 通过反射机制获取以下数据
     * 常量
     * 属性
     * 方法
     * 静态属性
     * 命名空间
     * 鉴定类是否为final或者abstruct
     */

    /** lsdasd卡视角的理解type=varchar length=255 null */
    private $_allowDynamicAttributes = false; //abcdefg哈哈,我是注释
    protected $id = 0;
    protected $name;
    protected $biography;

    public function getId(){
        return $this->id;
    }

    public function setId($v){
        $this->id = $v;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($v){
        $this->name = $v;
    }

    public function getBiography(){
    return $this->biography;
    }

    public function setBiography($v){
        $this->biography = $v;
    }
}

$class = new \ReflectionClass('app\Person');

//获取属性，不管是否为public
$properties = $class->getProperties();
//输出
/*array(4) {
  [0]=>
  &object(ReflectionProperty)#2 (2) {
    ["name"]=>
    string(23) "_allowDynamicAttributes"
    ["class"]=>
    string(10) "app\Person"
  }
  [1]=>
  &object(ReflectionProperty)#3 (2) {
    ["name"]=>
    string(2) "id"
    ["class"]=>
    string(10) "app\Person"
  }
  [2]=>
  &object(ReflectionProperty)#4 (2) {
    ["name"]=>
    string(4) "name"
    ["class"]=>
    string(10) "app\Person"
  }
  [3]=>
  &object(ReflectionProperty)#5 (2) {
    ["name"]=>
    string(9) "biography"
    ["class"]=>
    string(10) "app\Person"
  }
}*/

//获取特定修饰符的属性,注意 |
$private_properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE|\ReflectionProperty::IS_PROTECTED);
$private_properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE);
//输出
/*
 * array(1) {
  [0]=>
  &object(ReflectionProperty)#10 (2) {
    ["name"]=>
    string(23) "_allowDynamicAttributes"
    ["class"]=>
    string(10) "app\Person"
  }
 }*/

//获取注释
$docComment = $private_properties[0]->getDocComment();
$a = $private_properties[0];
$doc = $a->getDocComment();

//获取方法并执行
$instance = $class->newInstanceArgs();
$ec = $class->getMethod('setName');
$ec->invoke($instance, 'ppp');
var_dump($instance);
//输出
/*
 *object(app\Person)#9 (4) {
  ["_allowDynamicAttributes":"app\Person":private]=>
  bool(false)
  ["id":protected]=>
  int(0)
  ["name":protected]=>
  string(3) "ppp"
  ["biography":protected]=>
  NULL
 }*/
