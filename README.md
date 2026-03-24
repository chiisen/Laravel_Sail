# Laravel_Sail
學習 Laravel Sail 的專案。

## 🐳 Laravel Sail 是什麼？

簡單來說，**Laravel Sail** 就是一個讓你**不用煩惱環境設定**就能馬上開始寫程式的超級好幫手！✨

它幫你把開發網站需要的所有工具（像是 PHP、MySQL 資料庫、Redis...等）都打包在一個叫做 **Docker** 的容器盒子裡。

**為什麼要用它？**

*   🚀 **極速啟動**：你不需要在自己的電腦上安裝 PHP 或 Composer，只要裝好 Docker，指令一打就開工！
*   🛡️ **環境一致**：不管是用 Windows、Mac 還是 Linux，大家的開發環境都一模一樣，不會再出現「奇怪，在我電腦上明明可以跑」的問題。
*   🛠️ **簡單易用**：它提供了一套簡單的指令，讓你輕鬆管理這個開發環境，不用成為 Docker 大師也能用得很開心。

**一句話總結：**
就像是買了一組**「全套廚房懶人包」**，鍋碗瓢盆調味料都準備好了，你只要打開這個包包，專注在「煮菜」（寫程式）這件事上就好囉！👨‍🍳👩‍🍳

## 🚀 快速開始 (Quick Start)

現在，你已經擁有了一個完整的 Laravel Sail Demo！請依照以下「標準作業流程」來初始化並啟動專案，這流程整合了所有常見問題的修復，保證讓你一次成功！✨

### 1. 前置設定 (`.env`)
在啟動 Docker 之前，我們需要先設定使用者權限，以免遇到 `WWWGROUP variable not set` 導致啟動失敗。
請打開專案根目錄下的 `.env` 檔案，確認已加入以下設定：

```ini
WWWUSER=1000
WWWGROUP=1000
```

### 2. 啟動環境
確認你的 Docker Desktop 已經打開，然後在專案目錄執行：

```bash
docker compose up -d
```
> 💡 第一次執行會需要下載與建置 Docker 映像檔，可能需要幾分鐘的時間，請耐心等候。

### 3. 初始化專案 (初次執行必做！)
容器啟動後，我們需要對 Laravel 進行一些初始化設定，請**依序**執行以下指令：

*   **步驟 3-1：產生應用程式金鑰 (APP_KEY)**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```
    > 💡 **為什麼要執行這個？** 此指令會生成一組隨機字串並寫入 `.env` 的 `APP_KEY` 中，用於加密密碼、Session 與各類敏感資料。若沒有此金鑰，Laravel 會無法運行並顯示錯誤。

*   **步驟 3-2：執行資料庫遷移**
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

### 4. 瀏覽網站
當上述步驟都完成後，打開瀏覽器訪問：

👉 **[http://localhost](http://localhost)**

你應該就能看到 Laravel 的歡迎頁面囉！🎉

---

## ⚙️ 環境變數詳細說明 (.env)

在 `.env` 檔案中，有幾個與 Laravel Sail 運作息息相關的變數，了解它們能讓你開發更順手：

### 🔑 APP_KEY
*   **用途**：Laravel 應用的安全金鑰。
*   **生成方式**：執行 `./vendor/bin/sail artisan key:generate`。
*   **注意**：請確保此金鑰在生產環境中保持機密，且不要隨意更改，否則已加密的資料將無法解密。

### 🐳 Sail 權限與除錯設定
為了確保 Docker 容器內的檔案權限與你的本機電腦（Host）一致，我們使用以下變數：

*   **`WWWUSER` & `WWWGROUP`**
    *   **用途**：指定容器內運作 PHP/Nginx 程序的 User ID 與 Group ID。
    *   **設定建議**：通常設定為 `1000`。在 Linux/Mac 上，設定為與你本機使用者相同的 ID（可用 `id -u` 查詢），可以避免在修改程式碼或透過 Sail 產生檔案後發生「權限不足 (Permission Denied)」的困擾。
*   **`SAIL_XDEBUG_MODE`**
    *   **用途**：設定 PHP Xdebug 的模式。
    *   **常用值**：
        *   `off`：關閉 Xdebug（預設，速度較快）。
        *   `debug`：開啟步進除錯（Breakpoint debugging）。
        *   `develop`：開啟開發輔助工具（像是更詳細的錯誤回溯）。
*   **`SAIL_XDEBUG_CONFIG`**
    *   **用途**：傳遞額外的 Xdebug 參數。
    *   **預設值**：`"client_host=host.docker.internal"`，這能引導 Xdebug 正確連接回你的 IDE（如 VS Code 或 PHPStorm）。
*   **確認 Xdebug 狀態**
    *   瀏覽器訪問：`http://localhost/xdebug`
    *   檢查重點：搜尋 "Step Debugger"，確認其狀態為 **✔ enabled**。

### 🐞 Xdebug 故障排除 SOP (Troubleshooting)
如果設定了中斷點（Breakpoint）卻無法停住，請依序執行以下步驟檢查：

1.  **確認 Xdebug 是否已正確連線（Step Debugger）**
    *   瀏覽 [http://localhost/xdebug](http://localhost/xdebug)
    *   搜尋 **Step Debugger**，狀態必須為 **✔ enabled**。
    *   若未啟用，請檢查 `.env` 中的 `SAIL_XDEBUG_MODE` 是否包含 `debug`。

2.  **確認 VS Code 是否正在監聽**
    *   左側「執行與偵錯 (Run and Debug)」面板是否已啟動？（狀態列應呈現橘色）。
    *   是否選擇 **"Listen for Xdebug (Legacy)"**？

3.  **檢查 Xdebug 連線日誌**
    *   若上述都正常但仍無反應，請查看容器內的 Xdebug 錯誤日誌：
        ```bash
        ./vendor/bin/sail exec laravel.test cat /tmp/xdebug.log
        ```
    *   **常見錯誤**：
        *   `Trigger value for 'XDEBUG_SESSION' not found`：表示 Xdebug 不知道現在需要除錯。
            *   **解法**：在 `compose.yaml` 的 `environment` 區塊強制加入 `XDEBUG_SESSION: 1`。
        *   `Time-out connecting to client`：表示容器無法連線到主機。
            *   **解法**：確認 `SAIL_XDEBUG_CONFIG` 包含 `client_host=host.docker.internal`。
            *   **解法**：確認 `launch.json` 中的 `hostname` 設為 `0.0.0.0`（允許來自外部的連線）。

4.  **強制重啟**
    *   修改配置後，務必執行 `down` 與 `up` 讓設定生效：
        ```bash
        ./vendor/bin/sail down && ./vendor/bin/sail up -d
        ```

---

### 🛠️ 工作指令彙整
依照專案規範，請統一使用 `./vendor/bin/sail` 前綴。

*   **啟動服務**：`./vendor/bin/sail up -d`
*   **停止服務**：`./vendor/bin/sail down`
*   **執行 Artisan 指令**：`./vendor/bin/sail artisan ...`
*   **執行 Composer 指令**：`./vendor/bin/sail composer ...`
*   **執行 Node/NPM 指令**：`./vendor/bin/sail npm ...`

---

## 📚 進階指南 & 文件

### 🔰 新手必讀

- **[開發常見操作指南 (Development Guide)](./docs/development_guide.md)**
  - 📖 **新手首選**！說明如何新增常見的功能模組 (Controller, Middleware, Model 等)。
  - 提供指令操作與程式碼範例，包含後端與前端 (Inertia Page) 的整合方式。
  - **新增 Tinker 教學**：詳細介紹 Laravel Tinker 的功能與使用範例。

- **[Laravel Tinker 使用指南](./docs/laravel_tinker.md)**
  - 🛠️ **除錯神器**！REPL 互動式命令行工具的完整教學。
  - 包含模擬登入、SQL 日誌監控、服務層測試等實用範例。
  - 詳細解析每行程式碼的作用，並提供 N+1 查詢除錯技巧。
  - **新手友善**：包含 FAQ 常見問題與視覺化流程圖。

---

### 🏗️ 專案架構

- **[專案目錄架構說明 (Project Structure)](./docs/project_structure.md)**
  - 介紹本專案的前端 (Vue/Inertia) 與後端 (Laravel) 目錄結構與職責。
  - 條列主要功能模組 (Components, Layouts, Controllers) 的存放位置。

- **[Inertia Page Props 配置指南](./docs/inertia-page-props.md)**
  - 說明如何在 Laravel Inertia 專案中設定全域共享資料 (Shared Data)。
  - 包含 Middleware 配置範例與 Vue 前端調用方式。

---

### 🔐 權限與安全

- **[Spatie Laravel Permission 安裝與設定](./docs/laravel-permission-installation.md)**
  - 詳細說明如何在 Laravel Sail 環境下正確安裝並設定 `spatie/laravel-permission` 權限管理套件。
  - 包含常見錯誤排除（如未啟動容器即執行指令）。
  - **[NEW]** 新增「瀏覽器實測流程」，教您如何透過使用者註冊與 Tinker 指令，直接在網頁上驗證權限功能。
  - **[NEW]** 新增「資料庫驗證指南」，說明如何使用 phpMyAdmin 查看權限關聯表。

- **[前後端語系共享與安全保護機制 (i18n Security)](./docs/i18n-security-guide.md)**
  - 詳述如何建立具備自動化加密 (LZ-String) 與壓縮功能的語系系統。
  - 包含 Vite 插件實作，旨在保護語系檔案免於大規模抓取 (Dumping)。

---

### 🌍 多語系 (i18n)

- **[多語系 (i18n) 設定說明](./docs/i18n-setup.md)**
  - 說明如何整合 Laravel 與 Vue i18n，實現前後端單一語系檔 (Single Source of Truth)。

- **[多語系實作總結 (i18n Implementation Summary)](./docs/i18n-implementation-summary.md)**
  - 記錄多語系功能的完整實作過程與技術決策。
  - 包含遇到的挑戰與解決方案。

---

### 🧪 測試與除錯

- **[Laravel Testing 指南 (含 Coverage)](./docs/laravel-testing.md)**
  - 說明如何在 Laravel Sail 環境中執行測試。
  - 包含如何透過 Xdebug 或 PCOV 產生 HTML 格式的程式碼覆蓋率 (Code Coverage) 報告。
  - [coverage](./coverage)

- **[Session 與 Redis 儲存說明](./docs/laravel_session.md)**
  - 記錄專案中 Session 的儲存機制、序列化格式 (PHP Serialization) 以及安全性配置。
  - 提供多種查看 Session 資料的方法，包含 Redis CLI、Tinker 以及 Redis Insight 圖形化介面。

---

### 🤖 AI 輔助工具

- **[Aider 使用指南](./docs/aider_guide.md)**
  - 說明如何使用 Aider AI 輔助編程工具加速開發。
  - 包含常見使用情境與指令範例。

- **[GrepAI 使用指南](./docs/grepai_guide.md)**
  - 說明如何使用 GrepAI 進行程式碼搜尋與分析。

---

### 🎨 設計規範

- **[設計系統指南 (Design System)](./docs/design-guidelines.md)**
  - 定義專案的 UI/UX 設計規範與元件使用方式。
  - 包含色彩、排版、間距等視覺設計標準。


  