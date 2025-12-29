<?php declare(strict_types=1);
/**
 * 测试文件 - PHP 8.0版本
 * 用于测试数据库连接和数据读取
 */
require_once('lib/DataAccess.php');
require_once('lib/Model.php');

function handleError(string $message): void {
    echo "<div style='color: red; border: 1px solid red; padding: 10px;'>错误: " . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</div>";
}

try {
    $dao = new DataAccess('127.127.126.3', 'root', '', 'test');
    $model = new Model($dao);
    $model->listNote();

    $output = '';
    while ($note = $model->getNote()) {
        $safe_name = htmlspecialchars($note['name'], ENT_QUOTES, 'UTF-8');
        $safe_content = htmlspecialchars($note['content'], ENT_QUOTES, 'UTF-8');
        $output .= "姓名：{$safe_name}<br> 留言：<br> {$safe_content} <br> <hr />";
    }
    
    if (empty($output)) {
        $output = '<p>暂无留言数据</p>';
    }
    
    echo "<!DOCTYPE html>
<html lang='zh-CN'>
<head>
    <meta charset='UTF-8'>
    <title>测试页面 - PHP 8.0</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; border: 1px solid green; padding: 10px; margin: 10px 0; }
        .note { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>数据库连接测试 - PHP 8.0</h1>
    <div class='success'>✓ 数据库连接成功</div>
    <div class='note'>
        <h3>留言数据：</h3>
        {$output}
    </div>
    <p><a href='index.php' class='btn'>返回首页</a></p>
</body>
</html>";
    
} catch (Exception $e) {
    handleError($e->getMessage());
}
