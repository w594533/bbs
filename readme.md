## 项目概述

- 项目名称：laravel教程 论坛系统接口
- 项目代码：BBS
- 接口地址：待提供
Laravel 5.6版本

## 运行环境


## 开发环境部署/安装

本项目代码使用PHP框架[Laravel 5.6](https://laravel-china.org/docs/laravel/5.6)，本地开发环境使用[Laravel Homestead](https://doc.laravel-china.org/docs/5.1/homestead)。

如果您还未安装 Homestead，可以参照 [Homestead 安装与设置](https://doc.laravel-china.org/docs/5.1/homestead#installation-and-setup) 进行安装配置。

以下的描述是在环境配置完好的情况。

### 基础安装

**1.克隆源代码**

克隆源代码到本地：

` git clone https://github.com/w594533/bbs.git `

**2.安装扩展包依赖**

` composer install `

**3.生成配置文件**

` cp .env.example .env `

进行相关配置，数据库配置，比如：

```
APP_URL=
APP_DEBUG=
APP_NAME=
API_STANDARDS_TREE=prs
API_SUBTYPE=bbs
API_PREFIX=api
API_VERSION=v1
API_DEBUG=true

WEIXIN_KEY=
WEIXIN_SECRET=
WEIXIN_REDIRECT_URI=

BAIDU_TRANSLATE_API_KEY=
BAIDU_TRANSLATE_API_SECRET=
```

**4.配置**

   **1)生成app key**

   `php artisan key:generate`

   **2)storage链接**

   `php artisan storage:link`

**5.数据迁移&填充**

请保证数据库信息已配置好

`php artisan migrate --seed`

**6.后台管理系统安装**

`php artisan admin:install`

进入xxx/admin/ 即可访问后台管理 默认账号密码admin admin
