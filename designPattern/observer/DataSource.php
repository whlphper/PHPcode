<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 20:58
 */
namespace observer;

class DataSource extends Observable{

    private $names;
    private $prices;
    private $years;

    function __construct()
    {
        $this->names = [];
        $this->prices = [];
        $this->years = [];
    }

    public function addRecord($name,$price,$year)
    {
        array_push($this->names,$name);
        array_push($this->prices,$price);
        array_push($this->years,$year);
        $this->notifyObservers();
    }

    public function getData()
    {
        return [$this->names,$this->prices,$this->years];
    }
}