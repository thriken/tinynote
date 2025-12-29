<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MVC留言板 (PHP 8.0)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .note { border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .note-header { font-weight: bold; color: #333; }
        .note-content { margin: 10px 0; line-height: 1.5; }
        .note-actions { margin-top: 10px; }
        .btn { padding: 5px 10px; text-decoration: none; background: #007cba; color: white; border-radius: 3px; }
        .btn-delete { background: #dc3545; }
        .form-group { margin: 10px 0; }
        label { display: inline-block; width: 80px; }
        input[type="text"], textarea { width: 300px; padding: 5px; }
    </style>
</head>
<body>
<h1>PHP MVC留言板 (PHP 8.0)</h1>
<a href="index.php?action=post" class="btn">添加新留言</a>
<a href="index.php?action=list" class="btn">查看所有留言</a>
<hr>

<?php
//!index.php 总入口（升级到PHP 8.0）
/**
* index.php的调用形式为：
* 显示所有留言：index.php?action=list
* 添加留言    ：index.php?action=post
* 删除留言    ：index.php?action=delete&id=x
*/
require_once('lib/DataAccess.php');
require_once('lib/Model.php');
require_once('lib/View.php');
require_once('lib/Controller.php');

// 错误处理
function handleError(string $message): void {
    echo "<div style='color: red; border: 1px solid red; padding: 10px;'>错误: " . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</div>";
}

try {
    // 创建DataAccess对象（请根据你的需要修改参数值）
    $dao = new DataAccess('127.127.126.3', 'root', '', 'test');
    
    // 获取并验证action参数
    $action = $_GET['action'] ?? 'list';
    
    // 根据action调用不同的控制器子类
    switch ($action) {
        case "post":
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new postController($dao, $_POST);
            } else {
                // 显示添加表单
                displayPostForm();
                exit;
            }
            break;
        case "list":
            $controller = new listController($dao);
            break;
        case "delete":
            $id = (int)($_GET['id'] ?? 0);
            if ($id > 0) {
                $controller = new deleteController($dao, $id);
            } else {
                handleError('无效的ID参数');
                $controller = new listController($dao);
            }
            break;
        default:
            $controller = new listController($dao); //默认为显示留言
    }

    $view = $controller->getView(); //获取视图对象
    $view->display();             //输出HTML
} catch (Exception $e) {
    handleError($e->getMessage());
}

function displayPostForm(): void {
    echo <<<HTML
    <div class="note">
        <h3>添加新留言</h3>
        <form method="post" action="index.php?action=post">
            <div class="form-group">
                <label for="name">姓名：</label>
                <input type="text" id="name" name="name" required maxlength="50">
            </div>
            <div class="form-group">
                <label for="content">留言：</label><br>
                <textarea id="content" name="content" rows="4" required maxlength="500"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">提交留言</button>
                <a href="index.php?action=list" class="btn">取消</a>
            </div>
        </form>
    </div>
HTML;
}
?>
</body>
</html>