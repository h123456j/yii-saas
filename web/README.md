
## 一、基本配置

1、将服务器解析到/www/yii-saas/web目录
2、管理后台地址 host/admin/index
3、api地址 host/api/index
4、前端主页 host/

## 二、路由规则配置
Options +FollowSymLinks -Indexes
IndexIgnore */*
RewriteEngine on

# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

otherwise forward it to index.php
RewriteRule ^admin/|^debug /admin.php 管理后台模块路由
RewriteRule ^api/|^doc /api.php api模块路由
