# QA 报告 — AuraAI (AllScented)

## 基本信息

| 项目 | 值 |
|------|-----|
| 站点 | AuraAI — AI-Powered Fragrance Platform |
| 源设计 | Stitch 0729-v2 (4 pages: Home, Boutique, AI Synthesis, Archive) |
| 主题类型 | Hello Elementor Child Theme |
| 多语言 | 单语言 (English) |
| 检查日期 | 2026-07-29 |
| 检查人 | Codex / auto-site-builder |

## 检查结果

| 维度 | 状态 | 备注 |
|------|------|------|
| 🎨 视觉统一 | ✅ | 所有 CSS 变量定义在 :root，Playfair Display + Hanken Grotesk（SIL OFL 免费字体） |
| 📐 代码正确 | ✅ | WP 规范遵循，wp_head/footer 正确，enqueue 加载，ACF 字段注册 |
| 🔗 功能完整 | ✅/⚠️ | 基础导航/页面/ACF 完整；WooCommerce 集成标记为可选 |
| ⚖️ 合规检查 | ⚠️ | 隐私/条款/联系页面需用户自行创建并填充内容；图片用 Unsplash 免费图 |
| 🌐 多语言 | N/A | 纯英文站，无 Polylang 需求 |

## 文件清单

| 文件 | 行数 | 说明 |
|------|------|------|
| `style.css` | ~600 | 全部 CSS 内联，无 Tailwind CDN，使用 CSS 变量设计系统 |
| `functions.php` | 140 | WP enqueue + ACF 字段组（Home / Boutique）+ 页面模板注册 |
| `header.php` | 58 | 固定导航栏，移动端汉堡菜单，活性导航高亮 |
| `footer.php` | 42 | 底部版权 + 社交链接 + scroll-reveal + aura-mist JS |
| `front-page.php` | 142 | Home: ① AI 推荐 Hero → ② Bento Grid Archive → ③ 产品预览 |
| `page-boutique.php` | 255 | Boutique: ① Hero → ② 分类过滤 Tab → ③ 6 产品网格 → ④ CTA |
| `page-ai-synthesis.php` | 148 | AI Synthesis: ① 三路径卡片 → ② 模拟 Profile → ③ 推荐产品 → ④ CTA |
| `page-archive.php` | 216 | Archive: ① 分类导航 → ② Personal 编辑卡片 → ③ Home 网格 → ④ Commercial |
| `page.php` | 18 | 通用页面回退 |
| `404.php` | 14 | 404 页面 |
| `screenshot.png` | — | 1200×900 主题截图 |

## 发现的问题

### [P2] 图片使用 Unsplash 占位图
- **位置**：所有页面模板
- **问题**：Stitch 设计中使用 Google AIDA 生成图，无法直接链接。已替换为 Unsplash 免费图充数
- **修复**：用户需替换为自己的产品图。ACF 字段已预留图片上传（front-page 产品有 ACF 图片字段，

但 Boutique 产品暂用硬编码，如需可加 ACF）

### [P2] WooCommerce 集成未完整实现
- **位置**：functions.php
- **问题**：当前产品网格为静态 HTML 而非 WooCommerce 产品循环
- **修复**：如需 WooCommerce，后续可以 `wc_get_products()` 替换静态数据

### [P3] 中国访问的图片加载
- **位置**：所有图片
- **问题**：Unsplash 和 Google Fonts 在中国可能加载慢
- **修复**：建议将图片部署到站点本地（香港服务器），Google Fonts 已通过 enqueue 加载

## 最终结论

**通过 ✓** — 可推送 GitHub

未修复项：
- P2 图片占位 → 用户自行替换
- P2 WooCommerce 集成 → 根据需求后续迭代
