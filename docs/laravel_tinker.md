- 進入 tinker
```bash!
./vendor/bin/sail artisan tinker

sail artisan tinker
```

---

- 異常執行 WithdrawTransactionService 或 DepositTransactionService
```bash!
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

- 正常執行 WithdrawTransactionService 或 DepositTransactionService
```bash!
// 1. 先用第一個使用者當作登入者 (通常是管理員)
auth()->login(App\Models\User\User::first());

// 2. 開啟 SQL 日誌
DB::enableQueryLog();

// 3. 執行查詢 (模擬只查狀態的情況)
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
- 正常執行 WithdrawTransactionService 或 DepositTransactionService
```

# 第 1 行:模擬使用者登入
```php
auth()->login(App\Models\User\User::first());
```

## 功能說明:

auth():取得 Laravel 的認證管理器 (Authentication Manager)
->login():手動將使用者登入系統,不需要驗證密碼
App\Models\User\User::first():從資料庫取得第一筆使用者記錄(通常是管理員帳號)
用途:在開發/測試環境中快速模擬已登入狀態,避免每次都要輸入帳號密

## 注意事項:

此方法會建立 Session 與 Cookie,與正常登入流程相同
適用於 Tinker、測試腳本或臨時除錯場景

# 第 2 行:啟用 SQL 查詢日誌
```php
DB::enableQueryLog();
```
## 功能說明:

DB 的資料庫門面 (Database Facade)
enableQueryLog():開啟 SQL 查詢記錄功能
作用:從此行之後執行的所有資料庫查詢都會被記錄到記憶體中

## 重要提醒:

查詢日誌會佔用記憶體,不應在正式環境啟用
```php
if (App::environment('local')) {
    DB::enableQueryLog();
}
```
# 第 3-5 行:執行業務查詢
```php
$request = ['trade_status' => ['Success']]; 
app(App\Services\WithdrawTransactionService::class)->list($request);
// 或是
app(App\Services\DepositTransactionService::class)->list($request);
```
## 功能說明:

$request:模擬 HTTP 請求參數,篩選交易狀態為「Success」的記錄
app() 的服務容器 (Service Container) 輔助函式,用於解析類別實例
WithdrawTransactionService / DepositTransactionService:提款/存款交易的業務邏輯服務類別
->list($request):呼叫服務的列表查詢方法

## 設計模式:

採用 Repository 設計模式,將資料庫操作封裝在服務層
透過依賴注入 (Dependency Injection) 取得服務實例

# 第 4 行:輸出 SQL 查詢記錄
```php
dump(DB::getQueryLog());
```
## 功能說明:

DB::getQueryLog():取得所有已記錄的 SQL 查詢陣列
dump() 的除錯函式,格式化輸出變數內容(不中斷程式執行)

## 輸出格式範例
```php
[
    [
        'query' => 'SELECT * FROM users WHERE trade_status = ?',
        'bindings' => ['Success'],
        'time' => 2.5  // 執行時間(毫秒)
    ]
]
```
## 替代方案:

使用 dd(DB::getQueryLog()):輸出後立即終止程式
使用 toSql():僅取得 SQL 語句(不含綁定參數與執行時間)

# 完整執行流程總結

1. 模擬登入:將第一個使用者設為當前認證使用者
2. 開啟監控:啟用 SQL 查詢日誌記錄
3. 執行業務:呼叫交易服務查詢「成功」狀態的記錄
4. 檢視結果:輸出所有執行的 SQL 語句、參數綁定與執行時間

# 典型應用場景:

- 除錯 N+1 查詢問題
- 驗證查詢條件是否正確
- 分析資料庫效能瓶頸
- 確認 ORM 產生的實際 SQL 語句

