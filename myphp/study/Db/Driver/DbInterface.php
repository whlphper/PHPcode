<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 上午 9:10
 * Desc:
 */
namespace study\Db\Driver;
use study\Db\Connection;

/**
 * 数据库接口类
 * Interface DbInterface
 * @package study\Db\Driver
 */
abstract class DbInterface{

    protected $dsn;
    protected $host;
    protected $user;
    protected $pass;
    protected $db;
    protected $charset;
    protected $conn;
    protected static $table;
    protected static $where = [];
    protected static $field = '*';
    // [['Table2 b','a.id=b.id','left/right']]
    protected static $join = [];
    protected static $order;
    protected static $alias;
    protected static $limit;
    protected static $group;
    protected static $having;
    protected static $regular;
    protected static $transaction;
    protected static $commit;
    protected static $rollback;

    abstract public function connect();

    abstract function query($sql);

    abstract function all();

    abstract function find();

    abstract function column($field);

    abstract function value($field);

    abstract function insert($data);

    abstract function insertAll($data);

    abstract function save($data);

    abstract function delete();

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if(isset($this->$name)){
            return $this->$name;
        }
        return null;
    }

    public function __call($name, $arguments)
    {
        return $this->_call_user_func($name,$arguments);
    }


    abstract public function _call_user_func($name,$arguments);

    static public function getQueryCondition(){}

}