<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../components/Navbar.vue';

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

import { usePage } from '@inertiajs/vue3'
const page = usePage()
const user = (page.props as any).auth?.user
const errors = (usePage().props as any).errors || {}

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
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Create a Project</h1>
                <h1 v-if="user" class="text-3xl font-bold tracking-tight text-gray-900">{{ user.id }}</h1>
            </div>

        </header>
    </div>
    <!-- 
    =======================
    Project Form 
    ======================= -->

    <main>

        <div class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">

            <form method="POST" action="/dashboard/create" enctype="multipart/form-data"
                class="border rounded-md p-12 space-y-8 ">
                <input type="hidden" name="_token" :value="$page.props.csrf_token">

                <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                    <div class="space-y-6 sm:xspace-y-5">
                        <!-- <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Project Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Use a permanent address where you can receive mail.</p>
                        </div> -->
                        <div class="space-y-6 sm:space-y-5">

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="project-title"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Project Title
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" name="title" id="project-title" 
                                        class="p-3 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                                <label for="project-description"
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Description
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="project-description" name="description" rows="3"
                                        class="p-3 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    <p class="mt-2 text-sm text-gray-500 "> Brief description for your project. URLs are
                                        hyperlinked. </p>
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
                                    <input datepicker datepicker-format="yyyy-mm-dd" datepicker-autohide name="due_date" id="due-date"
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Select date">
                                </div>
                                <p v-if="errors.due_date" class="mt-2 text-sm text-red-600">{{ errors.due_date }}</p>



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
                                                    <input id="file-upload" name="picture" type="file"
                                                        class="sr-only" />
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
                        <button type="button"
                            class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                            Cancel </button>
                        <button type="submit"
                            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                            Save </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

</template>