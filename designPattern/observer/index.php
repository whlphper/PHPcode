<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 21:03
 */
include dirname(__FILE__).'/../autoload.php';
use observer\DataSource;
use observer\BasicWidget;
use observer\FancyWidget;

$dat = new  DataSource();

$widgetA = new BasicWidget();
$widgetB = new FancyWidget();

$dat->addObserver($widgetA);
$dat->addObserver($widgetB);

$dat->addRecord('aaaa','19.99','1989');
$dat->addRecord('cccc','19.99','1989');
$dat->addRecord('dddd','19.99','1989');
$dat->addRecord('eeee','19.99','1989');

$widgetA->draw();
$widgetB->draw();