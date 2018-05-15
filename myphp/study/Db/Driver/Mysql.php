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

    public function query($sql)
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
        if(empty(self::$table)){
            throw new \PDOException('table is undifined');
        }
        // 拼接SQL语句
        if(!$column){
            $sql = 'SELECT '.self::$field.' FROM '.self::$table;
        }else{
            $sql = 'SELECT '.$column.' FROM '.self::$table;
        }
        // 别名
        $sql .= $this->aliasSql();
        // 连接查询
        // // [['Table2 b','a.id=b.id','left/right']]
        $sql .= $this->joinSql();
        // where 查询条件
        $sql .= $this->whereSql();
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

    public function aliasSql()
    {
        return empty(self::$alias) ? '': ' AS '.self::$alias;
    }

    public function joinSql()
    {
        $sql = '';
        if(!empty($join = self::$join)){
            foreach($join as $k=>$v){
                $joinTable = explode(' ',$v[0]);
                $sql .= isset($v[2]) ? ' '.$v[2] : ' INNER ' ;
                $sql .= ' ' . ' JOIN ' .$joinTable[0] . ' AS '.$joinTable[1] . ' ON ' . $v[1];
            }
        }
        return $sql;
    }

    public function whereSql()
    {
        $sql = '';
        if(!empty($where = self::$where)){
            $sql .= ' WHERE ';
            $index= 0;
            foreach($where as $k=>$expression){
                $sql .= $index != 0 ? ' AND '  : '';
                if(is_array($expression)){
                    $sql .= $k.' '. $expression[0] . ' ';
                    $sql .= is_array($expression[1]) ? ' ('.implode(',',$expression[1]).') ' : $expression[1];
                }else{
                    $sql .= $k.' = '.$expression;
                }
                ++$index;
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
            return $list->fetch(\PDO::FETCH_ASSOC);
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
            $sql = $this->buildSql(false,$field);
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

    /**
     * 插入单条数据
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function insert($data)
    {
        // TODO: Implement insert() method.
        try{
            if(empty(self::$table)){
                throw new \Exception('table is undifiend');
            }
            $table = self::$table;
            $sql = $this->buildInsertSql($data,false,true);
            // 经测试  不能用 === 判断query的结果
            // 还有    MYSQL 字段是不区分大小写的，只是用TP5的时候,框架自身做了限制
            if($this->conn->query($sql))
            {
                return $this->conn->lastInsertId();
            }
            throw new \PDOException('insert failure');
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function filterSql($data,$sql=false,$filterColumn=true)
    {
        foreach ($data as $f=>$column)
        {
            // 解决冲突MYSQL关键词
            $char = '`'.$f.'`';
            unset($data[$f]);
            if($filterColumn){
                // 替换引号以及对数字和字符串的处理
                $input = str_replace("'",'',$column);
                $input = is_numeric($input) ? $input : '"'.$column.'"';
            }else{
                $data[$char] = $column;
            }
            if($sql){
                $sql .= $char.'='.$input.',';
            }else if($filterColumn){
                $data[$char] = $input;
            }
        }
        if($sql){
            return $sql;
        }
        return $data;

    }

    public function buildInsertSql($data=[],$isUpdated=false,$simple=true)
    {
        if(empty($data)){
            throw new \PDOException('data is array');
        }
        if($isUpdated){
            $sql = 'UPDATE '.self::$table . ' SET ';
            $sql = $this->filterSql($data,$sql);
            $sql = substr($sql,0,strlen($sql)-1);
            // where 查询条件
            $sql .= $this->whereSql();
            return $sql;
        }
        $number = count($data);
        // 插入单条数据
        if($simple){
            $data = $this->filterSql($data);
            $field = implode(',',array_keys($data));
            $values = implode(',',array_values($data));
            $sql = 'INSERT INTO '.self::$table . ' (' . $field;
            $sql .= ') VALUES ('.$values . ')';
            return $sql;
        }else{
            // 批量插入数据  $data 为二维数组  $fields 为插入数据表的字段，需要一一对应的
            $row = $data[0];
            $row = $this->filterSql($row,false,false);
            $field = implode(',',array_keys($row));
            $sql = 'INSERT INTO '.self::$table . ' (' . $field . ') VALUES ';
            $insertData = '';
            foreach($data as $k=>$v){
                $v = $this->filterSql($v,false);
                $curRowData = implode(',',$v);
                $insertData .= '( '.$curRowData . ') ,';
            }
            $sql .= chop($insertData,',');
            return $sql;
        }
    }

    public function save($data)
    {
        // TODO: Implement save() method.
        try{
            if(empty(self::$table)){
                throw new \Exception('table is undifiend');
            }
            if(empty(self::$where)){
                throw new \Exception('where is empty');
            }
            $table = self::$table;
            $sql = $this->buildInsertSql($data,true);
            if($this->conn->query($sql))
            {
                return true;
            }
            throw new \PDOException('updated failure');
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function delete()
    {
        // TODO: Implement delete() method.
        try{
            if(empty(self::$table)){
                throw new \PDOException('table is undifiend');
            }
            if(empty(self::$where)){
                throw new \PDOException('where is empty');
            }
            $sql = 'DELETE FROM '.self::$table . $this->whereSql();
            if($this->conn->query($sql))
            {
                return true;
            }
            throw new \PDOException('updated failure');
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function insertAll($data)
    {
        // TODO: Implement insertAll() method.
        try{
            if(empty(self::$table)){
                throw new \PDOException('table is undifiend');
            }
            $table = self::$table;
            $sql = $this->buildInsertSql($data,false,false);
            if($this->conn->query($sql))
            {
                // 如果是批量插入，默认返回的是第一条记录的自增ID
                $number = count($data);
                $lastId = $this->conn->lastInsertId();
                $result = [];
                for($i=0;$i<$number;$i++){
                    $result[] = $lastId+$i;
                }
                return $result;
            }
            throw new \PDOException('insert failure');
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function _call_user_func($name,$arguments)
    {
        if(!empty($arguments)){
            switch($name){
                case 'name':
                    if(self::$table != $arguments[0]){
                        self::$where = [];
                        self::$field = '*';
                        self::$join = [];
                        self::$order = '';
                        self::$group = '';
                    }
                    self::$table = $arguments[0];
                    break;
                case 'where':
                    $this->setWhere($arguments);
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

    public function setWhere($arguments)
    {
        $agsNumber = count($arguments);
        if(is_array($arguments) && $agsNumber == 1){
            foreach($arguments[0] as $k=>$v){
                $curNumber = count($v);
                $this->mergerWhere($v,$curNumber);
            }
        }else{
            $this->mergerWhere($arguments,$agsNumber);
        }
    }

    public function mergerWhere($arguments,$number)
    {
        switch ($number){
            case 2:
                self::$where = array_merge(self::$where,[$arguments[0]=>$arguments[1]]);
                break;
            case 3:
                self::$where = array_merge(self::$where,[$arguments[0]=>[$arguments[1],$arguments[2]]]);
                break;
            default:
                break;
        }
    }

    public function __destruct()
    {

    }
}