<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../components/Navbar.vue';

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'


import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
const errors = (usePage().props as any).errors || {}

import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import { update } from '@/routes/profile';
dayjs.extend(relativeTime)
const fromNow = (d) => (d ? dayjs(d).fromNow() : '')
const onlyDate = (s?: string | null) => (s ? s.slice(0, 10) : '')

const props = defineProps({
    tasks: { type: Array, default: () => [] },
    project: { type: Object, required: true },
    users: { type: Array, default: () => [] },
})


const STATUS_META = [
    { id: 'to_do', label: 'To Do' },
    { id: 'in_progress', label: 'In Progress' },
    { id: 'completed', label: 'Done' },
]

const columns = computed(() =>
    STATUS_META.map(col => {
        const tasks = props.tasks
            .filter(t => (t.status ?? 'to_do') === col.id)
            .map(t => ({
                id: t.id,
                title: t.title,
                due_date: t.due_date,
                description: t.description,
                updated_at: onlyDate(t.updated_at),
                assignee: props.users.find(u => u.id === t.user_id)?.name || 'Unassigned',
            }))


        return { id: col.id, label: col.label, tasks }
    })
)
</script>


<template>
    <Navbar />

    <!--    
    // =======================
    // Page Header 
    // =======================
    // -->
    <div class="py-10">
        <header>
            <div class="grid grid-cols-[8fr_1fr] mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ project.title }}</h1>
                <h1 class="text-xl tracking-tight text-gray-400">{{ project.description }}</h1>
                </div>
                <!-- <h1 class="text-xl tracking-tight text-gray-400">{{ props }}</h1> -->
                 <!-- <button type="button" class="rounded-full bg-white px-3.5 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50">Button text</button> -->
                  <a :href="`/dashboard/${project.id}/edit`" class="card-button mx-auto p-2 text-center">🔧 Edit Project</a>
            </div>


            
        </header>
    </div>




    <!-- // =======================
    // Page Tasks 
    // =======================
     -->

    <main>
        <div class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">

            <div class="grid grid-cols-3 gap-6">
                <div v-for="column in columns" :key="column.id" class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">{{ column.label }}</h2>

                    <div v-for="task in column.tasks" :key="task.id" class="bg-white p-3 rounded-md shadow-sm mb-3">
                        <h3 class="font-medium">{{ task.title }}</h3>
                        <p class="text-sm text-gray-500">{{ task.assignee }}</p>
                        <span class="text-xs text-gray-400">Updated at {{ task.updated_at }}</span>
                    </div>

                    <a :href="`/dashboard/${project.id}/tasks/create`" class="card-button text-blue-600 text-sm mt-2 ">+ Add task</a>
                </div>
            </div>

        </div>
    </main>



</template>
