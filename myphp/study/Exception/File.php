<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/11 0011
 * Time: 下午 5:12
 * Desc:
 */
namespace Exception;

abstract class StudyExcp extends \Exception{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {

    }
}