<?php
//! View 类（升级到PHP 8.0）
/**
* 针对各个功能（list、post、delete）的各种View子类
* 被Controller调用，完成不同功能的网页显示
*/
class View {

    protected $model;  //Model对象
    protected string $output; //用于保存输出HTML代码的字符串

    //! 构造函数
    /**
    * 将参数中的Model对象接收并存储在成员变量$this->model中
    * 供子类通过model对象获取数据
    */
    public function __construct($model) {
        $this->model = $model; 
        $this->output = '';
    }

    public function display(): void {  //输出最终格式化的HTML数据
        echo $this->output;
    }
}

class listView extends View   //显示所有留言的子类
{
    public function __construct($model) {
        parent::__construct($model);   //继承父类的构造函数（详见Controller）
        $this->model->listNote();
        $this->output = '';
        while ($note = $this->model->getNote()) {  //逐行获取数据
            $safe_id = htmlspecialchars($note['id'], ENT_QUOTES, 'UTF-8');
            $safe_name = htmlspecialchars($note['name'], ENT_QUOTES, 'UTF-8');
            $safe_content = htmlspecialchars($note['content'], ENT_QUOTES, 'UTF-8');
            
            $this->output .= "姓名：{$safe_name}<br> 留言：<br> {$safe_content}     
<a href=\"" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . "?action=delete&id={$safe_id}\">删除</a><br> <hr />";
        }           
    }
}

class postView extends View  //发表留言的子类
{
    public function __construct($model, $post) {
        parent::__construct($model);
        $this->model->postNote($post['name'], $post['content']);
        $this->output = "Note Post OK!<br><a href=\"" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . "?action=list\">查看</a>";
    }
}

class deleteView extends View  //删除留言的子类
{
    public function __construct($model, $id) {
        parent::__construct($model);
        $this->model->deleteNote($id);
        $this->output = "Note Delete OK!<br><a href=\"" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . "?action=list\">查看</a>";  
    }
}
