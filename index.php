<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/11 0011
 * Time: 下午 4:37
 * Desc:
 */

define('APP_PATH',__DIR__.'/application');
include __DIR__.'/myphp/run.php';
$config['host'] = '127.0.0.1';
$config['user'] = 'root';
$config['password'] = 'root';
$config['dbname'] = 'mdapp';
$config['charset'] = 'utf8';
// 链接数据库 返回值为数据库类
$connet = new study\Db\Connection('MYSQL',$config);

// 获取连接
$sqlClass = $connet->connection;
// 执行一条SQL语句
$sql = 'select a.id,a.name,a.value from md_config as a where configId=1';
$sqlClass->querySql($sql);
// 查询列表集合  以及链式查询演示  模仿THINKphp
$aaa = $sqlClass->name('md_config')->alias('a')->field('a.name,a.value,a.desc,b.savePath')->where('a.configId',1)->where('a.id','<>','8')->order('a.created_at asc')->join([['md_file b','a.value=b.id','left']])->all();
echo '<pre>';
// 获取当前查询的条件
var_dump($sqlClass);
print_r($aaa);
// 这里演示下将返回的列表每一行都通过一个函数来处理
function regularData($name,$value,$desc,$savePath)
{
    return 'aaaa';
}