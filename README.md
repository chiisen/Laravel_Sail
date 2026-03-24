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

---

## ⚖️ Laravel Sail vs. 傳統 Laravel 開發環境比較

### 📊 快速比較表

| 比較項目 | 🐳 Laravel Sail (Docker) | 💻 傳統開發 (本機安裝) |
|---------|----------------------|---------------------|
| **環境設定時間** | ⚡ 5-10 分鐘（只需 Docker） | ⏱️ 1-2 小時（需安裝 PHP、Composer、MySQL 等） |
| **跨平台一致性** | ✅ 完全一致（容器隔離） | ⚠️ 因作業系統而異 |
| **系統資源佔用** | 📦 較高（需運行多個容器） | 🎯 較低（直接使用本機資源） |
| **學習曲線** | 📈 需基礎 Docker 知識 | 📉 需熟悉各元件安裝與配置 |
| **開發指令** | `./vendor/bin/sail artisan ...` | `php artisan ...` |
| **檔案權限問題** | ⚠️ 需設定 `WWWUSER`/`WWWGROUP` | ✅ 通常無問題 |
| **Xdebug 除錯** | ⚙️ 需額外配置（但已整合） | 🔧 需手動設定 php.ini |
| **多版本切換** | ✅ 輕鬆（改映像檔版本） | ⚠️ 需安裝多版本或使用版本管理工具 |
| **生產環境部署** | ⚠️ 需額外考慮（通常不用 Sail） | ✅ 與開發環境相似 |
| **離線開發** | ❌ 首次需下載映像檔 | ✅ 安裝完成後完全離線 |

---

### 🐳 Laravel Sail 的優點

#### ✅ 推薦使用 Sail 的情境

1. **團隊開發**
   - 🎯 確保所有開發者環境完全一致
   - 🎯 新人 Onboarding 時間大幅縮短
   - 🎯 減少「在我電腦可以跑」的問題

2. **多專案開發**
   - 🎯 每個專案獨立容器，互不干擾
   - 🎯 可輕鬆切換不同 PHP/MySQL 版本
   - 🎯 不會污染本機環境

3. **快速原型開發**
   - 🎯 幾分鐘內就能啟動完整開發環境
   - 🎯 自帶常用工具（Redis、Mailhog、phpMyAdmin 等）
   - 🎯 專注於業務邏輯，不用煩惱環境配置

4. **跨平台開發**
   - 🎯 Windows、Mac、Linux 開發體驗一致
   - 🎯 特別適合 Windows 開發者（無需 WSL 複雜設定）

---

### 🐳 Laravel Sail 的缺點

#### ⚠️ 需要注意的地方

1. **系統資源消耗**
   - 💾 Docker 容器需要額外記憶體（通常建議 4GB+）
   - 💾 磁碟空間佔用較多（映像檔 + 容器）

2. **檔案 I/O 效能**
   - 🐌 在 Windows/Mac 上，容器與主機間的檔案同步可能較慢
   - 🐌 大量檔案操作（如 `composer install`）可能較本機慢

3. **指令較長**
   - ⌨️ 需輸入 `./vendor/bin/sail` 前綴（但可用 alias 簡化）
   - ⌨️ 習慣 `php artisan` 後需要適應

4. **網路配置複雜**
   - 🌐 容器間通訊需理解 Docker 網路
   - 🌐 某些情況下需處理 port 衝突

---

### 💻 傳統開發的優點

#### ✅ 適合使用本機開發的情境

1. **效能要求高**
   - ⚡ 直接使用本機資源，無容器開銷
   - ⚡ 檔案 I/O 速度最快

2. **單一專案長期開發**
   - 🎯 環境設定一次，長期使用
   - 🎯 熟悉後開發效率高

3. **資源受限環境**
   - 💾 記憶體較小（< 8GB）的電腦
   - 💾 磁碟空間有限

4. **生產環境部署**
   - 🎯 開發環境與生產環境架構相似
   - 🎯 減少部署時的意外問題

---

### 💻 傳統開發的缺點

#### ⚠️ 可能遇到的問題

1. **環境設定複雜**
   - ⏱️ 需手動安裝 PHP、Composer、MySQL、Redis 等
   - ⏱️ 不同作業系統安裝方式不同
   - ⏱️ 版本衝突問題（如多專案需要不同 PHP 版本）

2. **團隊協作困難**
   - ⚠️ 每個人的環境可能不同
   - ⚠️ 新人加入需花費大量時間設定環境
   - ⚠️ 作業系統差異導致的相容性問題

3. **系統污染**
   - 🗑️ 安裝多個 PHP 版本與擴充套件
   - 🗑️ 全域套件可能互相影響
   - 🗑️ 移除時可能殘留設定

---

### 🎯 建議與結論

| 開發者類型 | 推薦方案 | 理由 |
|-----------|---------|------|
| **新手入門** | 🐳 Sail | 專注學習 Laravel，不用煩惱環境設定 |
| **團隊開發** | 🐳 Sail | 環境一致，減少溝通成本 |
| **接案開發** | 🐳 Sail | 快速啟動多個不同版本專案 |
| **資深開發者** | 💻 本機 | 效能優先，熟悉環境配置 |
| **資源受限** | 💻 本機 | 記憶體/磁碟空間有限 |
| **生產部署** | 💻 本機架構 | 與伺服器環境一致 |

> 💡 **最佳實踐**：開發階段使用 **Sail** 快速迭代，生產環境使用傳統 **Laravel** 部署方式（如 Forge、Envoyer 或手動設定）。

---

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

#### 開發伺服器說明

本專案已預設配置以下開發工具，會在容器啟動時自動運行：

| 伺服器 | 埠口 | 用途 |
|--------|------|------|
| **Laravel** | 80 | 後端應用伺服器 |
| **Vite** | 5173 | 前端開發伺服器（Hot Module Replacement） |

- **Vite**：自動編譯 Vue/TypeScript，支援熱重載（修改代碼後瀏覽器自動刷新）

> 💡 如果前端頁面無法加載資源（CSS/JS），請確認 Vite 伺服器是否正在運行。查看容器日誌：
> ```bash
> docker compose logs laravel.test | grep vite
> ```

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

## 🔍 Docker 容器管理指南

### 查看容器資訊

#### 1. 查看所有運行中的容器
```bash
docker ps
```

#### 2. 查看所有容器（包含已停止的）
```bash
docker ps -a
```

#### 3. 查看特定容器詳細資訊
```bash
docker inspect <容器名稱或 ID>
```

---

### 🔍 查找容器執行目錄的方法

當你遇到 **Port 衝突** 或需要確認容器來源時，可以使用以下方法：

#### 方法 1：查看容器的掛載資訊（最常用）
```bash
# 查看容器的 Volume 掛載與路徑資訊
docker inspect <容器名稱> | grep -A 20 "Mounts"
```

**輸出範例：**
```json
"Mounts": [
    {
        "Type": "volume",
        "Name": "sail-mysql",
        "Source": "/var/lib/docker/volumes/sail-mysql/_data",
        "Destination": "/var/lib/mysql",
        ...
    }
]
```

#### 方法 2：查看容器的完整配置（最詳細）
```bash
# 輸出完整 JSON 配置，包含路徑、環境變數、網路等
docker inspect <容器名稱>
```

**實用篩選技巧：**
```bash
# 只查看工作目錄
docker inspect <容器名稱> --format='{{.Config.WorkingDir}}'

# 只查看掛載點（JSON 格式）
docker inspect <容器名稱> --format='{{json .Mounts}}' | jq

# 只查看容器啟動路徑
docker inspect <容器名稱> --format='{{.Path}}'
```

#### 方法 3：進入容器內部查看
```bash
# 進入容器並查看當前目錄
docker exec -it <容器名稱> pwd

# 列出容器內的文件
docker exec -it <容器名稱> ls -la
```

#### 方法 4：查看容器的專案來源
```bash
# 查看容器是從哪個 compose 專案啟動的
docker inspect <容器名稱> --format='{{index .Config.Labels "com.docker.compose.project"}}'
```

---

### 🧹 清理舊容器（解決 Port 衝突）

#### 情境：遇到 Port 已被佔用的錯誤

**步驟 1：找出佔用 Port 的容器**
```bash
# 查看所有容器，找到佔用特定 Port 的容器
docker ps -a

# 或搜尋特定名稱的容器
docker ps -a | grep phpmyadmin
```

**步驟 2：確認容器來源**
```bash
# 查看容器屬於哪個 compose 專案
docker inspect <容器名稱> --format='{{index .Config.Labels "com.docker.compose.project"}}'
```

**步驟 3：停止並移除舊容器**
```bash
# 停止單一容器
docker stop <容器名稱>

# 移除單一容器
docker rm <容器名稱>

# 一次停止並移除多個容器（按名稱過濾）
docker stop $(docker ps -aq --filter name=<關鍵字>)
docker rm $(docker ps -aq --filter name=<關鍵字>)
```

**步驟 4：清理整個舊專案的容器**
```bash
# 如果容器名稱有專案前綴（如 jubilant-platform）
docker stop $(docker ps -aq --filter name=jubilant-platform)
docker rm $(docker ps -aq --filter name=jubilant-platform)
```

---

### 📝 實戰案例：解決 Port 3307 衝突問題

#### 問題現象
執行 `docker compose up -d` 時出現錯誤：
```
Bind for 0.0.0.0:3307 failed: port is already allocated
! phpmyadmin: The requested image's platform (linux/amd64) does not match the detected host platform (linux/arm64/v8)
```

#### 問題分析
1. 執行 `docker ps` 查看運行中的容器
2. 發現舊容器 `jubilant-platform-phpmyadmin-1` 佔用了 port 3307
3. 該容器來自**其他已存在的專案**，不是目前專案的容器

#### 解決步驟

**步驟 1：確認舊容器資訊**
```bash
# 查看所有運行中的容器
docker ps

# 輸出範例：
# CONTAINER ID   IMAGE                   NAMES
# a5b9e3d7c527   phpmyadmin/phpmyadmin   jubilant-platform-phpmyadmin-1
```

**步驟 2：確認容器來源**
```bash
# 查看容器屬於哪個 compose 專案
docker inspect jubilant-platform-phpmyadmin-1 --format='{{index .Config.Labels "com.docker.compose.project"}}'
# 輸出：jubilant-platform（表示這是舊專案的容器）
```

**步驟 3：停止舊容器**
```bash
# 直接停止該容器
docker stop jubilant-platform-phpmyadmin-1
```

**步驟 4：移除舊容器**
```bash
# 移除容器（釋放 port）
docker rm jubilant-platform-phpmyadmin-1
```

**步驟 5：重新啟動目前專案**
```bash
# 回到目前專案目錄
cd /Users/liao-eli/github/Laravel_Sail

# 重新啟動
docker compose up -d
```

#### 💡 關鍵發現
- **容器名稱前綴** 代表它所屬的專案
  - `laravel_sail-phpmyadmin-1` → 屬於 `laravel_sail` 專案
  - `jubilant-platform-phpmyadmin-1` → 屬於 `jubilant-platform` 專案
- 當 `docker compose down` 無效時，代表容器是從**其他目錄**或**不同專案名稱**啟動的
- 最直接的方式：**使用 `docker stop` 和 `docker rm` 直接操作容器**

---

### 🎯 常見問題排除

#### Q1: Port 衝突錯誤
```
Bind for 0.0.0.0:3307 failed: port is already allocated
```

**解決方案：**
```bash
# 1. 找出佔用 port 的容器
docker ps -a | grep 3307

# 2. 查看該容器屬於哪個專案
docker inspect <容器名稱> --format='{{index .Config.Labels "com.docker.compose.project"}}'

# 3. 停止並移除舊容器
docker stop <容器名稱> && docker rm <容器名稱>

# 4. 重新啟動
docker compose up -d
```

#### Q2: 如何區分不同專案的容器？

查看容器名稱的前綴：
- `laravel_sail-phpmyadmin-1` → 屬於 `laravel_sail` 專案
- `jubilant-platform-phpmyadmin-1` → 屬於 `jubilant-platform` 專案

或使用指令：
```bash
# 列出所有容器及其所屬專案
docker ps -a --format "table {{.Names}}\t{{.Label \"com.docker.compose.project\"}}"
```

#### Q3: 如何徹底清理 Docker 資源？

```bash
# 警告：這會刪除所有停止的容器、未使用的網路和懸掛的映像檔
docker system prune

# 刪除所有未使用的 volume（包含資料庫資料！）
docker volume prune

# 刪除所有容器、映像檔、volume（核彈選項，請謹慎使用）
docker system prune -a --volumes
```

#### Q4: Laravel 容器無法啟動，錯誤訊息：`ENV_APP_COLOR`

**症狀：**
```
Error: Format string 'php artisan queue:work --queue=notifications_%(ENV_APP_COLOR)s'
contains names ('ENV_APP_COLOR') which cannot be expanded.
```

**原因：**
`.env` 中定義了 `APP_COLOR` 變數，但 `docker-compose.yaml` 沒有將其傳遞給容器，導致容器內的 Supervisor 配置無法找到此環境變數。

**解決方案：**

編輯 `docker-compose.yaml`，在 `laravel.test` 服務的 `environment` 段添加以下一行：

```yaml
services:
    laravel.test:
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
            DB_HOST: '${DB_HOST}'
            APP_COLOR: '${APP_COLOR}'  # ← 添加這一行
            XDEBUG_MODE: '${SAIL_XDEBUG_MODE:-off}'
            # ... 其他設定
```

然後重啟容器：
```bash
docker compose down && docker compose up -d
```

**為什麼需要這個設定？**
- Laravel 11+ 引入了 `APP_COLOR` 環境變數來控制命令列輸出顏色
- Supervisor（容器內的進程管理器）使用此變數配置隊列工作進程
- 如果 `.env` 有此設定，必須同時在 Docker Compose 中聲明，否則容器啟動時會失敗

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


  