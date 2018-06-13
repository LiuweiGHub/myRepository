<?php
require 'student.php';
require 'study.php';
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



## 情况一
/*try {
    $stu = make('Student', ['id' => 1, 'name'=>'li']);
    print_r($stu);
    $stu->study();
} catch(Exception $e) {
    echo $e->getMessage();
}*/

try {
    $stu = make('Student', ['id' => 1, 'name'=>'li', 'study'=> new Study]);
    print_r($stu);
    $stu->study();
} catch(Exception $e) {
    echo $e->getMessage();
}
