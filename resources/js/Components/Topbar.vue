<template>
  <header class="h-16 bg-white/80 backdrop-blur-lg border-b border-gray-100 flex items-center justify-between px-6 sticky top-0 z-10 shadow-sm transition-all">
    
    <div class="flex items-center">
      <button class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <h1 class="text-xl font-semibold text-gray-800 ml-4 md:ml-0 tracking-tight hidden sm:block">
        {{ title }}
      </h1>
    </div>

    <div class="flex items-center space-x-4">      
      <div class="flex items-center space-x-3 p-1 pr-3 rounded-full hover:bg-stone-50 border border-transparent hover:border-emerald-200 transition-all cursor-default">
        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-500 to-lime-400 shadow-inner flex items-center justify-center text-white font-bold text-sm">
          {{ userInitial }}
        </div>
        <span class="text-sm font-medium text-stone-700 hidden md:block">{{ userLogin }}</span>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  }
})

const page = usePage()
const user = computed(() => page.props.auth?.user)
const userLogin = computed(() => user.value?.login || 'Usuário')
const userInitial = computed(() => user.value?.login ? user.value.login.charAt(0).toUpperCase() : 'U')
</script>

<style scoped>
@keyframes wiggle {
  0%, 100% { transform: rotate(-3deg); }
  50% { transform: rotate(3deg); }
}
.animate-wiggle {
  animation: wiggle 0.3s ease-in-out infinite;
}
</style>
