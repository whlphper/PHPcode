<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 20:19
 */
require_once ('KeyInUserException.php');
require_once ('KeyValidException.php');
class Collection{

    private $_members = [];
    private $_onload;
    private $_isLoaded = false;
    public function addItem($obj,$key=null){
        $this->_checkCallback();
        if($key){
            if(isset($this->_members[$key])){
                throw new KeyInUserException("key \"$key\" already in use");
            }else{
                $this->_members[$key] = $obj;
            }
        }else{
            $this->_members[] = $obj;
        }
    }

    public function removeItem($key)
    {
        $this->_checkCallback();
        if(isset($this->_members[$key])){
            unset($this->_members[$key]);
        }else{
            throw new KeyValidException(" Invalid key \"$key\" ");
        }
    }

    public function getItem($key)
    {
        $this->_checkCallback();
        if(!isset($this->_members[$key])){
            throw new KeyInUserException("key \"$key\" already in use");
        }else{
            return $this->_members[$key];
        }
    }

    public function length()
    {
        $this->_checkCallback();
        return sizeof($this->_members);
    }

    public function keys()
    {
        $this->_checkCallback();
        return array_keys($this->_members);
    }

    public function exists($key)
    {
        $this->_checkCallback();
        return (isset($this->_members[$key]));
    }

    public function setLoadCallback($functionName,$objOrClass=null)
    {
        if($objOrClass){
            $callback = array($objOrClass,$functionName);
        }else{
            $callback = $functionName;
        }

        if(!is_callable($callback,false,$callableName)){
            throw new \Exception("$callableName is not callable " . "as a paramter to onspeak");
            return false;
        }
        $this->_onload = $callback;
    }

    private function _checkCallback()
    {
        if(isset($this->_onload) && !$this->_isLoaded){
           $this->_isLoaded = true;
           call_user_func($this->_onload,$this);
        }
    }
}