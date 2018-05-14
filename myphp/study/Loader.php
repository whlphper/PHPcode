<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/11 0011
 * Time: 下午 2:07
 * Desc: 自动加载类
 */
namespace study;

class Loader{

    /**
     * 注册自动加载函数
     * @param null $autoload  需要加载的函数 默认为 study\autoLoad
     */
    public static function register($autoload=null)
    {
        spl_autoload_register($autoload ?: 'study\\Loader::autoload',true,true);
    }

    /**
     * 自动加载 现在只是加载了框架study核心部件 以后再完善
     * @param $class
     * @return bool
     */
    public static function autoload($class)
    {
        if(strpos($class,'study') !== -1){
            $file = MY_PATH.str_replace('\\',DS,$class).EXT;
            if(self::findFile(MY_PATH.$class.EXT)){
                __include_file($file);
            }
        }
        return false;
    }

    /**
     * 查找文件是否存在
     * @param $file
     * @return bool
     */
    public static function findFile($file)
    {
        try{
            if(file_exists($file)){
                return true;
            }
            throw new \Exception($file . 'not exists');
        }catch(\Exception $e){
            echo $e->getMessage();
            exit;
        }
    }
}


/**
 * include
 * @param  string $file 文件路径
 * @return mixed
 */
function __include_file($file)
{
    return include $file;
}

/**
 * require
 * @param  string $file 文件路径
 * @return mixed
 */
function __require_file($file)
{
    return require $file;
}
