# Inertia Page Props 配置指南

本文件記錄如何在 Laravel Inertia 專案中配置全域共享資料 (Page Props)，使後端資料能自動注入到所有 Vue 頁面組件（如使用者資訊、Flash Messages 等）。

## 簡介：什麼是 Inertia Page Props？

在傳統單頁應用 (SPA) 中，若想在每一個頁面都取得某些全域資料（例如：當前登入者資訊、未讀通知數、網站設定），我們通常需要專門寫一個 API endpoint，然後在前端啟動時去呼叫它。

Inertia 透過 **Page Props (Shared Data)** 機制解決了這個痛點：

1.  **自動注入**：你可以將資料定義在後端 Middleware。
2.  **隨傳隨到**：這些資料會隨著每一次頁面請求（包含初次載入與後續換頁）自動傳遞給前端。
3.  **無需額外 API**：你不需要為了拿這些基本資料多發送一次 HTTP 請求。

**簡單來說，它就像是傳統 Blade 模板中的 `View::share()`，但是專門給 Vue 組件使用的。**

## 安裝與初始化 (Installation)

本專案使用 Laravel Breeze 進行 Inertia + Vue 堆疊的快速建置。

### 1. 執行安裝指令

在 Sail 環境中執行以下指令以安裝 Inertia 與 Vue 相關依賴：

```bash
./vendor/bin/sail php artisan breeze:install vue
```

> 💡 **這步做了什麼？**
> 此指令會自動安裝後端依賴 `inertiajs/inertia-laravel`，並建立核心 Middleware `HandleInertiaRequests`，這正是我們定義 Page Props 的關鍵檔案。

系統會詢問以下選項，請依照專案規範選擇：
- **Dark mode support?** (Yes/No)
- **TypeScript or JavaScript?** (建議 TypeScript)
- **PHPUnit or Pest?** (建議 Pest)

### 2. 解決依賴衝突 (Troubleshooting)

若安裝過程中遇到 `npm error code ERESOLVE` 錯誤，通常是因為 Vite 7 與 `vite-plugin-vue` 版本不相容導致。

**解決方案：**

1. 修改 `package.json`，手動鎖定 Vite 版本：
   ```json
   "devDependencies": {
       "laravel-vite-plugin": "^1.0.0",
       "vite": "^6.0.0",
       // ...其他依賴
   }
   ```
2. 清除暫存並重新安裝：
   ```bash
   rm -rf node_modules package-lock.json
   ./vendor/bin/sail npm install
   ```

   ./vendor/bin/sail npm install
   ```

### 3. 理解檔案變動 (Why so many changes?)

Breeze 不僅是安裝 Inertia，它還是一個 **Starter Kit (啟動套件)**，會自動產生一套完整的使用者認證系統 (Authentication)。這就是為什麼你會看到大量新檔案的原因：

- **後端 (PHP)**:
  - `app/Http/Controllers/Auth/*`: 處理登入、註冊、重設密碼的邏輯。
  - `app/Http/Middleware/HandleInertiaRequests.php`: **(關鍵)** 定義 Page Props 共享資料。
  - `routes/auth.php`: 定義與認證相關的路由。

- **前端 (Vue)**:
  - `resources/js/Pages/Auth/*`: 登入、註冊等 Vue 頁面。
  - `resources/js/Components/*`: 可重用的 UI 元件 (如按鈕、輸入框)。
  - `resources/js/Layouts/*`: 提供一致的頁面佈局。

### 4. 編譯前端資源

安裝完成後，啟動 Vite 開發伺服器：

```bash
./vendor/bin/sail npm run dev
```

## 核心概念

Inertia 的 [Shared Data](https://inertiajs.com/shared-data) 機制允許我們在 Middleware 層定義全域資料。這些資料會透過每一次的 Inertia Response 自動傳遞給前端，前端可以使用 `usePage` hook 輕鬆存取。

> **❓ 常見問題：Inertia Page Props 需要登入系統嗎？**
>
> **不需要。** Shared Data 只是全域資料傳遞機制，與認證無關。
> 我們之所以安裝 Breeze (包含認證系統)，是因為它能**快速自動化配置** Inertia 所需的繁瑣基礎環境 (Middleware, Root View, Vite Config 等)。這讓我們能直接開始開發，而不用從零手動建立基礎設施。

## 配置步驟

### 1. 定義 Middleware

主要配置檔案位於：`app/Http/Middleware/HandleInertiaRequests.php`

### 2. 新增共享資料

在 `share` 方法中回傳鍵值對陣列。建議使用 `fn () => ...` 閉包來延遲執行（Lazy Evaluation），避免在不需要該資料的請求中造成效能浪費。

```php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    // ...

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // 1. 使用者認證資訊
            'auth' => [
                'user' => $request->user(),
            ],

            // 2. Flash Messages (用於操作回饋)
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],

            // 3. 應用程式全域設定
            'app' => [
                'name' => config('app.name'),
            ],
        ];
    }
}
```

## 前端調用方式 (Vue 3)

在 Vue 組件中，使用 `@inertiajs/vue3` 提供的 `usePage` 來獲取這些資料。

```vue
<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

// 存取使用者資訊
const user = computed(() => page.props.auth.user);

// 存取 Flash Message
const successMessage = computed(() => page.props.flash.success);
</script>

<template>
    <div v-if="successMessage" class="alert alert-success">
        {{ successMessage }}
    </div>
    
    <div v-if="user">
        歡迎回來, {{ user.name }}
    </div>
</template>
```

## 常見應用場景

- **Auth User**: 當前登入使用者的基本資料。
- **Flash Messages**: 來自 `with('success', ...)` 的跳轉訊息。
- **Errors**: 表單驗證錯誤（Inertia 預設已處理 `errors` prop，無需手動添加）。
- **Global Config**: 如應用程式名稱、語言設定等。
