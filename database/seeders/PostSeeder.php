<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'   => 'Laravel Sail 入門',
                'content' => 'Laravel Sail 是一個Docker開發環境，讓你快速啟動 Laravel 專案。',
                'status'  => 'published',
            ],
            [
                'title'   => 'Vue 3 與 Inertia 的結合',
                'content' => 'Inertia.js 讓你可以用 Vue 3 的方式開發 Laravel 後台，不需要另外寫 API。',
                'status'  => 'published',
            ],
            [
                'title'   => '待發布的文章',
                'content' => '這是一篇草稿状态的內容。',
                'status'  => 'draft',
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
