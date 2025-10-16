
<script setup lang="ts">
import { reactive, watch, toRefs, ref } from 'vue'
import Navbar from '../components/Navbar.vue';

import { usePage } from '@inertiajs/vue3'
const errors = (usePage().props as any).errors || {}

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

/**
 * Props:
 * - model: 现有任务（可选）
 * - users: 下拉可选的用户列表 [{ id, name }]
 */
const props = defineProps({
  project: {
    type: Object,
    default: () => ({})
  },
  users: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['save'])

const defaults = {
  title: '',
  description: '',
  assignee_id: '',
  due_date: '',
  status: 'in_progress'
}

// const form = reactive({ ...defaults, ...props })
// const users = toRefs(props).users
const submitting = ref(false)

// watch(
//   () => props.model,
//   (val) => Object.assign(form, { ...defaults, ...val }),
//   { deep: true }
// )

</script>






<template>
    <Navbar />

  <div class="p-10">
    <div class="mx-auto max-w-7xl pt-4 px-4 sm:px-6 lg:px-8 rounded-2xl border border-gray-200 bg-white shadow-sm">
      <!-- Header -->
      <div class="border-b border-gray-200 px-6 py-5">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900"> Project「{{ props.project.title }}」- Task Details</h1>
        <p class="mt-1 text-sm text-gray-500">View and edit the details of this task.</p>
        <p class="mt-1 text-sm text-gray-500">{{ props }}</p>
        <div v-if="$page.props.errors?.title" class="text-sm text-red-600">
  {{ $page.props.errors.title }}
</div>

      </div>

      <!-- Body -->
      <form method="POST" :action="`/dashboard/${project.id}/tasks/create`" enctype="multipart/form-data" class="px-6 py-6 space-y-6">
        <input type="hidden" name="_token" :value="$page.props.csrf_token">
        <!-- Title -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Task Title</label>
          <input name="title"
            type="text"
            placeholder="Redesign the main dashboard"
            class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-[15px] leading-6
                   placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
            required
          />
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description"
            rows="4"
            placeholder="Update the dashboard with new widgets and a more modern layout..."
            class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-[15px] leading-6
                   placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
          ></textarea>
        </div>

        <!-- Assignee -->
        <div> 
          <label class="block text-sm font-medium text-gray-700">Assignee</label>
          <div class="relative max-w-sm">
            <select name="user_id"
              class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 pr-10 text-[15px]
                     focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >
              <option value="" disabled>Select a user</option>
              <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }}</option>
            </select>
            <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">▾</span>
          </div>
        </div>

        <!-- Due Date (Flowbite datepicker 版本) -->
        <div class="relative max-w-sm">
          <label for="due-date" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>

          <div class="relative max-w-sm">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
              />
            </svg>
          </div>

          <input datepicker datepicker-format="yyyy-mm-dd" datepicker-autohide name="due_date" id="due-date"
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Select date">



            </div>
          <p v-if="errors.due_date" class="mt-2 text-sm text-red-600">{{ errors.due_date }}</p>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Status</label>
          <div class="relative max-w-sm">
            <select name="status"
              class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 pr-10 text-[15px]
                     focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >
              <option value="to_do">To Do</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Done</option>
            </select>
            <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">▾</span>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end">
          <button
            type="submit"
            :disabled="submitting"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white
                   hover:bg-blue-700 disabled:opacity-60 disabled:cursor-not-allowed"
          >
            <svg v-if="submitting" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
            </svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
  
</template>
