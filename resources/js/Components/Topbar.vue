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
      
      <!-- Weather & Date -->
      <div class="hidden md:flex items-center bg-stone-50/80 backdrop-blur-sm border border-stone-200/60 px-3 py-1.5 rounded-full shadow-sm text-sm">
        
        <!-- Date -->
        <div class="flex items-center text-stone-500 font-medium" title="Data atual">
          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <span class="capitalize">{{ currentDate }}</span>
        </div>

        <div class="w-px h-4 bg-stone-300 mx-3"></div>

        <div class="flex items-center text-orange-500 font-semibold" title="Temperatura">
          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v13m0 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0-13a2 2 0 0 0-2 2v10c0 .4-.2.8-.5 1.1A4 4 0 0 0 8 19a4 4 0 0 0 8 0 4 4 0 0 0-1.5-3.1c-.3-.3-.5-.7-.5-1.1V5a2 2 0 0 0-2-2z"/>
          </svg>
          <span>{{ temperature }}°C</span>
        </div>
        
        <div class="w-px h-4 bg-stone-300 mx-3"></div>

        <div class="flex items-center text-sky-500 font-semibold" title="Umidade">
          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c0 0-6 7.5-6 12a6 6 0 1 0 12 0c0-4.5-6-12-6-12z"/>
          </svg>
          <span>{{ humidity }}%</span>
        </div>
      </div>

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
  },
  temperature: {
    type: [Number, String],
    default: 24.5
  },
  humidity: {
    type: [Number, String],
    default: 60
  }
})

const page = usePage()
const user = computed(() => page.props.auth?.user)
const userLogin = computed(() => user.value?.login || 'Usuário')
const userInitial = computed(() => user.value?.login ? user.value.login.charAt(0).toUpperCase() : 'U')

const currentDate = new Date().toLocaleDateString('pt-BR', { 
  day: '2-digit', 
  month: 'short', 
  year: 'numeric' 
});
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
