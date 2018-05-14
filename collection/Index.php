<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 20:34
 */

require_once ('Collection.php');

class Foo{
    private $_name;
    private $_number;

    public function __construct($name,$number)
    {
        $this->_name = $name;
        $this->_number = $number;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->_name . ' is number ' . $this->_number.'<br />';
    }
}



try{
    $colFoo = new Collection();
    $colFoo->addItem(new Foo('steven',14),'steven');
    $colFoo->addItem(new Foo('ed',37),'ed');
    $colFoo->addItem(new Foo('bob',49));

    $objSteven = $colFoo->getItem('steven');
    print $objSteven;

    $colFoo->removeItem('steven');
    //$colFoo->getItem('steven');
    var_dump($colFoo);
}catch (KeyInUserException $kie){
    print $kie->getMessage();
}catch(KeyValidException $kie){
    print $kie->getMessage();
}