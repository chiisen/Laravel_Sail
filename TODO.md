# TODO List — Laravel_Sail 優化計畫

> 基於 Laravel Sail + Vue 3 + Inertia + Tailwind 的學習專案

---

## 功能面 (Features)

### ✅ 建立示範性 CRUD 範例（文章/部落格系統）— 2026-05-19
- Model、Migration、Seeder 已建立
- Controller、Request、Vue Page 已建立
- Routes 已設定（需要認證）
- 教學流程：Model → Migration → Seeder → Controller → Request → Page(Inertia) → Route

### 🔲 串接 Redis 快取範例（快取文章列表）
- 前置條件：確認 docker-compose.yml 已有 redis 容器
- 實作：使用 Cache::remember() 包裝 Post::latest()->get()

### 🔲 建立 REST API 路由範例（api.php）
- 需建立無需認證的 API 版本用於教學

### 🔲 整合 spatie/laravel-permission 權限管理範例
- 現有：migration 已執行、package 已裝
- 實作方向：展示 Role/Permission 的 seed 流程與前端 LanguageSwitcher 配合

---

## 開發體驗 (DX)

### 🔲 建立 Makefile 整合常用 sail 指令（教學用）
- 完整指令替代 Bash alias，方便學生git追蹤
- 目標：`make migrate`, `make seed`, `make test`, `make dev`

### 🔲 調整 VS Code debug 配置（launch.json for Sail + Xdebug）
- 現有：launch.json 存在但只有 Legacy 設定
- 需修正：Sail + Docker 環境的正確 pathMappings 與配置

### 🔲 補完 Sail 環境變數說明（.env.example 註解）

### 🔲 簡化 `./vendor/bin/sail` 指令（Makefile 已取代 Bash alias）

---

## 文件 (Docs)

### 🔲 完成 `docs/` 下的 Sail 指令對照表（sail vs 傳統 artisan）
- 現有：aider_guide.md、design-guidelines.md、development_guide.md 等
- 新增：sail_command_cheatsheet.md

### 🔲 將「Docker 效能優化」技巧文件化（Volumes、效能瓶頸說明）

---

## 測試 (Testing)

### 🔲 建立 PHPUnit 基礎設定
- 現有：phpunit.xml 已存在
- 未來：每個功能項目都須寫 Feature test

### 🔲 建立 GitHub Actions CI 流程（測試 + lint）

### 🔲 將 coverage/ 報告整合進 README

---

## 維運 (Ops)

### 🔲 .env 安全性檢查（確認無 secrets 遺漏進 git）

### 🔲 設定 Docker 健康檢查（healthcheck）
- redis 已有 healthcheck，需檢查整體覆蓋率

### 🔲 考慮移出 vendor/、node_modules/（只保留 Dockerfile/composer.json 即可重構）

---

## 🚧 CRUD 測試流程

### 前置條件
```bash
cd /Users/liao-eli/github/laravel_sail
./vendor/bin/sail up -d
```

### 執行 Migration + Seeder
```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

### 開啟瀏覽器
```
http://localhost
```
登入後訪問 `/posts` 即可測試 CRUD（需要 auth middleware）

### 操作項目
| 操作 | 網址 |
|------|------|
| 文章列表 | /posts |
| 新建文章 | /posts/create |
| 編輯文章 | /posts/{id}/edit |
| 刪除文章 | 列表頁按鈕 |

### 停止環境
```bash
./vendor/bin/sail down
```