<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 20:38
 */
namespace observer;

/**
 * 观察者A  具体实现了抽象类中的draw方法
 * Class BasicWidget
 * @package observer
 */
class BasicWidget extends Widget{
    public function __construct()
    {
    }

    public function draw()
    {
        // TODO: Implement draw() method.
        $html = "<table border='1' width='130'>";
        $html .= "<tr><td colspan='3' bgcolor='orange'><b>Instrument Info</b></td></tr>";
        $numRecords = count($this->internalData[0]);
        for($i=0;$i<$numRecords;++$i){
            $instms = $this->internalData[0];
            $price = $this->internalData[1];
            $year = $this->internalData[2];
            $html .= "<tr><td>$instms[$i]</td><td>$price[$i]</td><td>$year[$i]</td></tr>";
        }
        $html .= "</table><br />";
        echo $html;
    }
}