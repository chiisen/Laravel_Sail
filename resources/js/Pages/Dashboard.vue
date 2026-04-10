<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const kpiCards = [
    { title: '本月營收', value: 'NT$ 2,480,000', delta: '+12.4%', trend: 'up' },
    { title: '新註冊用戶', value: '1,284', delta: '+8.1%', trend: 'up' },
    { title: '訂單完成率', value: '96.2%', delta: '+1.3%', trend: 'up' },
    { title: '客服工單', value: '42', delta: '-9.6%', trend: 'down' },
];

const revenueTrend = [
    { month: '1 月', value: 140 },
    { month: '2 月', value: 165 },
    { month: '3 月', value: 158 },
    { month: '4 月', value: 182 },
    { month: '5 月', value: 201 },
    { month: '6 月', value: 228 },
];

const trafficSources = [
    { source: '自然搜尋', ratio: 36, color: 'bg-blue-500' },
    { source: '廣告投放', ratio: 28, color: 'bg-emerald-500' },
    { source: '社群導流', ratio: 21, color: 'bg-amber-500' },
    { source: '直接流量', ratio: 15, color: 'bg-violet-500' },
];

const teamProgress = [
    { task: '新版結帳流程', owner: 'Web Team', progress: 82 },
    { task: '會員分級方案', owner: 'Growth Team', progress: 68 },
    { task: '客服自動化整合', owner: 'Ops Team', progress: 54 },
    { task: '數據中台串接', owner: 'Data Team', progress: 41 },
];

const maxRevenue = Math.max(...revenueTrend.map(item => item.value));
</script>

<template>
    <Head :title="$t('Dashboard')" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                {{ $t('Dashboard') }}
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <p class="text-sm text-gray-500">
                        DEMO 報表總覽 (展示用途)
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article
                        v-for="card in kpiCards"
                        :key="card.title"
                        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
                    >
                        <p class="text-sm text-gray-500">{{ card.title }}</p>
                        <p class="mt-2 text-2xl font-semibold text-gray-900">{{ card.value }}</p>
                        <p
                            class="mt-2 text-sm font-medium"
                            :class="card.trend === 'up' ? 'text-emerald-600' : 'text-rose-600'"
                        >
                            {{ card.delta }}
                        </p>
                    </article>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
                    <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm xl:col-span-2">
                        <h3 class="text-base font-semibold text-gray-900">營收趨勢 DEMO</h3>
                        <p class="mt-1 text-sm text-gray-500">近六個月指標 (單位：十萬)</p>
                        <div class="mt-6 space-y-4">
                            <div
                                v-for="row in revenueTrend"
                                :key="row.month"
                                class="flex items-center gap-4"
                            >
                                <div class="w-12 text-sm text-gray-500">{{ row.month }}</div>
                                <div class="h-5 flex-1 rounded-full bg-gray-100">
                                    <div
                                        class="h-5 rounded-full bg-gradient-to-r from-sky-500 to-indigo-500"
                                        :style="{ width: `${Math.round((row.value / maxRevenue) * 100)}%` }"
                                    />
                                </div>
                                <div class="w-12 text-right text-sm font-medium text-gray-700">{{ row.value }}</div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-semibold text-gray-900">流量來源 DEMO</h3>
                        <div class="mt-4 space-y-3">
                            <div
                                v-for="item in trafficSources"
                                :key="item.source"
                            >
                                <div class="mb-1 flex items-center justify-between text-sm text-gray-600">
                                    <span>{{ item.source }}</span>
                                    <span>{{ item.ratio }}%</span>
                                </div>
                                <div class="h-2 rounded-full bg-gray-100">
                                    <div
                                        class="h-2 rounded-full"
                                        :class="item.color"
                                        :style="{ width: `${item.ratio}%` }"
                                    />
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900">專案進度 DEMO</h3>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-sm text-gray-500">
                                    <th class="px-2 py-2">項目</th>
                                    <th class="px-2 py-2">負責團隊</th>
                                    <th class="px-2 py-2">完成度</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                <tr
                                    v-for="row in teamProgress"
                                    :key="row.task"
                                >
                                    <td class="px-2 py-3">{{ row.task }}</td>
                                    <td class="px-2 py-3">{{ row.owner }}</td>
                                    <td class="px-2 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="h-2 w-28 rounded-full bg-gray-100">
                                                <div
                                                    class="h-2 rounded-full bg-emerald-500"
                                                    :style="{ width: `${row.progress}%` }"
                                                />
                                            </div>
                                            <span>{{ row.progress }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
