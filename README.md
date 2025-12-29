# TinyNote - PHP 8.0 MVC留言板

一个使用PHP 8.0开发的简易MVC结构留言板演示项目，展示现代PHP开发的最佳实践。

## 🚀 项目特性

- **PHP 8.0**: 使用最新PHP特性，包括严格类型声明、现代语法
- **MVC架构**: 清晰的Model-View-Controller分层设计
- **mysqli扩展**: 使用现代化数据库访问层，废弃了过时的mysql_*函数
- **安全防护**: 内置XSS防护、SQL注入防护
- **响应式设计**: 现代化的用户界面
- **错误处理**: 完善的异常处理机制

## 📁 项目结构

```
tinynote/
├── index.php          # 主入口文件
├── test.php           # 数据库测试文件
├── database.sql       # 数据库结构和测试数据
├── post.html          # HTML表单模板（备用）
├── lib/               # 核心库文件
│   ├── DataAccess.php # 数据库访问层
│   ├── Model.php      # 数据模型层
│   ├── View.php       # 视图层
│   └── Controller.php # 控制器层
└── README.md          # 项目说明文档
```

## 🛠️ 环境要求

- **PHP**: 8.0 或更高版本
- **数据库**: MySQL 5.7+ 或 MariaDB 10.2+
- **Web服务器**: Apache、Nginx 或其他支持PHP的服务器

## 📋 安装步骤

### 1. 克隆项目
```bash
git clone <repository-url>
cd tinynote
```

### 2. 数据库配置
```bash
# 导入数据库结构
mysql -u root -p < database.sql
```

### 3. 修改配置
编辑 `index.php` 文件第47行，根据您的环境修改数据库连接参数：
```php
$dao = new DataAccess('localhost', 'root', '你的密码', 'test');
```

### 4. 访问应用
在浏览器中访问：
```
http://localhost/tinynote/
```

## 🎯 功能说明

### 主要功能
- ✅ 查看留言列表
- ✅ 添加新留言
- ✅ 删除留言
- ✅ 数据持久化存储

### URL路由
```
index.php                 # 默认显示留言列表
index.php?action=list     # 显示留言列表
index.php?action=post     # 添加留言表单
index.php?action=delete&id=x  # 删除指定ID的留言
```

## 🏗️ MVC架构解析

### Model (模型层) - `lib/Model.php`
- 负责数据操作和业务逻辑
- 包含留言数据的增删查改功能
- 与数据库交互的核心组件

### View (视图层) - `lib/View.php`
- 负责数据显示和用户界面
- 包含三个子视图类：
  - `listView`: 显示留言列表
  - `postView`: 处理添加留言后的反馈
  - `deleteView`: 处理删除留言后的反馈

### Controller (控制器层) - `lib/Controller.php`
- 负责协调Model和View
- 处理用户请求并分发到相应的控制器
- 包含三个控制器子类：
  - `listController`: 控制留言列表显示
  - `postController`: 控制添加留言
  - `deleteController`: 控制删除留言

### DataAccess (数据访问层) - `lib/DataAccess.php`
- 封装数据库连接和操作
- 使用mysqli扩展确保PHP 8.0兼容性
- 提供基础的数据库操作方法

## 🔒 安全特性

### XSS防护
```php
// 所有输出都经过htmlspecialchars处理
$safe_name = htmlspecialchars($note['name'], ENT_QUOTES, 'UTF-8');
```

### SQL注入防护
```php
// 参数转义和类型验证
$safe_name = addslashes($name);
$safe_id = (int)$id;
```

### 错误处理
```php
try {
    // 数据库操作
} catch (Exception $e) {
    handleError($e->getMessage());
}
```

## 📊 数据库结构

### note表字段说明
| 字段名 | 类型 | 说明 |
|--------|------|------|
| id | INT(11) | 主键，自增 |
| name | VARCHAR(50) | 留言者姓名 |
| content | TEXT | 留言内容 |
| ndate | DATETIME | 留言时间 |
| ip | VARCHAR(45) | 留言者IP |
| user_agent | TEXT | 浏览器信息 |
| status | TINYINT(1) | 状态(1=正常,0=删除) |

## 🎨 界面特性

- **响应式设计**: 适配各种设备屏幕
- **现代化UI**: 使用CSS3样式和过渡效果
- **用户友好**: 清晰的操作提示和反馈
- **无障碍访问**: 语义化HTML结构

## 🚀 PHP 8.0 升级亮点

### 语法现代化
- ✅ 使用 `declare(strict_types=1)` 严格类型声明
- ✅ 移除过时的 `&new` 引用语法
- ✅ 使用 `private/protected/public` 访问修饰符
- ✅ 移除冗余的PHP结束标签

### 数据库升级
- ✅ mysql_* → mysqli_* 扩展迁移
- ✅ 添加异常处理机制
- ✅ 字符集统一为utf8mb4
- ✅ 支持完整Unicode字符集

### 性能优化
- ✅ 数据库查询索引优化
- ✅ 减少不必要的变量赋值
- ✅ 代码结构优化

## 🔧 开发说明

### 代码规范
- 遵循PSR-12编码标准
- 使用有意义的变量和方法命名
- 添加完整的注释和文档

### 扩展建议
- 添加用户认证系统
- 实现留言分页功能
- 添加富文本编辑器
- 集成缓存系统
- 添加API接口

## 📝 测试

### 数据库连接测试
访问 `test.php` 来验证数据库连接是否正常。

### 功能测试
1. 访问首页查看留言列表
2. 点击"添加新留言"测试添加功能
3. 点击"删除"测试删除功能

## 🐛 故障排除

### 常见问题

**1. 数据库连接失败**
```
Warning: mysqli_connect(): (HY000/2002): 由于目标计算机积极拒绝，无法连接
```
- 检查MySQL服务是否启动
- 确认主机名、端口、用户名、密码正确
- 检查数据库是否存在

**2. 权限问题**
- 确保数据库用户有足够的权限
- 检查文件权限设置

**3. 字符编码问题**
- 确保数据库使用utf8mb4字符集
- 检查PHP文件编码为UTF-8

## 📄 许可证

本项目仅供学习和演示使用。

## 🤝 贡献

欢迎提交Issue和Pull Request来改进这个项目。

---

**开发日期**: 2025年
**版本**: 1.0.0 (PHP 8.0)
**作者**: TinyNote Development Team