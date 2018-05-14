<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 5:16
 * Desc:
 */
namespace space;

class Demo1{

    public function test()
    {
        print 'i from '.__NAMESPACE__.'<br />';
    }
}

$demo1 = new Demo1();
$demo1->test();

$demo2 = new \space\Demo1();
$demo2->test();