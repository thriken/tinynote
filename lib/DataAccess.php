<?php
/**
*  一个用来访问MySQL的类（升级到PHP 8.0）
*  使用mysqli扩展替代已废弃的mysql_*函数
*  现代化的PHP语法和错误处理
*/
class DataAccess {

private $db; //用于存储数据库连接
private $query; //用于存储查询源

//! 构造函数.
/**
* 创建一个新的DataAccess对象
* @param string $host 数据库服务器名称
* @param string $user 数据库服务器用户名
* @param string $pass 密码
* @param string $db   数据库名称
*/
public function __construct($host, $user, $pass, $db) {
    $this->db = mysqli_connect($host, $user, $pass, $db);
    if (!$this->db) {
        throw new Exception('数据库连接失败: ' . mysqli_connect_error());
    }
    mysqli_set_charset($this->db, 'utf8');
}

//! 执行SQL语句
/**
* 执行SQL语句，获取一个查询源并存储在数据成员$query中
* @param string $sql  被执行的SQL语句字符串
* @return void
*/
public function fetch($sql) {
    $this->query = mysqli_query($this->db, $sql);
    if (!$this->query) {
        throw new Exception('查询执行失败: ' . mysqli_error($this->db));
    }
}

//! 获取一条记录
/**
* 以数组形式返回查询结果的一行记录，通过循环调用该函数可遍历全部记录
* @return array|false
*/
public function getRow() {
    if ($row = mysqli_fetch_assoc($this->query)) {
        return $row;
    }
    return false;
}

//! 析构函数
/**
* 关闭数据库连接
*/
public function __destruct() {
    if ($this->db) {
        mysqli_close($this->db);
    }
}
}
