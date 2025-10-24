<script setup>
import { useForm } from '@inertiajs/vue3'
const form = useForm({ email: '', role: '' })
const props = defineProps({
  project: { type: Object, required: true },
  users: { type: Object, required: true },
})


const submit = () => {
  const url = `/dashboard/${props.project.id}/memberInProject`
  console.log('submit clicked', url, form.data())
  form.post(`/dashboard/${props.project.id}/memberInProject`, {
    onError: (e) => console.error('errors:', e),
    onSuccess: () => form.reset('email')
  }
  )

}

import Navbar from '../components/Navbar.vue';



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
          <!-- <h1 class="text-xl tracking-tight text-gray-400">{{ users }}</h1> -->

        </div>

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

          <li v-for="person in props.users" class="flex items-center justify-between gap-x-6 py-5">
            <div class="flex min-w-0 gap-x-4">
              <img
                class="size-12 flex-none rounded-full bg-gray-50 dark:bg-gray-800 dark:outline dark:-outline-offset-1 dark:outline-white/10"
                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="" />

              <div class="min-w-0 flex-auto">

                <p class="text-sm/6 font-semibold text-gray-500 dark:text-white">{{ person.name }}</p>
                <p class="mt-1 truncate text-xs/5 text-gray-500 dark:text-gray-400">{{ person.email }}</p>
              </div>
            </div>
            <a href="#"
              class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20">Delete</a>
          </li>
        </ul>


        <div>
          <form @submit.prevent="submit" class="flex gap-2">
            <input v-model.trim="form.email" type="email" placeholder="user@example.com" class="input" required>
            <select v-model="form.role" class="input">
              <option value="member">Member</option>
              <option value="admin">Admin</option>
            </select>
            <button :disabled="form.processing"
              class="mr-auto rounded-md bg-[#3566a9] border border-gray-300 text-white hover:bg-red-700 py-2 px-4 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">Invite</button>
          </form>
          <p v-if="form.errors.email" class="text-red-600 text-sm">{{ form.errors.email }}</p>
        </div>


      </div>


    </div>
  </main>









</template>
