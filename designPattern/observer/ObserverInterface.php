<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 20:33
 */
namespace observer;

/**
 * 观察者接口
 * Interface ObserverInterface
 * @package observer
 */
interface ObserverInterface{

    /**
     * 操作  可观察的对象
     * @param Observable $observable
     * @return mixed
     */
    public function update(Observable $observable);
}