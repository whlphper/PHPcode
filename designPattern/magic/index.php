<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/10 0010
 * Time: 上午 10:18
 * Desc:
 */

class index{

    private $_name = 'name';

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if(!empty($this->$name)){
            print $name.'==='.$this->$name.'<br />';
        }else{
            print $name.'is not exists<br />';
        }
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name = $value;
        print $name.'set successfuly<br />';
    }

    public function __isset($name)
    {
        // TODO: Implement __isset() method.
        print $name.' is not isset<br />';
    }

    public function __unset($name)
    {
        // TODO: Implement __unset() method.
        print 'dont unset a not isset property===>'.$name.'<br />';
    }

    public function aaaa()
    {
        echo 'aaaa';
    }


    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo "<pre>";
        echo "you want excute function $name";
        echo "<br />";
        echo "its you params<br />";
        print_r($arguments);
        // 这里演示 call user func
        call_user_func($name,$arguments[0],$arguments[1],'aaaa');
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        echo 'bye bye<br />';
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return json_encode($this).'<br />';
    }
}

function addProject($name,$year,$desc='default')
{
    echo $name.'=====>'.$year.'=======>'.$desc.'<br />';
}
$c1 = new index();

$c1->age;
$c1->_name;

$c1->sex = 'boy';

isset($c1->aaa);
unset($c1->bbb);
$c1->aaaa();
$c1->addProject('math','2017');

echo $c1;