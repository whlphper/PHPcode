<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 5:21
 * Desc: PHP 反射API
 *
 */
class Demo1{
    private $name = 'aaa';
    private static $money = 199999;

    private function __construct()
    {
    }
}

// 根据 ReflectionClass
$test = new ReflectionClass('Demo1');
//var_dump($test);
// 根据 Reflection::export来格式化输出此类
//var_dump(Reflection::export($test));


/**
 * 检查类
 * @param ReflectionClass $class
 * @return string
 */
function classData(ReflectionClass $class)
{
    $details = "";
    // 类名
    $name = $class->getName();
    // 是否在代码中定义
    if($class->isUserDefined()){
        $details .= "$name is user defined<br />";
    }

    //内置类
    if($class->isInternal()){
        $details .= "$name is built-in<br />";
    }

    if($class->isInterface()){
        $details .= "$name is interface<br />";
    }
    if($class->isAbstract()){
        $details .= "$name is Abstract<br />";
    }
    if($class->isFinal()){
        $details .= "$name is final class<br />";
    }
    if($class->isInstantiable()){
        $details .= "$name can be instantiated<br />";
    }else{
        $details .= "$name can not be instantiated<br />";
    }
    return $details;
}

print classData($test);

class ReflectionUtil{

    /**
     * 获取类的源码
     * @param ReflectionClass $class
     * @return string
     */
    static function getClassSource(ReflectionClass $class)
    {
        // 获取文件的绝对路径
        $path = $class->getFileName();
        // @file 获取文件中所有行组成的数组
        $lines = @file($path);
        /*echo '<pre>';
        print_r($lines);*/
        $from = $class->getStartLine();
        $to = $class->getEndLine();
        $len = $to-$from+1;
        return implode(array_slice($lines,$from-1,$len));
    }

    /**
     * 获取方法的源码
     * @param ReflectionMethod $method
     * @return string
     */
    static function getMethodSource(ReflectionMethod $method)
    {
        // 获取文件的绝对路径
        $path = $method->getFileName();
        // @file 获取文件中所有行组成的数组
        $lines = @file($path);
        /*echo '<pre>';
        print_r($lines);*/
        $from = $method->getStartLine();
        $to = $method->getEndLine();
        $len = $to-$from+1;
        return implode(array_slice($lines,$from-1,$len));
    }
}

print ReflectionUtil::getClassSource($test);


/**
 * 检查方法
 */
$proclass = new ReflectionClass('Demo1');
$methods = $proclass->getMethods();

foreach ($methods as  $method){
    print methoddata($method);
    print "<br >";
}

function methoddata(ReflectionMethod $method)
{
    $details = "";
    // 方法名
    $name = $method->getName();
    // 是否在代码中定义
    if($method->isUserDefined()){
        $details .= "$name is user defined<br />";
    }

    //内置方法
    if($method->isInternal()){
        $details .= "$name is built-in<br />";
    }


    if($method->isAbstract()){
        $details .= "$name is Abstract<br />";
    }
    if($method->isFinal()){
        $details .= "$name is final class<br />";
    }

    return $details;
}