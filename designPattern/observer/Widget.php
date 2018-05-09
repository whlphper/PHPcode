<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 20:36
 */
namespace observer;

/**
 * 观察者接口的具体实现
 * Class Widget
 * @package observer
 */
abstract class Widget implements ObserverInterface{
    protected $internalData = [];
    abstract public function draw();

    public function update(Observable $observable)
    {
        // TODO: Implement notify() method.
        $this->internalData = $observable->getData();
    }
}