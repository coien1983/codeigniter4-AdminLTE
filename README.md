# codeigniter4-AdminLTE
codeigniter4-AdminLTE

## 安装步骤
#### clone 项目到本地
```
https://github.com/coien1983/codeigniter4-AdminLTE.git
```

#### 安装项目依赖
```
composer install
```

#### 配置数据库
更改 env的数据库配置
或者更改 `app/Config/Database.php` 文件内的数据库配置选项，数据库编码推荐`utf8mb4`。

#### 相关配置
更改项目根目录：`app/Config/App.php` 中的 $baseURL为你的域名根目录
更改writable目录为可写
推荐缓存使用redis，可在`app/Config/Cache.php`中进行配置


#### 运行数据库迁移命令
数据库文件存放目录data,将codeigniter4.mysql文件导入到数据库中

#### 配置URL重写
apache重写：
```
<IfModule mod_rewrite.c>

RewriteEngine on

RewriteCond %{REQUEST_FILENAME} !-d

RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.*)$ /index.php/$1 [QSA,PT,L]

</IfModule>
```
nginx重写：
```
location / {
    if (!-f $request_filename){
        set $rule_0 1$rule_0;
    }
    if (!-d $request_filename){
        set $rule_0 2$rule_0;
    }
    if ($rule_0 = "21"){
        rewrite ^/(.*)$ /index.php?/$1 last;
    }
}
```
#### 访问后台
访问`/admin/index`，默认超级管理员的账号密码都为`codeigniter4`。

#### 后台权限路由添加方式
访问目录文件`/app/Config/Aci.php`，
将需要添加的路由加到对应的module下，添加后台菜单的时候，就可以找到对应路由。

## 其他说明
本项目采用大量的开源代码，包括CodeIgniter4，AdminLTE等等。
部分代码可能署名已被某些前辈去掉，我也没来得及去查找具体的作者。
在此，对所有用到的开源代码作者表示由衷的感谢。
关于CodeIgniter4,中文文档请移步至https://codeigniter.org.cn/

## 20200930版本更新
新闻模块集成，使用bootstrap-fileinput组件，wangEditor组件，集成图片上传七牛云。
