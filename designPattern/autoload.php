<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 21:04
 */
spl_autoload_register('loadClass');

function loadClass($class)
{
    require dirname(__FILE__).'/'.str_replace("\\",'/',$class).".php";
}