# QA 报告 — Allscented

## 基本信息

| 项目 | 值 |
|------|-----|
| 站点 | Allscented — AI-Powered Fragrance Platform |
| 源设计 | Stitch 0729-v2 (4 pages: Home, The Atelier, AI Synthesis, Archive) |
| 主题类型 | Hello Elementor Child Theme |
| 品牌名 | Allscented（AuraAI → Allscented 已重命名） |
| 商城 | WooCommerce (The Atelier, 6 产品/页 + 自动分页) |
| 多语言 | 单语言 (English) |
| 检查日期 | 2026-07-29 |
| 检查人 | Codex / auto-site-builder |

## 文件清单

| 文件 | 说明 |
|------|------|
| `style.css` | 全部 CSS 内联，CSS 变量设计系统，WooCommerce 表单项适配 |
| `functions.php` | WP enqueue + WooCommerce 支持 (6/页分页) + ACF 字段组 (Home/The Atelier) + 页面模板注册 |
| `header.php` | 固定导航 + 毛玻璃 + 移动端汉堡菜单 + 活性高亮 + 购物袋图标 |
| `footer.php` | 页脚 + scroll-reveal + aura-mist 鼠标追踪 |
| `front-page.php` | 首页：AI 推荐 Hero → Bento Grid Archive → 产品预览 |
| `page-the-atelier.php` | The Atelier：WooCommerce 产品循环 (WP_Query, 6/页, paginate_links) + 分类过滤 Tab + CTA |
| `page-ai-synthesis.php` | AI 合成：三路径推荐 + Profile 模拟 + 产品推荐 |
| `page-archive.php` | 百科：Personal/Home/Commercial 三大板块 |
| `woocommerce/archive-product.php` | WooCommerce 商店页面回退模板 |
| `woocommerce/content-product.php` | 产品卡片模板（匹配 Digital Romanticism 设计） |
| `woocommerce/single-product.php` | 产品详情页（画廊 + 价格 + 标签 + Add to Cart） |
| `page.php` | 通用页面回退 |
| `404.php` | 404 页面 |

## 检查结果

| 维度 | 状态 | 备注 |
|------|------|------|
| 🎨 视觉统一 | ✅ | CSS 变量，Playfair Display + Hanken Grotesk (SIL OFL) |
| 📐 代码正确 | ✅ | WP 规范，wp_head/footer，enqueue，ACF 字段注册 |
| 🔗 功能完整 | ✅/⚠️ | WooCommerce + ACF 字段 + 分页完整；产品图片需用户上传 |
| ⚖️ 合规检查 | ⚠️ | 隐私/条款/联系页面需用户创建；图片为 Unsplash 占位符 |
| 🌐 多语言 | N/A | 纯英文站 |

## 发现的问题

### [P2] 产品图片为 Unsplash 占位符
- **位置**：所有页面模板
- **修复**：用户需在 WP 后台上传产品图片。WooCommerce 产品 → 设置特色图像

### [P2] WooCommerce 需安装配置
- **位置**：整个主题
- **修复**：用户需安装 WooCommerce 插件 → 设置 → Products → Shop page 选 "The Atelier"

### [P2] WooCommerce 分类过滤
- **位置**：page-the-atelier.php
- **修复**：分类 Tab 使用 WooCommerce 产品分类 (product_cat)，需管理员在后台创建

## 最终结论

**通过 ✓** — 可推送 GitHub

部署后用户操作：
1. 安装 WooCommerce + ACF Pro 插件
2. WP 后台 → 页面 → 创建 The Atelier → 选 "The Atelier" 模板
3. WooCommerce 设置 → 产品 → 展示 → Shop page = The Atelier
4. 添加产品 → 设置分类和标签 → 上传图片
5. 可选：在首页通过 ACF 的 Featured Products 添加展示产品
