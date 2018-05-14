<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/10 0010
 * Time: 上午 8:54
 * Desc:
 */
namespace singleton;

/**
 * 单例模式
 * Class index
 * @package singleton
 */
class index{

    private static $_instance;

    /**
     * 禁止实例化
     * index constructor.
     */
    private function __construct()
    {

    }

    /**
     * 禁止克隆
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 获取自身实例
     * @return index
     */
    public static function getInstance()
    {
        if(!self::$_instance instanceof  self){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function test()
    {
        echo "test";
    }
}

/*$c1 = index::getInstance();
$c2 = index::getInstance();
var_dump($c1);
print '<br />';
var_dump($c2);
print '<br />';
if($c1 == $c2){
    echo 'its singleton';
}*/



class Test{

    final function must()
    {
        echo 'cant rewrite must() function';
    }

    function maybe()
    {
        echo 'maybe from Test';
    }
}

/**
 * Final 关键字的使用
 * Class Test2
 * @package singleton
 */
class Test2 extends Test{

    /*
     * Cannot override final method singleton\Test::must() i
     */
    function must2()
    {
        echo 'error';
    }

    function maybe()
    {
        echo 'maybe from Test2';
    }
}

final class Test3{

    function aaa()
    {
        return 'aaa';
    }
}

/*
 * Class singleton\Test4 may not inherit from final class (singleton\Test3)
 */
class Test4 extends Test33{

}