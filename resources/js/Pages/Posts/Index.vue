<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';

const props = defineProps({
    posts: Object,
});

const form = useForm({});

const destroy = (id) => {
    if (confirm('確定要刪除這篇文章嗎？')) {
        form.delete(route('posts.destroy', id));
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="文章管理" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold">文章列表</h2>
                            <Link
                                :href="route('posts.create')"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                            >
                                新建文章
                            </Link>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">標題</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">狀態</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">建立時間</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">操作</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="post in posts" :key="post.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ post.id }}</td>
                                    <td class="px-6 py-4">{{ post.title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            :class="post.status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'"
                                            class="px-2 py-1 text-xs rounded-full"
                                        >
                                            {{ post.status === 'published' ? '已發布' : '草稿' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ post.created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <Link
                                            :href="route('posts.edit', post.id)"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3"
                                        >
                                            編輯
                                        </Link>
                                        <button
                                            @click="destroy(post.id)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        >
                                            刪除
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="posts.length === 0">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        尚無文章
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>