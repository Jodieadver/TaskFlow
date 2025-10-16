<script setup>
import { useForm } from '@inertiajs/vue3'
const form = useForm({ email: '' })
const props = defineProps({
    project: { type: Object, required: true },
    users: { type: Object, required: true },
})
// const submit = () => form.post(route('projects.invitations.store', project.id))

const submit = () => form.post(`/dashboard/${props.project.id}/memberInProject`)

import Navbar from '../components/Navbar.vue';






// const member = [
//   {
//     name: 'Leslie Alexander',
//     email: 'leslie.alexander@example.com',
//     imageUrl:
//       'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//     href: '#',
//   },
//   {
//     name: 'Michael Foster',
//     email: 'michael.foster@example.com',
//     imageUrl:
//       'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//     href: '#',
//   },
//   {
//     name: 'Dries Vincent',
//     email: 'dries.vincent@example.com',
//     imageUrl:
//       'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//     href: '#',
//   },
//   {
//     name: 'Lindsay Walton',
//     email: 'lindsay.walton@example.com',
//     imageUrl:
//       'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//     href: '#',
//   },
//   {
//     name: 'Courtney Henry',
//     email: 'courtney.henry@example.com',
//     imageUrl:
//       'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//     href: '#',
//   },
//   {
//     name: 'Tom Cook',
//     email: 'tom.cook@example.com',
//     imageUrl:
//       'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//     href: '#',
//   },
// ]


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
            <div class="grid grid-cols-[3fr_1fr] mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Members in「{{ project.title }}」</h1>
                <h1 class="text-xl tracking-tight text-gray-400">{{ project.description }}</h1>
                <!-- <h1 class="text-xl tracking-tight text-gray-400">{{ props }}</h1> -->
            
                
                </div>
                <!-- <h1 class="text-xl tracking-tight text-gray-400">{{ props }}</h1> -->
                 <!-- <button type="button" class="rounded-full bg-white px-3.5 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50">Button text</button> -->
                 
            </div>      
        </header>

    </div>



     <!-- // =======================
    // Member Lists 
    // =======================
     -->

<main>
        <div class="mx-auto max-w-3xl px-4 pb-8 sm:px-6 lg:px-8">
<div>
    <ul role="list" class="divide-y divide-gray-100 dark:divide-white/5">
        
      <li v-for="person in props.users" :key="email" class="flex items-center justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
          <img class="size-12 flex-none rounded-full bg-gray-50 dark:bg-gray-800 dark:outline dark:-outline-offset-1 dark:outline-white/10" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
          
          <div class="min-w-0 flex-auto">
            
            <p class="text-sm/6 font-semibold text-gray-500 dark:text-white">{{ person.name }}</p>
            <p class="mt-1 truncate text-xs/5 text-gray-500 dark:text-gray-400">{{ person.email }}</p>
          </div>
        </div>
        <a href="#" class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">Delete</a>
      </li>
    </ul>


    <div>
        <form @submit.prevent="submit" class="flex gap-2">
    <input v-model.trim="form.email" type="email" placeholder="user@example.com" class="input" required>
    <select v-model="form.role" class="input">
      <option value="">Member</option>
      <option value="admin">Admin</option>
    </select>
    <button :disabled="form.processing" class="mr-auto rounded-md bg-[#3566a9] border border-gray-300 text-white hover:bg-red-700 py-2 px-4 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">Invite</button>
  </form>
  <p v-if="form.errors.email" class="text-red-600 text-sm">{{ form.errors.email }}</p>
    </div>




    <!-- <a href="#" class="flex w-full items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">View all</a> -->
  </div>


   </div>
    </main>









</template>
