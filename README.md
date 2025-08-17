# Kolink 项目说明

## 项目简介
Kolink 是一个基于 Laravel 框架的区块链与社交数据聚合平台，支持以太坊链数据、Twitter、YouTube 等多平台数据采集与分析。前端采用 Vite 构建，后端包含 PHP、Go 等多种脚本。

## 安装步骤
1. 克隆仓库：
   ```bash
   git clone https://github.com/easycheaplife/kolink.git
   cd kolink
   ```
2. 安装依赖：
   ```bash
   composer install
   npm install
   ```
3. 配置环境：
   - 复制 `.env.example` 为 `.env`，并根据实际情况填写数据库、API 密钥等信息。
   - 运行 `php artisan key:generate` 生成应用密钥。
4. 数据库迁移与填充：
   ```bash
   php artisan migrate --seed
   ```
5. 启动服务：
   ```bash
   php artisan serve
   npm run dev
   ```

## 使用方法
- 后端接口通过 Laravel 路由（见 `routes/` 目录）暴露。
- 前端页面位于 `resources/views/`，静态资源在 `resources/js/` 和 `resources/css/`。
- 数据采集脚本可在 `script/` 目录下运行。

## crontab 定时任务
```
	* * * * * cd /var/www/html/kolink && php artisan schedule:run >> /dev/null 2>&1
	* * * * * cd /var/www/html/kolink && php artisan app:twitter-command >> /dev/null 2>&1
	*/10 * * * * cd /var/www/html/kolink && php artisan app:etherscan-command >> /dev/null 2>&1
	* * * * * cd /var/www/html/kolink/script/transaction && go run transaction.go >> /tmp/transaction.log
	* * * * * cd /var/www/html/kolink/script/transaction && go run call.go >> /tmp/call.log
```

## 主要目录结构
- `app/`         后端核心代码（模型、控制器、服务等）
- `routes/`      路由定义
- `resources/`   前端页面与静态资源
- `script/`      数据采集与处理脚本
- `database/`    数据库迁移与填充
- `public/`      Web 入口文件
- `tests/`       单元与功能测试

## 接口文档
- API 路由请参考 `routes/api.php`，支持 RESTful 风格。
- 主要接口：
  - `/api/twitter` Twitter 用户与推文数据
  - `/api/etherscan` 以太坊链数据
  - `/api/youtube` YouTube 用户数据
  - 更多接口请查阅代码注释与路由文件

## 贡献指南
1. Fork 本仓库并新建分支
2. 提交 PR 前请确保通过所有测试
3. 代码风格遵循 PSR-12（PHP）、ESLint（JS）规范
4. 欢迎 issue 或 PR 反馈与建议

## License
本项目采用 MIT License。
