-- TinyNote 留言板数据库结构
-- PHP 8.0 版本

-- 创建数据库（如果不存在）
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `test`;

-- 创建留言表
DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL COMMENT '留言者姓名',
    `content` text NOT NULL COMMENT '留言内容',
    `ndate` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '留言时间',
    `add` varchar(255) DEFAULT NULL COMMENT '附加信息（预留字段）',
    `ip` varchar(45) DEFAULT NULL COMMENT '留言者IP地址',
    `user_agent` text DEFAULT NULL COMMENT '用户代理信息',
    `status` tinyint(1) DEFAULT 1 COMMENT '状态：1=正常，0=已删除',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    PRIMARY KEY (`id`),
    KEY `idx_ndate` (`ndate`),
    KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='留言表';

-- 插入一些测试数据
INSERT INTO `note` (`name`, `content`, `ndate`, `ip`, `user_agent`) VALUES
('管理员', '欢迎使用PHP 8.0 MVC留言板系统！这是一个现代化的留言本应用。', NOW(), '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'),
('张三', '这个系统很不错，界面很现代化！', NOW(), '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'),
('李四', 'PHP 8.0的新特性确实很强大，性能提升明显。', NOW(), '192.168.1.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)'),
('王五', 'MVC架构让代码结构很清晰，维护起来很方便。', NOW(), '192.168.1.102', 'Mozilla/5.0 (X11; Linux x86_64)');

-- 创建视图（可选）：只显示未删除的留言
CREATE OR REPLACE VIEW `active_notes` AS
SELECT 
    `id`,
    `name`,
    `content`,
    `ndate`,
    `created_at`,
    `updated_at`
FROM `note` 
WHERE `status` = 1 
ORDER BY `ndate` DESC;

-- 显示表结构
DESCRIBE `note`;

-- 显示测试数据
SELECT * FROM `note` WHERE `status` = 1 ORDER BY `ndate` DESC;