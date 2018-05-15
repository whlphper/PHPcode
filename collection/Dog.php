<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 21:16
 */
class Dog{
    private $_onspeak;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function bark()
    {
        if(isset($this->_onspeak)){
            if(!call_user_func($this->_onspeak)){
                return false;
            }
        }
        print "Woof Woof";
    }

    public function onspeak($functionName,$objOrClass=null)
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

        $this->_onspeak = $callback;
    }
}

function isEveryoneAwake()
{
    if(time() < strtolower("today 8:30am") || time() > strtotime("today 10:30pm")){
        return false;
    }else{
        return true;
    }
}

try{
    $objDog = new Dog('Fido');
    $objDog->onspeak('isEveryoneAwake');
    $objDog->bark();

    $objDog2 = new Dog('aaa');
    $objDog2->bark();
}catch(\Exception $e){
    echo $e->getMessage();
}
