<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 上午 9:09
 * Desc:
 */
namespace study\Db\Driver;
use study\Db\Connection;
use study\Db\Driver\DbInterface;

class Mysql extends DbInterface{


    public function __construct($option=[])
    {
        $this->host = $option['host'];
        $this->user = $option['user'];
        $this->pass = $option['password'];
        $this->db   = $option['dbname'];
        $this->charset = $option['charset'];
        $dsn="mysql:host=$this->host;dbname=$this->db";
        $this->dsn = $dsn;
    }

    public function connect()
    {
        try {
            //默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
            //$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $dbh = new \PDO($this->dsn, $this->user, $this->pass); //初始化一个PDO对象
            //设置错误处理模式
            $dbh->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            $this->conn = $dbh;
            return $this;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }

    public function query()
    {

    }

    /**
     * 拼接SQL语句
     * @param bool $limit
     * @param bool $column
     * @return string
     */
    public function buildSql($limit=false,$column=false)
    {
        // 拼接SQL语句
        if(!$column){
            $sql = 'SELECT '.self::$field.' FROM '.self::$table;
        }else{
            $sql = 'SELECT '.$column.' FROM '.self::$table;
        }
        // 别名
        $sql .= empty(self::$alias) ?: ' AS '.self::$alias;
        // 连接查询
        // // [['Table2 b','a.id=b.id','left/right']]
        if(!empty($join = self::$join)){
            foreach($join as $k=>$v){
                $joinTable = explode(' ',$v[0]);
                $sql .= isset($v[2]) ? ' '.$v[2] : ' INNER ' ;
                $sql .= ' ' . ' JOIN ' .$joinTable[0] . ' AS '.$joinTable[1] . ' ON ' . $v[1];
            }
        }
        // where 查询条件
        if(!empty($where = self::$where)){
            $sql .= ' WHERE ';
            $index= 0;
            foreach($where as $k=>$expression){
                $sql .= $index != 0 ? ' AND '  : '';
                if(is_array($expression)){
                    $sql .= $k.' '. $expression[0] . ' ' . $expression[1];
                }else{
                    $sql .= $k.' = '.$expression;
                }
                ++$index;
            }
        }
        // group by
        if(!empty(self::$group)){
            $sql .= ' GROUP BY '.self::$group;
        }
        // having
        if(!empty(self::$having)){
            $sql .= ' having '.self::$having;
        }
        // 排序
        if(!empty(self::$order)){
            $sql .= ' ORDER BY '.self::$order;
        }
        // 限制条数
        if($limit){
            $sql .= ' LIMIT 1';
        }else{
            if(!empty(self::$limit)){
                $sql .= ' LIMIT '.self::$limit;
            }
        }
        return $sql;
    }


    /**
     * 手动执行一条SQL语句
     * @param $sql
     * @return mixed
     */
    public function querySql($sql)
    {
        // TODO: Implement query() method.
        try{
            $stat = $this->conn->query($sql);
            if(!$stat){
                throw new \PDOException('query error');
            }
            $result = $stat->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }catch(\PDOException $pE){
            echo $pE->getMessage();
        }
    }


    /**
     * 获取数据集
     * @return mixed
     */
    public function all()
    {
        // TODO: Implement query() method.
        try{
            $sql = $this->buildSql();
            $list = $this->conn->query($sql);
            if(!empty(self::$regular)){
                return $list->fetchAll(\PDO::FETCH_FUNC, self::$regular);
            }
            return $list->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * 获取单条数据
     * @return mixed
     */
    public function find()
    {
        // TODO: Implement query() method.
        try{
            $sql = $this->buildSql(true);
            $list = $this->conn->query($sql);
            return $list->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * 获取某个字段的列数据
     * @param $field
     * @return mixed
     */
    public function column($field)
    {
        // TODO: Implement query() method.
        try{
            $sql = $this->buildSql(false,'`'.$field.'`');
            $list = $this->conn->query($sql);
            return $list->fetchAll(\PDO::FETCH_COLUMN,0);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * 获取某个字段的值
     * @param $field
     * @return mixed
     */
    public function value($field)
    {
        // TODO: Implement query() method.
        try{
            $sql = $this->buildSql(true,'`'.$field.'`');
            $list = $this->conn->query($sql);
            return $list->fetch(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }


    public function _call_user_func($name,$arguments)
    {
        if(!empty($arguments)){
            switch($name){
                case 'name':
                    self::$table = $arguments[0];
                    break;
                case 'where':
                    $agsNumber = count($arguments);
                    switch ($agsNumber){
                        case 2:
                            self::$where = array_merge(self::$where,[$arguments[0]=>$arguments[1]]);
                            break;
                        case 3:
                            self::$where = array_merge(self::$where,[$arguments[0]=>[$arguments[1],$arguments[2]]]);
                            break;
                        default:
                            break;
                    }
                    break;
                case 'join':
                    $flag = '';
                    foreach ($arguments as $k=>$v){
                        $nextFlag = str_replace(" ",'',$v[0]);
                        if($flag != $nextFlag){
                            self::$join = array_merge(self::$join,$v);
                        }
                        $flag = $nextFlag;
                    }
                    break;
                default:
                    self::$$name = $arguments[0];
                    break;
            }
        }
        return $this;
    }

    public static function getQueryCondition()
    {
        $condition['table'] = self::$table;
        $condition['where'] = self::$where;
        $condition['field'] = self::$field;
        $condition['join']  = self::$join;
        $condition['order'] = self::$order;
        $condition['alias'] = self::$alias;
        $condition['limit'] = self::$limit;
        $condition['group'] = self::$group;
        $condition['having'] = self::$having;
        $condition['regular'] = self::$regular;
        return $condition;
    }
}