<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 21:02
 */

class Bar{
    private $_foo;

    public  function __construct($fooVal)
    {
        $this->_foo = $fooVal;
    }

    public function printFoo()
    {
        print $this->_foo;
    }

    public static function sayHello($name)
    {
        print "Hello there, $name";
    }
}

/**
 * exp 1 普通函数
 */
function printCount($start,$end)
{
    for($x=$start;$x<$end;++$x){
        print "$x ";
    }
}

call_user_func('printCount',1,10);

/**
 * exp 2 调用对象方法
 */
$objBar = new Bar('steven');
call_user_func([$objBar,'printFoo']);

/**
 * exp3 调用类的静态方法
 */
call_user_func(['Bar','sayHello'],'steven');

/**
 * exp4 一个错误的演示 回调了类的非静态方法
 */
call_user_func(['Bar','printFoo']);