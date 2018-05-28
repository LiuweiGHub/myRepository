# PHP的生成器(generator)的概念和用法
## 迭代
迭代即指反复执行一个过程，每执行一次叫做一次迭代；例如foreach()；
这样可以通过外部遍历其内部数据的对象就是一个迭代对象，其遵循的接口【统一访问接口】就是迭代**生成器**【Iterator】
生成器提供了一种更容易的方法来实现简单的对象迭代 ，相比较定义类实现Iterator接口的方式，性能开销和复杂度大大降低

## 生成器
假设PHP生成范围数组range()函数需要100M内存开销，那么使用生成器实现的xrange函数，只需要开销1k内存，性能提升十万倍

**yield**关键字表明一个生成器，也是生成器函数的核心
一个生成器函数看起来像一个普通函数，不同的是：普通函数返回一个值，而一个生成器可以yield生成许多它所需要的值。
生成器函数被调用时，返回的是一个可以被遍历的对象。
yield:让位、让行

实际上，生成器生成的正是一个迭代器对象实例，该迭代器对象继承了Iterator接口，同时也包含了生成器对象自身的接口



```php
<?php
  function gen_one_to_three() {
    for ($i = 1; $i <= 3; $i++) {
        //注意变量$i的值在不同的yield之间是保持传递的。
        yield $i;
    }
}
$generator = gen_one_to_three();
var_dump($generator);
echo "<br/>";
var_dump($generator instanceof Iterator); // bool(true)
echo "<br/>";
foreach ($generator as $value) {
    echo "$value\n";
}
?>

//输出如下
object(Generator)#1 (0) {
}
bool(true)
<br>
0
1
2
3
```

调用gen_one_to_three()的时候，里面的代码并没有真正的执行，而是返回了一个生成器对象$generator = Generator Object( )，$generator instanceof Iterator说明Generator实现了Iterator接口，可以用foreach进行遍历，每次遍历都会隐式调用current()、next()、key()、valid()等方法。（Generator类中的方法）

### return vs yield
- return 返回一次既定结果
- yield 不断产生直到无法产生为止才不反回
- return 中断当前进程并返回值
- yield 暂停当前进程的执行并返回值

## 协程
协程即双向传输\双向通讯

yield除了可以返回值外，还可以接收一个值

对于单核处理器，多任务的执行原理是让每一个任务执行一段时间，然后中断，让另一个任务执行，然后再中断后执行下一个任务，如此反复。由于其执行切换速度很快，外部不能感知，让外部认为多个任务实际上是“并行”的。


