<script setup lang="ts">

import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const user = (page.props as any).auth?.user


dayjs.extend(relativeTime)
const fromNow = (d) => (d ? dayjs(d).fromNow() : '')

const props = defineProps({
  projects: Array, default: () => []
})

import Navbar from '../components/Navbar.vue'

</script>


<template>
  <Navbar />

  <div class="py-10">
    <header>
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Projects</h1>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{projects}}</h1>
        <!-- <h1 v-if="user" class="text-3xl font-bold tracking-tight text-gray-900">{{ user.id }}</h1> -->

      </div>

    </header>


    <main>
      <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <div v-if="projects.length === 0" class="text-center">
          <!-- <svg class="mx-auto size-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
          </svg> -->
          <h3 class="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
          <p class="mt-1 mb-6 text-sm text-gray-500">Get started by creating a new project.</p>
          <!-- <div class="mt-6"></div> -->
        </div>


        <div v-else>
          <div v-for="project in projects" class="mb-4 p-4 border rounded card">
            <div class="card-image">
              <img v-if="project.image" :src="project.image" alt="Project image" class="w-full h-full object-cover" />
            </div>

            <div class="card-content">
              <div class="font-semibold">{{ project.title ?? 'Untitled Project' }}</div>
              <div class="text-sm text-grey-500 mt-2">{{ project.description ?? 'Untitled Description' }}
              </div>
              <div class="text-sm mt-2">{{ fromNow(project.created_at) }}</div>
              <a :href="`/dashboard/${project.id}`" class="card-button">Details</a>

            </div>

          </div>

        </div>


        <!-- <button type="button"
          class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
          <svg class="mx-auto size-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
            aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
          </svg>
          <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Project</span>
        </button> -->

        <a
  href="/dashboard/create" 
  class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600"
>
  <svg class="mx-auto size-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
  </svg>
  <span class="mt-2 block text-sm font-semibold text-gray-900">Create a new Project</span>
</a>


      </div>
    </main>
  </div>

</template>
