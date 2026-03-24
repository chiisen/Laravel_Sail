# 開發常見操作指南 (Development Guide)

本文件說明在 Laravel Sail + Inertia.js (Vue 3) 架構下，如何新增常見的功能模組（如 Controller, Middleware, Model 等），以及對應的檔案位置與操作方式。

所有指令請在專案根目錄執行，並務必加上 `./vendor/bin/sail` 前綴。

## 1. 新增控制器 (Controller)
建立後端邏輯的核心，通常負責接收請求並回傳 Inertia 頁面或 JSON 資料。

*   **指令**:
    ```bash
    ./vendor/bin/sail artisan make:controller PostController
    ```
*   **檔案位置**: `app/Http/Controllers/PostController.php`
*   **寫法範例**:
    ```php
    namespace App\Http\Controllers;

    use Inertia\Inertia;
    use Illuminate\Http\Request;

    class PostController extends Controller
    {
        public function index()
        {
            // 回傳 resources/js/Pages/Posts/Index.vue 頁面
            return Inertia::render('Posts/Index', [
                'title' => '文章列表',
            ]);
        }
    }
    ```
*   **路由註冊 (`routes/web.php`)**:
    ```php
    use App\Http\Controllers\PostController;

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    ```

---

## 2. 新增中介層 (Middleware)
用於過濾 HTTP 請求，例如檢查使用者權限、紀錄 Log 等。

*   **指令**:
    ```bash
    ./vendor/bin/sail artisan make:middleware CheckIsAdmin
    ```
*   **檔案位置**: `app/Http/Middleware/CheckIsAdmin.php`
*   **寫法範例**:
    ```php
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->is_admin) {
            abort(403, '你沒有權限訪問此頁面');
        }
    
        return $next($request);
    }
    ```
*   **註冊方式 (Laravel 11)**:
    開啟 `bootstrap/app.php`，在 `withMiddleware` 閉包中加入：
    ```php
    ->withMiddleware(function (Middleware $middleware) {
        // 註冊别名 (Alias) 以便在路由中使用
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckIsAdmin::class,
        ]);
    })
    ```
*   **路由使用 (`routes/web.php`)**:
    ```php
    Route::middleware(['auth', 'admin'])->group(function () {
        // ... 需要管理員權限的路由
    });
    ```

---

## 3. 新增模型與遷移檔 (Model & Migration)
用於定義資料結構與資料庫操作。建議同時建立 Model 與 Migration。

*   **指令**:
    ```bash
    ./vendor/bin/sail artisan make:model Post -m
    ```
*   **檔案位置**:
    *   Model: `app/Models/Post.php`
    *   Migration: `database/migrations/xxxx_xx_xx_xxxxxx_create_posts_table.php`
*   **寫法範例 (Migration)**:
    ```php
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained(); // 關聯 User
            $table->timestamps();
        });
    }
    ```
*   **執行遷移**:
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

---

## 4. 新增表單請求驗證 (Form Request)
用於驗證使用者提交的資料，保持 Controller 乾淨。

*   **指令**:
    ```bash
    ./vendor/bin/sail artisan make:request StorePostRequest
    ```
*   **檔案位置**: `app/Http/Requests/StorePostRequest.php`
*   **寫法範例**:
    ```php
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }
    ```
*   **Controller 使用**:
    ```php
    use App\Http\Requests\StorePostRequest;

    public function store(StorePostRequest $request)
    {
        // 只有驗證通過才會執行到這裡
        Post::create($request->validated());
    }
    ```

---

## 5. 新增前端頁面 (Inertia Page)
對應後端 Controller 回傳的視圖。

*   **操作**: 手動在 `resources/js/Pages/` 目錄下建立 `.vue` 檔案。
*   **檔案位置**: 例如 `resources/js/Pages/Posts/Index.vue`
*   **寫法範例**:
    ```vue
    <script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';

    // 接收 Controller 傳來的 Props
    defineProps({
        title: String,
    });
    </script>

    <template>
        <Head :title="title" />
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">{{ title }}</div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
    ```

---

## 6. Laravel Tinker (REPL 互動式除錯工具)

### 功能說明
**Tinker** 是 Laravel 內建的 **REPL (Read-Eval-Print Loop)** 互動式命令行工具，允許開發者在命令行環境中直接與 Laravel 應用程式互動，包括：
- 操作 Eloquent 模型與資料庫
- 測試 Job、Event、Facade 等 Laravel 元件
- 快速執行 PHP 程式碼片段
- 除錯與資料探索

### 啟動方式
在專案根目錄執行：
```bash
./vendor/bin/sail artisan tinker
```

啟動後會進入 `psysh` 互動式環境，提示字為 `>>>`。

### 使用範例

#### 1. 查詢資料庫記錄
```bash
>>> use App\Models\User;
>>> User::all();
>>> User::find(1);
>>> User::where('email', 'like', '%@example.com')->get();
```

#### 2. 建立/更新/刪除資料
```bash
>>> User::create(['name' => 'Test', 'email' => 'test@example.com', 'password' => bcrypt('password')]);
>>> $user = User::find(1);
>>> $user->name = 'Updated Name';
>>> $user->save();
>>> $user->delete();
```

#### 3. 測試 Eloquent 關聯
```bash
>>> $user = User::with('posts')->find(1);
>>> $user->posts;
>>> $post = $user->posts()->create(['title' => 'New Post', 'content' => 'Content']);
```

#### 4. 使用 Facade
```bash
>>> use Illuminate\Support\Facades\DB;
>>> DB::table('users')->count();
>>> DB::select('SELECT * FROM users WHERE id = ?', [1]);

>>> use Illuminate\Support\Facades\Cache;
>>> Cache::put('key', 'value', 3600);
>>> Cache::get('key');
```

#### 5. 觸發 Event 或 Dispatch Job
```bash
>>> use App\Events\PostCreated;
>>> use App\Models\Post;
>>> $post = Post::find(1);
>>> event(new PostCreated($post));

>>> use App\Jobs\SendEmail;
>>> dispatch(new SendEmail($user));
```

#### 6. 快速計算與測試
```bash
>>> 2 + 2
>>> config('app.name')
>>> app()->environment()
>>> now()->format('Y-m-d H:i:s')
```

### 離開 Tinker
輸入 `exit` 或按 `Ctrl + D` 離開互動式環境。

### 注意事項
- Tinker 的變更會**直接影響資料庫**，請謹慎操作
- 在生產環境中建議限制 Tinker 的使用權限
- 可使用 `php artisan tinker --execute="code"` 執行單行命令後立即退出
