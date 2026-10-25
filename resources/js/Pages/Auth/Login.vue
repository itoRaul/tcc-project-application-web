<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    login: '',
    password: '',
})

const submit = () => {
    form.post('/login')
}

</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-96">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>
      <form @submit.prevent="submit" class="space-y-4">
          <div>
              <label for="login" class="block text-sm font-medium text-gray-700">Login</label>
              <input id="login" type="text" v-model="form.login" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
          </div>
          <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
              <input id="password" type="password" v-model="form.password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
          </div>
          <button type="submit" :disabled="form.processing" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Entrar</button>
      </form>
    </div>
  </div>
</template>