<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 上午 8:43
 * Desc:
 */
namespace study\Db;

/**
 * 数据库连接类
 * Class Connection
 * @package study\Db
 */
class Connection{
    private $connection;

    public function __construct($type='MYSQL',$option=[])
    {
        $config['host'] = '';
        $config['user'] = '';
        $config['password'] = '';
        $config['dbname'] = '';
        $config['charset'] = '';
        $option = array_merge($config,$option);
        $class = '\\study\\Db\\Driver\\';
        switch ($type){
            case 'MYSQL':
                $class .= 'Mysql';
                $db =  new $class($option);
                $resource = $db->connect();
                $this->connection = $resource;
                break;
        }
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if(isset($this->$name)){
            return $this->$name;
        }
        return 'undifiend property '.$name;
    }
}