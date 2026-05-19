<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';

const props = defineProps({
    post: Object,
});

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    status: props.post.status,
});

const submit = () => {
    form.put(route('posts.update', props.post.id), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="編輯文章" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">標題</label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                    :class="{ 'border-red-500': form.errors.title }"
                                />
                                <span v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</span>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">內容</label>
                                <textarea
                                    v-model="form.content"
                                    rows="8"
                                    class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                    :class="{ 'border-red-500': form.errors.content }"
                                ></textarea>
                                <span v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</span>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2">狀態</label>
                                <select
                                    v-model="form.status"
                                    class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                >
                                    <option value="draft">草稿</option>
                                    <option value="published">發布</option>
                                </select>
                            </div>

                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-50"
                                >
                                    更新文章
                                </button>
                                <Link
                                    :href="route('posts.index')"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500"
                                >
                                    取消
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>