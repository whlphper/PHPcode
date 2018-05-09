<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/8 0008
 * Time: 下午 12:38
 * Desc:
 */

class One{

    public $_name = 'one';
    // 静态属性 只能通过类或者类中的静态方法来访问
    public static $aNum = '20';
    public function getName(Two $two)
    {
        return self::getStatic();
        return self::$aNum;
        return $two->_name;
    }

    // 在静态方法中是不能访问普通属性，但是静态属性访问是没有限制的
    public static function getStatic()
    {
        return self::$aNum;
    }


}

class Two{

    public $_name = 'two';
}

class Three{

    public $_name = 'Three';
}

$one = new One();
$two = new Two();
echo $one->getName($two);
$three = new Three();

echo $one->getName($two);