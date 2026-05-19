# TODO List — Laravel_Sail 優化計畫

> 基於 Laravel Sail + Vue 3 + Inertia + Tailwind 的學習專案

---

## 功能面 (Features)

- [ ] 建立示範性 CRUD 範例（文章/部落格系統）
  - Model、Migration、Seeder 完整流程
  - 配合 sail artisan 指令展示
- [ ] 整合 spatie/laravel-permission 權限管理範例
  - 角色與權限的-seed 流程
  - 前端 LanguageSwitcher 多語系切換實際應用
- [ ] 建立 REST API 路由範例（api.php）
- [ ] 串接 Redis 快取範例（快取文章列表）

---

## 開發體驗 (DX)

- [ ] 簡化 `./vendor/bin/sail` 指令（建立 `sa` alias 腳本）
- [ ] 補完 Sail 環境變數說明（.env.example 註解）
- [ ] 調整 VS Code debug 配置（launch.json for Sail + Xdebug）
- [ ] 建立 Makefile 整合常用 sail 指令

---

## 文件 (Docs)

- [ ] 完成 `docs/` 下的 Sail 指令對照表（sail vs 傳統 artisan）
- [ ] 補完 local.http 測試 API 範例（若需要）
- [ ] 將「Docker 效能優化」技巧文件化（Volumes、效能瓶頸說明）

---

## 測試 (Testing)

- [ ] 補完單元測試（Feature test for CRUD）
- [ ] 建立 GitHub Actions CI 流程（測試 + lint）
- [ ] 將 coverage/ 報告整合進 README

---

## 維運 (Ops)

- [ ] .env 安全性檢查（確認無 secrets 遺漏進 git）
- [ ] 設定 Docker 健康檢查（healthcheck）
- [ ] 考慮移出 vendor/、node_modules/（只保留 Dockerfile/composer.json 即可重構）