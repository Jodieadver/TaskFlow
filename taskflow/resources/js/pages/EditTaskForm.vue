<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../components/Navbar.vue';

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const user = (page.props as any).auth?.user
const errors = (usePage().props as any).errors || {}

const props = defineProps({
    project: { type: Object, default: () => ({}) },
    users: { type: Object, default: () => ({}) },
    task: { type: Object, default: () => ({}) }
})


const destroytask = () => {
    if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
        router.delete(`/dashboard/${props.project.id}/tasks/${props.task.id}`, { preserveScroll: true })
    }
}


</script>

<template>
    <Navbar />

    <!--    
    =======================
    Page Header 
    =======================
    -->
    <div class="py-10">
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit task</h1>
                <!-- <h1 v-if="user" class="text-3xl font-bold tracking-tight text-gray-900">{{ user.id }}</h1> -->
                <div v-if="$page.props.errors.title" class="text-red-500">
                    {{ $page.props.errors.title }}
                </div>

            </div>

        </header>
    </div>
    <!-- 
    =======================
    task Form 
    ======================= -->

    <main>

        <div class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">

            <form method="POST" :action="`/dashboard/${project.id}/tasks/${task.id}`" enctype="multipart/form-data"
                class="border rounded-md p-12 space-y-8 ">
                <input type="hidden" name="_token" :value="$page.props.csrf_token">
                <input type="hidden" name="_method" value="PUT">

                <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                    <div class="space-y-6 sm:xspace-y-5">
                        <div class="space-y-6 sm:space-y-5">

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="task-title"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> task Title
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input :value="task.title" type="text" name="title" id="task-title"
                                        class="p-3 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm" />

                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="task-description"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Description
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea :value="task.description" id="task-description" name="description"
                                        rows="3"
                                        class="p-3 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    <p class="mt-2 text-sm text-gray-500 "> Brief description for your task. URLs are
                                        hyperlinked. </p>
                                </div>
                            </div>



                            <!-- Assignee -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="task-description"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Assignee
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <select v-model="user.id" name="user_id" class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 pr-10 text-[15px]
                                        focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                        <option value="" disabled>Select a user</option>
                                        <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }}</option>
                                    </select>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">▾</span>
                                </div>
                            </div>








                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="due-date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Due Date </label>


                                <div class="relative max-w-sm">

                                    <div
                                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input :value="task.due_date" datepicker datepicker-format="yyyy-mm-dd"
                                        datepicker-autohide name="due_date" id="due-date" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Select date">
                                </div>
                                <p v-if="errors.due_date" class="mt-2 text-sm text-red-600">{{ errors.due_date }}</p>



                            </div>






                            <!-- Status -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="task-description"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Status
                                </label>
                                <div class="relative max-w-sm">
                                    <select v-model="task.status" name="status" class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 pr-10 text-[15px]
                     focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                        <option value="to_do">To Do</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Done</option>
                                    </select>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">▾</span>
                                </div>
                            </div>





                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="file-upload"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Cover Picture
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div
                                        class="flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m0 0v8a4 4 0 01-4 4h-4" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="file-upload"
                                                    class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2">
                                                    <span>Upload a file</span>
                                                    <input :value="task.picture" id="file-upload" name="picture"
                                                        type="file" class="sr-only" />
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500"> PNG, JPG, GIF up to 10MB </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5">


                    <div class="flex justify-end">
                        <!-- <a :href="`/dashboard/${task.id}`" class="mr-auto rounded-md border border-gray-300 bg-red-500 text-white hover:bg-red-700 py-2 px-4 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600"> Delete </a> -->
                        <button type="button" @click="destroytask"
                            class="mr-auto rounded-md border border-gray-300 bg-red-500 text-white hover:bg-red-700 py-2 px-4 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                            Delete </button>
                        <a :href="`/dashboard/${project.id}`"
                            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                            Cancel </a>

                        <button type="submit"
                            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                            Save </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

</template>