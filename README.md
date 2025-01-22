echo '# AI Image Generation Assistant

一个集成了多个 AI 模型的图像生成助手，支持 OpenAI GPT、Google Gemini，并可以直接与 Discord 集成。

## 功能特点

- 🤖 支持多个 AI 模型
  - OpenAI GPT-3.5/GPT-4
  - Google Gemini
  - 直接模式（无 AI 处理）
- 🎨 Discord 集成
  - 自定义提示词模板
  - 频道选择
  - 用户提及
- 📝 实时显示模型状态
- 🔄 自动错误处理和降级机制

## 安装要求

- PHP 7.4+
- Node.js 14+
- Composer
- npm 或 yarn

## 快速开始

### 1. 克隆项目

```bash
git clone https://github.com/vcbal2580/mj-vcbal-demo
cd mj-vcbal-demo
```

### 2. 后端设置

```bash
cd backend

# 安装依赖
composer install

# 配置文件
cp config.php.example config.php
```

编辑 `config.php` 并填入你的 API 密钥：
- OpenAI API key
- Google Gemini API key
- Discord Webhook URL

### 3. 前端设置

```bash
cd frontend

# 安装依赖
npm install
# 或
yarn install
```

### 4. 启动服务

后端：
```bash
cd backend/public
php -S localhost:8000
```

前端：
```bash
cd frontend
npm start
# 或
yarn start
```

访问 http://localhost:3000 即可使用

## 配置说明

### Discord 设置

在 `config.php` 中配置：
```php
discord => [
    webhook_url => your_discord_webhook_url,
    default_channel_id => your_default_channel_id,
    default_user_id => your_default_user_id,
    prompt_templates => [
        default => /imagine prompt: {prompt},
        detailed => /imagine prompt: {prompt} --quality 2 --stylize 1000,
        artistic => /imagine prompt: {prompt} --ar 16:9 --stylize 1000,
        simple => /imagine prompt: {prompt} --v 5
    ]
]
```

### AI 模型配置

支持的模型：
- gpt-3.5-turbo
- gpt-4
- gemini-pro
- direct (无 AI 处理)

## 项目结构

```
project/
├── backend/
│   ├── app/
│   │   ├── Controllers/
│   │   ├── Services/
│   │   └── Models/
│   ├── public/
│   │   └── index.php
│   ├── composer.json
│   └── config.php.example
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   ├── services/
│   │   └── App.jsx
│   ├── public/
│   ├── package.json
│   └── README.md
```

## 使用方法

1. 在右上角选择想要使用的 AI 模型
2. 在左侧设置 Discord 选项（可选）
   - 选择提示词模板
   - 设置目标频道
   - 配置用户提及
3. 在输入框中输入图像描述
4. 系统会：
   - 使用选定的 AI 模型优化描述
   - 发送到 Discord 频道
   - 显示处理结果

## 常见问题

**Q: 为什么 AI 模型没有响应？**  
A: 检查 `config.php` 中的 API 密钥是否正确配置。确保网络连接正常，API 服务可用。

**Q: Discord 消息没有发送成功？**  
A: 验证 Discord Webhook URL 是否有效，以及机器人是否有正确的权限。检查频道 ID 是否正确。

**Q: 如何添加新的提示词模板？**  
A: 在 `config.php` 的 `discord.prompt_templates` 中添加新的模板配置。

## 开发说明

### 添加新的 AI 模型

1. 在 `backend/app/Services` 中创建新的服务类
2. 在 `ApiService.php` 中注册新模型
3. 更新前端模型选择器

### 自定义 Discord 集成

1. 修改 `DiscordService.php` 中的消息格式
2. 在配置文件中添加新的模板
3. 更新前端 Discord 选项组件

## 贡献指南

1. Fork 项目
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m Add some AmazingFeature`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 打开 Pull Request

## 许可

MIT License - 查看 [LICENSE.md](LICENSE.md) 获取详细信息

## 联系方式

项目维护者 - [@vcbal666@gmail.com

项目链接: [https://github.com/vcbal2580/mj-vcbal-demo](https://github.com/vcbal2580/mj-vcbal-demo)' > README.md

