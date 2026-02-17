# DomainList

> Premium Domain Showcase & Management Console

[![Repo](https://img.shields.io/badge/GitHub-gentpan%2FDomainList-111827)](https://github.com/gentpan/DomainList)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777bb4)](https://www.php.net/)
[![Status](https://img.shields.io/badge/status-active-72BF80)](#)

DomainList 是一个面向精品域名场景的展示与管理系统。

它将前台域名展示、后台运营管理、WHOIS 同步、分类体系、邮件通知与 JSON 数据流整合到同一套轻量架构中，适合个人域名投资组合、团队域名资产管理与品牌域名展示。

## Live Repository

- GitHub: [https://github.com/gentpan/DomainList](https://github.com/gentpan/DomainList)

## Core Capabilities

- 高级感前台域名展示页面（筛选、分页、详情）
- 后台统一管理面板（域名、分类、后缀、展示参数、首页配置、站点设置）
- WHOIS / RDAP 一键同步（注册时间、到期时间、注册年限）
- 注册年限徽章规则（20+ / 10-19 / 5-9 / 3-4 / 1-2）
- JSON 导入/导出（域名、关键词分类、后缀分类）
- 联系与邮件发送配置（Resend / SMTP）
- CSRF 防护与后台密码更新机制

## Architecture

```text
admin/          后台管理页面
api/            数据接口（JSON API）
app/            核心函数与工具
assets/         前端资源（CSS / JS / Images）
data/           JSON 数据存储
includes/       公共页面片段
pages/          站点页面
```

## Tech Stack

- **Backend:** PHP (file-based)
- **Storage:** JSON files
- **Frontend:** Vanilla JS + CSS
- **UI:** Bootstrap + custom design system
- **Icons/Fonts:** Font Awesome Pro + BlueCDN

## Quick Start

### 1. Clone

```bash
git clone https://github.com/gentpan/DomainList.git
cd DomainList
```

### 2. Run (local)

```bash
php -S 127.0.0.1:8000
```

### 3. Open

- Frontend: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- Admin: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

## Admin Modules

- 域名管理（筛选 / 分页 / 导入导出 / WHOIS 更新）
- 关键词分类（增删 + JSON 导入导出）
- 后缀分类（增删 + JSON 导入导出）
- 展示设置（卡片、列数、分页参数）
- 首页 Welcome 配置（图文内容与素材）
- 邮件配置（通道参数与测试）
- 站点设置（名称、标题、描述、密码安全）

## Data Portability

支持通过 JSON 做数据迁移与批量维护：

- `domains.json`
- `categories.json`
- `suffixes.json`

## Security Notes

- 后台敏感操作默认启用 CSRF 校验
- 建议部署后立即更新管理员密码
- 建议将 `data/` 目录纳入服务器访问控制策略

## Roadmap

- [ ] 多管理员与权限分级
- [ ] 批量编辑域名
- [ ] 数据审计日志
- [ ] 数据库存储模式（MySQL/PostgreSQL）
- [ ] API Token 授权

## Screenshots

> 建议放置以下截图后替换路径：

- `docs/screenshots/login.png`
- `docs/screenshots/admin-domains.png`
- `docs/screenshots/frontend-home.png`

## License

MIT

---

If this project helps you, consider giving it a star on GitHub.
