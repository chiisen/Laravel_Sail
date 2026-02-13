# Laravel Testing 指南 (Laravel Sail)

本文件說明如何在 Laravel Sail 環境中執行測試，特別是關於 **Code Coverage (程式碼覆蓋率)** 的配置。

## 1. 執行基本測試

在 Sail 環境中執行測試的最基本指令：

```bash
./vendor/bin/sail test
```

或是直接使用 Artisan：

```bash
./vendor/bin/sail php artisan test
```

## 2. 產生程式碼覆蓋率 (Code Coverage)

若要產生 HTML 格式的覆蓋率報告，需確保容器內的覆蓋率驅動程式已啟用。

### A. 配置環境 (.env)

Laravel Sail 預設使用 Xdebug。請在 `.env` 中啟用 `coverage` 模式：

```env
# 啟用 Xdebug 的覆蓋率功能
SAIL_XDEBUG_MODE=develop,debug,coverage
```

### B. 重啟服務

修改 `.env` 後，必須重啟容器使設定生效：

```bash
./vendor/bin/sail restart
```

### C. 執行指令

使用以下指令產生 HTML 報告：

```bash
./vendor/bin/sail test --coverage-html coverage
```

此指令會在專案根目錄下建立一個 `coverage/` 資料夾。

### D. 檢視報告

在 macOS 終端機中執行以下指令即可開啟瀏覽：

```bash
open coverage/index.html
```

## 3. 效能優化建議 (使用 PCOV)

如果您覺得 Xdebug 產生報告的速度太慢，可以使用 **PCOV** 作為替代方案：

1. **關閉 Xdebug**: 在 `.env` 中將 `SAIL_XDEBUG_MODE` 設為 `off`。
2. **重啟 Sail**: `./vendor/bin/sail restart`。
3. **執行測試**: 直接執行 `./vendor/bin/sail test --coverage-html coverage`。Sail 會自動偵測並調用內建的 PCOV 驅動程式。

## 4. 注意事項

- **Git 忽略**: 建議將 `coverage/` 資料夾加入 `.gitignore` 以免提交到代碼倉庫。
- **測試資料庫**: Sail 會自動使用 `phpunit.xml` 內定義的 `DB_DATABASE=testing` 進行測試，與開發用的資料庫隔離。
