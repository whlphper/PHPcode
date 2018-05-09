<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7 0007
 * Time: 下午 1:09
 */

class Shopproduct{

    public $age = 25;
    var $sex = 'boy';
    protected $name = 'aaa';
    private $money = 9999;

    public function __construct()
    {

    }

    public function index()
    {
        echo 45454;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return '__toString()当输出对象的时候此方法';
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return "$name is not exists <br />";
    }

    public function __get($name)
    {
        // TODO: Implement __call() method.
        return "$name not exists <br />";
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        echo "$name=>$value success";
    }
}


$c1 = new Shopproduct();
$c2 = new Shopproduct();

var_dump($c1);
echo $c1->name;
echo $c1->money;
$c1->name = 'update';
echo  '<hr />';
$c1->age = 88;
var_dump($c1);
echo  '<hr />';
var_dump($c2);
echo  '<hr />';
echo $c1;
echo  '<hr />';

/**
 * 当属性或者变量类型一定要做限制的时候
 */
is_bool();
is_integer();
is_double();
is_object();
is_string();
is_array();
is_resource();
is_null();