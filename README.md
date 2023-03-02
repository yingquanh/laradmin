<p align="center">
<font size=6><b>Laradmin</b></font>
</p>

<p align="center">
<a href="https://github.com/yingquanh/laradmin/releases"><img src="https://img.shields.io/github/v/release/yingquanh/laradmin" alt="Laramin Version"></a>
<a href="https://www.php.net"><img src="https://img.shields.io/badge/php-%3E%3D8.1-blue" alt="PHP Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/badge/laravel-%3E%3D9.19-brightgreen" alt="Laravel Framework"></a>
<a href="https://github.com/swoole/swoole-src"><img src="https://img.shields.io/badge/swoole-%3E%3D4.0-brightgreen" alt="Swoole Version"></a>
<a href="https://github.com/yingquanh/laradmin/blob/master/LICENSE"><img src="https://img.shields.io/github/license/yingquanh/laradmin" alt="License"></a>
</p>

## 服务器要求

1.项目框架对系统有一些要求，请确保你的 Web 服务器至少满足以下 PHP 版本及扩展需求。

- PHP >= 8.1
- BCMath PHP 扩展
- Ctype PHP 扩展
- DOM PHP 扩展
- Fileinfo PHP 扩展
- JSON PHP 扩展
- Mbstring PHP 扩展
- OpenSSL PHP 扩展
- PCRE PHP 扩展
- PDO PHP 扩展
- Tokenizer PHP 扩展
- XML PHP 扩展
- Swoole PHP 扩展

2.项目配套软件安装要求。

- DM v8
- Nginx >= 1.22
- Redis >= 7.0
- Supervisor >= 4.2

## 服务器配置

#### Nginx

``` vim
gzip on;
gzip_min_length 1024;
gzip_comp_level 2;
gzip_types text/plain text/css text/javascript application/json application/javascript application/x-javascript application/xml application/x-httpd-php image/jpeg image/gif image/png font/ttf font/otf image/svg+xml;
gzip_vary on;
gzip_disable "msie6";
upstream swoole {
    # 通过 IP:Port 连接
    server 127.0.0.1:5200 weight=5 max_fails=3 fail_timeout=30s;
    # 通过 UnixSocket Stream 连接，小诀窍：将socket文件放在/dev/shm目录下，可获得更好的性能
    #server unix:/yourpath/laravel-s-test/storage/laravels.sock weight=5 max_fails=3 fail_timeout=30s;
    #server 192.168.1.1:5200 weight=3 max_fails=3 fail_timeout=30s;
    #server 192.168.1.2:5200 backup;
    keepalive 16;
}
server {
    listen 80;
    # 别忘了绑Host
    server_name shjianchayuan.com;
    root /yourpath/shjianchayuan/public;
    access_log /yourpath/log/nginx/$server_name.access.log  main;
    autoindex off;
    index index.html index.htm;
    # Nginx处理静态资源(建议开启gzip)，LaravelS处理动态资源。
    location / {
        try_files $uri @laravels;
    }
    # 当请求PHP文件时直接响应404，防止暴露public/*.php
    #location ~* \.php$ {
    #    return 404;
    #}
    location @laravels {
        # proxy_connect_timeout 60s;
        # proxy_send_timeout 60s;
        # proxy_read_timeout 120s;
        proxy_http_version 1.1;
        proxy_set_header Connection "";
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Real-PORT $remote_port;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header Server-Protocol $server_protocol;
        proxy_set_header Server-Name $server_name;
        proxy_set_header Server-Addr $server_addr;
        proxy_set_header Server-Port $server_port;
        # “swoole”是指upstream
        proxy_pass http://swoole;
    }
}
```

#### Supervisor

> 通过 Supervisord 监管主进程，并且设置 swoole.daemonize 为 false。

``` vim
[program:shjianchayuan]
directory=/var/www/shjinachayuan
command=/usr/local/bin/php bin/laravels start -i
numprocs=1
autostart=true
autorestart=true
startretries=3
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/supervisor/%(program_name)s.log
```

## 部署应用程序

> 未使用 cd 命令切换目录时，所有操作皆在应用程序根目录下进行。

1.安装项目依赖软件包

``` shell
composer install --optimize-autoloader --no-dev
```

2.设置应用程序密钥

``` shell
php artisan key:generate
```

3.设置应用程序公共文件目录符号链接

``` shell
php artisan storage:link
```

4.设置应用程序配置文件 `.env`

``` shell
# 打开配置文件
vim .env

# 写入数据库配置
DB_CONNECTION=dm        # 驱动
DB_HOST=[127.0.0.1]     # 主机
DB_PORT=[3306]          # 端口
DB_DATABASE=[laravel]   # 数据库
DB_USERNAME=[root]      # 用户名
DB_PASSWORD=[password]  # 密码

# 写入 Redis 配置
REDIS_HOST=[127.0.0.1]  # 主机
REDIS_PASSWORD=[null]   # 密码
REDIS_PORT=[6379]       # 端口

# 写入 Sanctum 配置
SANCTUM_STATEFUL_DOMAINS=[127.0.0.1:8001]   # 域名端口

# 写入 Laravels 配置
LARAVELS_LISTEN_PORT=[8001]     # 服务监听端口
LARAVELS_HANDLE_STATIC=true     # 是否启动静态资源 true | false 
LARAVELS_INOTIFY_RELOAD=true    # 是否启动自动加载 true | false

# 写入信创配置
WECHAT_WORK_CORP_ID=[corpid]    # 信创 corpid
WECHAT_WORK_SECRET=[secret]     # 信创 Secret
WECHAT_WORK_TOKEN=[token]       # 信创 token
WECHAT_WORK_AES_KEY=[aeskey]    # 信创 aeskey
```

3.优化加载

``` shell
php artisan optimize
```

4.运行调度程序

> 向服务器添加一个 cron 配置项，该项每分钟运行一次 schedule:run 命令。

``` shell
# 编辑 cron 配置项
crontab -e

# 按 I 键进入编辑模式
* * * * * /usr/bin/php /yourpath/shjianchayuan/artisan schedule:run >> /dev/null 2>&1
```

5.启动应用程序

``` shell
# 通过 Supervisor 启动项目
/usr/bin/supervisorctl start shjianchayuan:*

# 查看项目运行状态
/usr/bin/supervisorctl status shjianchayuan:*

# 或查看 laravels 进程
ps aux | grep laravels
```