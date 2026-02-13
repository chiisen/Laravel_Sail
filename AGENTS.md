# Project Memory

## 繼承規範 (Inherited Standards)
本專案嚴格遵循 **User Global Rules (`~/.gemini/GEMINI.md`)** 中定義的開發規範，包括但不限於：
1. **核心技術棧** (Laravel 11, Vue 3, Sail, Inertia)
2. **變更管理規範** (CHANGELOG 維護)
3. **Git 提交規範** (Semantic Commit Messages)
4. **開發工作流** (AACS 協定)

> ⚠️ **注意**：無需在此檔案重複定義通用規則。此檔案僅用於記錄 **本專案特有** 的架構決策、關鍵備忘或長期忽略的上下文。

## 專案專屬備忘錄 (Project Specifics)
- **目前狀態**：專案文件與開發指南已完善 (參見 `README.md` 與 `docs/`)。
- **權限系統**：使用 `spatie/laravel-permission`，並透過 `LanguageSwitcher` 實現多語系前端切換。
