<?php

function gen_one_to_three() {
    for ($i = 0; $i <= 3; $i++) {
        //注意变量$i的值在不同的yield之间是保持传递的
        yield $i;
}
}

$generator = gen_one_to_three();

var_dump($generator);

var_dump($generator instanceof Iterator); //bool true
echo "<br>";

foreach($generator as $v) {
    echo "$v\n";
}
