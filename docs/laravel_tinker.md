# Laravel Tinker 使用指南

Laravel Tinker 是一個 **REPL (Read-Eval-Print Loop)** 互動式命令行工具，讓開發者可以直接在終端機中與 Laravel 應用程式互動。對於除錯、測試和資料探索非常有用。

---

## 快速開始

### 進入 Tinker

在專案根目錄執行以下任一指令：

```bash
# 標準寫法 (推薦)
./vendor/bin/sail artisan tinker

# 簡寫 (如果 sail 已加入 PATH)
sail artisan tinker
```

啟動後會看到類似以下的提示字元：

```
Psy Shell v0.11.22 (PHP 8.2.0 — cli) by Justin Hileman
>>>
```

此時你已經進入 Laravel 應用程式環境，可以直接執行 PHP 程式碼！

### 離開 Tinker

```bash
>>> exit
```
或按鍵盤快捷鍵 `Ctrl + D`

---

## 實用範例：測試交易服務

### 情境一：異常執行 (簡化查詢)

用於快速測試服務在**最簡條件**下的行為，例如只篩選交易狀態。

```php
// 1. 先用第一個使用者當作登入者 (通常是管理員)
auth()->login(App\Models\User\User::first());

// 2. 開啟 SQL 日誌
DB::enableQueryLog();

// 3. 執行查詢 (模擬只查狀態的情況)
$request = ['trade_status' => ['Success']];
app(App\Services\WithdrawTransactionService::class)->list($request);
// 或是
app(App\Services\DepositTransactionService::class)->list($request);

// 4. 印出 SQL
dump(DB::getQueryLog());
```

---

### 情境二：正常執行 (完整查詢)

用於測試服務在**完整條件**下的行為，包含時間範圍和維度設定。

```php
// 1. 先用第一個使用者當作登入者 (通常是管理員)
auth()->login(App\Models\User\User::first());

// 2. 開啟 SQL 日誌
DB::enableQueryLog();

// 3. 執行查詢 (模擬完整查詢條件)
$request = [
    'trade_status' => ['Success'],
    'dimensions' => 'daily', // 可選: daily, monthly, yearly
    'created_at' => [
        'start' => '2024-03-20',
        'end'   => '2024-03-24'
    ]
];
app(App\Services\WithdrawTransactionService::class)->list($request);
// 或是
app(App\Services\DepositTransactionService::class)->list($request);

// 4. 印出 SQL
dump(DB::getQueryLog());
```

---

## 程式碼詳細解析

### 第 1 行：模擬使用者登入

```php
auth()->login(App\Models\User\User::first());
```

#### 功能說明

| 程式碼 | 說明 |
|--------|------|
| `auth()` | 取得 Laravel 的**認證管理器** (Authentication Manager) |
| `->login()` | 手動將使用者登入系統，**不需要驗證密碼** |
| `App\Models\User\User::first()` | 從資料庫取得**第一筆使用者記錄** (通常是管理員帳號) |

#### 用途

在開發/測試環境中**快速模擬已登入狀態**，避免每次都要輸入帳號密碼。

#### 注意事項

- ⚠️ 此方法會建立 **Session 與 Cookie**，與正常登入流程相同
- ✅ 適用於 Tinker、測試腳本或臨時除錯場景
- ⚠️ **不要**在正式環境使用此方式

#### 相關寫法

```php
// 指定 ID 登入
auth()->login(User::find(1));

// 使用 email 查詢後登入
auth()->login(User::where('email', 'admin@example.com')->first());

// 登出使用者
auth()->logout();

// 檢查是否已登入
auth()->check(); // true/false
auth()->id();    // 返回使用者 ID
```

---

### 第 2 行：啟用 SQL 查詢日誌

```php
DB::enableQueryLog();
```

#### 功能說明

| 程式碼 | 說明 |
|--------|------|
| `DB::` | Laravel 的**資料庫門面** (Database Facade) |
| `enableQueryLog()` | 開啟 **SQL 查詢記錄**功能 |

#### 作用

從此行之後執行的**所有資料庫查詢**都會被記錄到記憶體中，包含：
- SQL 語句
- 參數綁定
- 執行時間

#### 重要提醒

⚠️ **查詢日誌會佔用記憶體，不應在正式環境啟用**

建議加上環境判斷：

```php
if (App::environment('local')) {
    DB::enableQueryLog();
}
```

#### 相關方法

```php
DB::enableQueryLog();     // 啟用日誌
DB::getQueryLog();        // 取得日誌內容
DB::disableQueryLog();    // 停用日誌 (釋放記憶體)
```

---

### 第 3-5 行：執行業務查詢

```php
$request = ['trade_status' => ['Success']];
app(App\Services\WithdrawTransactionService::class)->list($request);
// 或是
app(App\Services\DepositTransactionService::class)->list($request);
```

#### 功能說明

| 程式碼 | 說明 |
|--------|------|
| `$request` | 模擬 **HTTP 請求參數**，篩選交易狀態為「Success」的記錄 |
| `app()` | Laravel 的**服務容器** (Service Container) 輔助函式 |
| `WithdrawTransactionService` | **提款交易**的業務邏輯服務類別 |
| `DepositTransactionService` | **存款交易**的業務邏輯服務類別 |
| `->list($request)` | 呼叫服務的**列表查詢方法** |

#### 設計模式

- ✅ 採用 **Service 層設計模式**，將業務邏輯封裝在服務類別中
- ✅ 透過 **依賴注入** (Dependency Injection) 取得服務實例
- ✅ 保持 Controller 乾淨，符合 **單一職責原則**

#### 參數說明

**簡化查詢** (情境一)：
```php
$request = [
    'trade_status' => ['Success']  // 只篩選成功的交易
];
```

**完整查詢** (情境二)：
```php
$request = [
    'trade_status' => ['Success'],  // 交易狀態篩選
    'dimensions' => 'daily',        // 時間維度：daily, monthly, yearly
    'created_at' => [               // 時間範圍
        'start' => '2024-03-20',
        'end'   => '2024-03-24'
    ]
];
```

#### 相關寫法

```php
// 直接從容器解析服務 (推薦)
$service = app(WithdrawTransactionService::class);
$service->list($request);

// 使用 app() 輔助函式 (簡潔)
app(WithdrawTransactionService::class)->list($request);

// 在 Controller 中使用建構式注入 (最佳實踐)
class TransactionController extends Controller
{
    public function __construct(
        private WithdrawTransactionService $service
    ) {}
    
    public function index(Request $request)
    {
        return $this->service->list($request->all());
    }
}
```

---

### 第 6 行：輸出 SQL 查詢記錄

```php
dump(DB::getQueryLog());
```

#### 功能說明

| 程式碼 | 說明 |
|--------|------|
| `DB::getQueryLog()` | 取得所有已記錄的 **SQL 查詢陣列** |
| `dump()` | Laravel 的**除錯函式**，格式化輸出變數內容 (**不中斷程式**) |

#### 輸出格式範例

```php
[
    0 => [
        'query' => 'SELECT * FROM `withdraw_transactions` WHERE `trade_status` IN (?)',
        'bindings' => ['Success'],
        'time' => 2.5  // 執行時間 (毫秒)
    ],
    1 => [
        'query' => 'SELECT COUNT(*) as aggregate FROM `withdraw_transactions` ...',
        'bindings' => ['Success', '2024-03-20', '2024-03-24'],
        'time' => 1.8
    ]
]
```

#### 替代方案

| 函式 | 說明 |
|------|------|
| `dump(DB::getQueryLog())` | 輸出日誌，**繼續執行**程式 |
| `dd(DB::getQueryLog())` | 輸出日誌，**立即終止**程式 (dump and die) |
| `DB::listen()` | 即時監聽每個查詢 (進階用法) |

#### 進階用法：格式化輸出

```php
// 使用 collect() 美化輸出
collect(DB::getQueryLog())->each(function($query) {
    dump([
        'SQL' => $query['query'],
        '參數' => $query['bindings'],
        '時間' => $query['time'] . ' ms'
    ]);
});

// 只查看執行時間超過 100ms 的查詢
$slowQueries = collect(DB::getQueryLog())
    ->filter(fn($q) => $q['time'] > 100);
dump($slowQueries);
```

---

## 完整執行流程總結

```
┌─────────────────────────────────────────────────────────┐
│  1. 模擬登入：將第一個使用者設為當前認證使用者           │
│     auth()->login(User::first())                        │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│  2. 開啟監控：啟用 SQL 查詢日誌記錄                       │
│     DB::enableQueryLog()                                │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│  3. 執行業務：呼叫交易服務查詢「成功」狀態的記錄         │
│     app(WithdrawTransactionService::class)->list()      │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│  4. 檢視結果：輸出所有執行的 SQL 語句、參數綁定與執行時間 │
│     dump(DB::getQueryLog())                             │
└─────────────────────────────────────────────────────────┘
```

---

## 典型應用場景

### 1. 除錯 N+1 查詢問題

```php
DB::enableQueryLog();

// 執行會產生 N+1 問題的程式碼
User::all()->each(fn($user) => $user->posts->count());

// 檢查產生了多少個 SQL
dump(count(DB::getQueryLog())); // 如果 > 2，可能有 N+1 問題
```

### 2. 驗證查詢條件是否正確

```php
// 測試複雜的 where 條件
$request = ['status' => 'active', 'role' => 'admin'];
User::where($request)->get();

// 查看實際產生的 SQL
dump(DB::getQueryLog());
```

### 3. 分析資料庫效能瓶頸

```php
DB::enableQueryLog();

// 執行效能敏感的操作
// ...

// 找出執行時間最長的查詢
$slowest = collect(DB::getQueryLog())
    ->sortByDesc('time')
    ->first();
    
dump($slowest);
```

### 4. 確認 ORM 產生的實際 SQL 語句

```php
// Eloquent 會產生什麼 SQL？
User::with('posts')
    ->where('status', 'active')
    ->orderBy('created_at', 'desc')
    ->get();

dump(DB::getQueryLog());
```

---

## 更多 Tinker 實用技巧

### 快速測試 Eloquent

```php
>>> User::count()
>>> User::latest()->take(5)->get()
>>> User::where('email', 'like', '%@gmail.com')->count()
```

### 測試資料庫關聯

```php
>>> $user = User::find(1)
>>> $user->posts()->create(['title' => 'Test', 'content' => 'Content'])
>>> $user->posts()->count()
```

### 使用 Facade

```php
>>> Cache::put('test', 'value', 3600)
>>> Cache::get('test')
>>> DB::table('users')->count()
```

### 快速計算

```php
>>> now()->format('Y-m-d H:i:s')
>>> config('app.name')
>>> app()->environment() // 返回 'local', 'production' 等
```

---

## 常見問題 (FAQ)

### Q1: 為什麼 `auth()->login()` 沒有作用？

**A:** Tinker 每次輸入都是獨立的請求上下文。如果需要在多次輸入間保持登入狀態，請在同一個 Tinker 工作階段中操作。

### Q2: 如何查看更詳細的錯誤訊息？

**A:** 使用 `dd()` 或 `dump()` 輸出異常物件：

```php
try {
    // 你的程式碼
} catch (\Exception $e) {
    dd([
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
```

### Q3: Tinker 的修改會影響資料庫嗎？

**A:** **會！** Tinker 直接操作生產資料庫，所有 `save()`, `create()`, `delete()` 都會永久寫入。請謹慎操作！

### Q4: 如何在 Tinker 中使用自己的類別？

**A:** 需要先 `use` 導入命名空間：

```php
>>> use App\Models\User;
>>> use App\Services\WithdrawTransactionService;
>>> User::count()
```

---

## 參考資源

- [Laravel 官方文件 - Tinker](https://laravel.com/docs/artisan#tinker)
- [Laravel 官方文件 - 資料庫](https://laravel.com/docs/database)
- [PsySH 官方文件](https://psysh.org/)
