<?php
//! Model类（升级到PHP 8.0）
/**
 * 它的主要部分是对应于留言本各种数据操作的函数
 * 如：留言数据的显示、插入、删除等
 */

class Model {

    private $dao;
    //DataAccess类的一个实例（对象）

    //! 构造函数
    /**
     * 构造一个新的Model对象
     * @param DataAccess $dao是一个DataAccess对象
     * 该参数传给Model并保存在Model的成员变量$this->dao中
     * Model通过调用$this->dao的fetch方法执行所需的SQL语句
     */
    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function listNote() { //获取全部留言
        $this->dao->fetch("SELECT * FROM note");
    }

    public function postNote($name, $content) { //插入一条新留言（添加转义防止SQL注入）
        $safe_name = addslashes($name);
        $safe_content = addslashes($content);
        $sql = "INSERT INTO `note` (`name`, `content`, `ndate`, `add`) VALUES ('$safe_name', '$safe_content', NOW(), NULL)";
        $this->dao->fetch($sql);
    }

    public function deleteNote($id) { //删除一条留言，$id是该条留言的id（确保ID是数字）
        $safe_id = (int)$id;
        $sql = "DELETE FROM `note` WHERE `id` = $safe_id";
        $this->dao->fetch($sql);
    }

    public function getNote() { //获取以数组形式存储的一条留言
        //View利用此方法从查询结果中读出数据并显示
        if ($note = $this->dao->getRow()) {
            return $note;
        }
        return false;
    }
}
