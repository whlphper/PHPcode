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
echo '<pre />';
// 获取连接
$sqlClass = $connet->connection;
// 执行一条SQL语句
/*
$sql = 'select a.id,a.name,a.value from md_config as a where configId=1';
$res = $sqlClass->querySql($sql);
print_r($res);*/

// 查询列表集合  以及链式查询演示  模仿THINKphp
/*
$aaa = $sqlClass->name('md_config')->alias('a')->field('a.id,a.name,a.value,a.desc,b.savePath')->where('a.configId',1)->where('a.id','<>','8')->order('a.created_at asc')->join([['md_file b','a.value=b.id','left']])->all();

// 获取当前查询的条件
// var_dump($sqlClass);
 print_r($aaa);*/
// 这里演示下将返回的列表每一行都通过一个函数来处理
function regularData($name,$value,$desc,$savePath)
{
    return 'aaaa';
}

// 获取一条数据
/*
$row = $sqlClass->name('md_log')->where('id',14)->find();
print_r($row);*/

// 获取一列数据
$list = $sqlClass->name('md_product')->alias('a')->where('a.id','in',[19,20,22,24])->join([['md_file b','a.album=b.id','left']])->order('a.id desc')->column('a.id');
print_r($list);


// 插入单条数据
/*
$data['code'] = '4569';
$data['name'] = 'PDO插入测试';
$lastId = $sqlClass->name('md_log')->insert($data);
var_dump($lastId);*/


// 批量插入数据
/*
$data = [];
$row1['code'] = 4544;
$row1['name'] = 'row1';
$row2['code'] = 4544;
$row2['name'] = 'row2';
$row3['code'] = 4544;
$row3['name'] = 'row3';
$row4['code'] = 4544;
$row4['name'] = 'row4';
$data[] = $row1;
$data[] = $row2;
$data[] = $row3;
$data[] = $row4;
$lastId = $sqlClass->name('md_log')->insertAll($data);
var_dump($lastId);*/

// 修改数据
/*
$data['code'] = 545455;
$data['name'] = 'updated at 555';
//  'id','in',[122,123,124]
$lastId = $sqlClass->name('md_log')->where([['id','in',[122,123,124]],['code','<>',8]])->save($data);
var_dump($lastId);

$con = $sqlClass->getQueryCondition();
print_r($con);*/

// 删除数据
/*
$result = $sqlClass->name('md_log')->where([['id','in',[12,14,15]],['code','<>',8]])->delete();
var_dump($result);*/