# PHP反射机制介绍

Php Reflection API是PHP5才有的新功能，它是用来导出或提取关于类、方法、属性、参数等的详细信息，包括注释。

常用的就只有两个，**ReflectionClass**和**ReflectionObject**，前者针对类，后者针对对象，后者是继承前者的类；然后其中又有一些属性或方法能返回对应的reflection对象。

PHP反射机制，对类、接口、函数、方法和扩展进行反向工程的能力。

分析类、接口、函数和方法的内部结构，方法和函数的参数，以及类的属性和方法。



常用的几个类：

- ReflectionClass解析类
- ReflectionProperty类的属性的相关信息
- ReflectionMethod类方法的有关信息
- ReflectionParameter取回函数或方法参数的相关信息
- ReflectionFunction 一个函数的相关信息

示例类

```php
class Student
{
    public $id;
    
    public $name;

    const MAX_AGE = 200;

    public static $likes = [];

    public function __construct($id, $name = 'li')
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function study()
    {
        echo 'learning...';
    }

    private function _foo()
    {
        echo 'foo';
    }

    protected function bar($to, $from = 'zh')
    {
        echo 'bar';
    }
}
```



# ReflectionClass

```php
//ReflectionClass
$ref = new ReflectionClass('student');

//判断类是否可实例化
if($ref->isInstantiable()){
    echo "可实例化";
}

//获取构造函数，有返回ReflectionMethod对象，没有返回null
$constructor = $ref->getConstructor();

//获取某个属性
if ($ref->hasProperty('id')) {
    $attr = $ref->getProperty('id');
}

//获取属性列表
$attributes = $ref->getProperties();
foreach ($attributes as $row){
    echo $row->getName()."\n";
}

//获取静态属性，返回数组
$static = $ref->getStaticProperties();

//获取某个常量
if ($ref->hasConstant('MAX_AGE')) {
    $const = $ref->getConstant('MAX_AGE');
}

//获取所有常量
$constants = $ref->getConstants();

//获取某个方法
if ($ref->hasMethod('bar')) {
    $method = $ref->getMethod('bar');
}

//获取方法列表
$methods = $ref->getMethods();
```



# ReflectionProperty

```php
if ($ref->hasProperty('name')) {
  $attr = $ref->getProperty('name');
  //属性名称
  echo $attr->getName();
  //类定义时属性为真，运行时添加的属性为假
  var_dump($attr->isDefault());
  //判断属性访问权限
  $attr->isPrivate();
  $attr->isPublic();
  $attr->isProtected();
  //判断属性是否为静态
  $attr->isStatic();
}
```

# ReflectionMethod & ReflectionParameter

```php
$method = $ref->getMethod('bar');
//对方法的判断
//isAbstruct()
//isConstructor()
//isDestructor()
//isFinal()
//isPrivate()
//isPublic()
//isProtected()
//isStatic()

//获取参数列表
$parameters = $method->getParameters();
foreach ($parameters as $row) {
    echo $row->getName();
    echo $row->getClass();
 	
    //检查是否有默认值
    if ($row->isDefaultValueAvailable()) {
        echo $row->getDefaultValue();
    }
  
    //获取变量类型
    if ($row->hasType()) {
        echo $row->getType();
    }
}

```

# ReflectionFunction & ReflectionParameter

```php
$fun = new ReflectionFunction('demo');
echo $fun->getName();
$parameters = $fun->getParameters();
foreach ($parameters as $row) {
    // 这里的 $row 为 ReflectionParameter 实例
    echo $row->getName();
    echo $row->getClass();

    // 检查变量是否有默认值
    if ($row->isDefaultValueAvailable()) {
        echo $row->getDefaultValue();
    }

    // 获取变量类型
    if ($row->hasType()) {
        echo $row->getType();
    }
}
```

# 综合实例

使用反射实例化类

```Php
//student.php
class Student
{
    public $id;
    
    public $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function study()
    {
        echo 'learning.....';
    }

}
```

一般情况下，实例化类的时候可以直接new，但是我们现在不用这种方法，我们使用反射来实现。

```Php
//index.php
require 'student.php';
function make($class, $vars = [])
{
    $ref = new ReflectionClass($class);
  
    if ($ref->isInstantiable()) {
        $constructor = $ref->getConstructor();
        if (is_null($constructor)) {
            return new $class;
        }
      
        //获取构造函数参数
        $params = $constructor->getParameters();
        $resolveParams = [];
        foreach ($params as $key => $param) {
            $name = $param->getName();
            if (isset($vars[$name])) {
                //判断如果是传递的参数，直接使用传递参数
                $resolveParams[] = $vars[$name];
            } else {
                //没有传递参数的话，检查是否有默认值，没有默认值的话，按照类名进行递归解析
                $default = $param->isDefaultValueAvailable() ? $param->isDefaultValueAvailable() : null;
                if (is_null($default)) {
                    if ($param->getClass()) {
                        $resolveParams[] = make($value->getClass()->name, $vars);
                    } else {
                        throw new Exception("{$name}没有传值且没有默认值");
                    }
                } else {
                     $resolveParams[] = $default;
                }
            }
        }
        //根据参数实例化
        return $ref->newInstanceArgs($resolveParams);
    } else {
        throw new Exception("类 {$class} 不存在");
    }
}
```

