<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/10 0010
 * Time: 上午 10:46
 * Desc:
 */
class Index{

    public $name;
    public $price;
    function __construct($name,$price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class Demo{
    private $callbacks;

    /**
     * 注册回调函数
     * @param $callback
     * @throws Exception
     */
    function registerCallback($callback)
    {
        if(!is_callable($callback)){
            throw new \Exception('invalid callback');
        }
        $this->callbacks[] = $callback;
    }

    /**
     * 执行回调函数
     * @param Index $index
     */
    function sale(Index $index)
    {
        print "{$index->name}:processing";
        foreach ($this->callbacks as $callback)
        {
            call_user_func($callback,$index);
        }
    }
}

class Totalizer{

    /**
     * 闭包函数
     * @param $amt
     * @return Closure
     */
    static function warnAmount($amt)
    {
        $count = 0;
        return function (Index $project) use ($amt,$count)
        {
            $count += $project->price;
            print  "count===>".$count;
            if($count > $amt){
                print "high price rwached: {$count} <br />";
            }
        };
    }
}

$logger = create_function('$product','print "logging ({$product->name})";');
$echoPrice = function (Index $index)
{
  echo "{$index->name} price is {$index->price}<br />";
};
$processor = new Demo();
$processor->registerCallback($logger);
$processor->registerCallback($echoPrice);
$processor->registerCallback(Totalizer::warnAmount(15));
$processor->sale(new Index('shoes',6));
echo '<br />';
$processor->sale(new Index('coffee',16));