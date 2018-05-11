<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 20:54
 */
namespace observer;

abstract class Observable{
    private $observers = [];

    public function addObserver(ObserverInterface $observer)
    {
        array_push($this->observers,$observer);
    }

    public function notifyObservers()
    {
        $obNum = count($this->observers);
        for($i=0;$i<$obNum;++$i){
            $widget = $this->observers[$i];
            $widget->update($this);
        }
    }
}