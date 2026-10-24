<template>
  <aside 
    class="bg-gradient-to-b from-stone-900 to-emerald-950 text-white min-h-screen hidden md:flex flex-col shadow-2xl flex-shrink-0 transition-all duration-300 relative z-20"
    :class="isCollapsed ? 'w-20' : 'w-64'"
  >
    <div 
      class="h-16 flex items-center border-b border-white/10 transition-all duration-300"
      :class="isCollapsed ? 'justify-center px-2' : 'justify-between px-4'"
    >
      <div v-show="!isCollapsed" class="flex items-center space-x-2.5 overflow-hidden">
        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-500/30 shadow-sm">
          VA
        </div>
        <span class="text-xl font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-lime-400 select-none whitespace-nowrap">
          VisiAgro
        </span>
      </div>

      <button
        @click="toggleSidebar"
        type="button"
        :title="isCollapsed ? 'Expandir menu' : 'Encolher menu'"
        :aria-label="isCollapsed ? 'Expandir menu' : 'Encolher menu'"
        class="p-2 rounded-xl text-stone-400 hover:text-white hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 flex items-center justify-center group"
        :class="isCollapsed ? 'bg-white/5 border border-white/10 text-emerald-400 hover:border-emerald-500/40' : ''"
      >
        <svg 
          class="w-5 h-5 transition-transform duration-300"
          :class="isCollapsed ? 'rotate-180 text-emerald-400 group-hover:scale-110' : 'group-hover:-translate-x-0.5'"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
        </svg>
      </button>
    </div>

    <nav class="flex-1 py-8 px-3 space-y-2 overflow-y-auto overflow-x-hidden">
      <a 
        href="/dashboard"
        :title="isCollapsed ? 'Dashboard' : ''"
        class="flex items-center py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
        :class="[
          isActive('/dashboard') ? 'bg-white/15 shadow-lg border border-white/10' : '',
          isCollapsed ? 'justify-center px-0' : 'px-4'
        ]"
      >
        <svg 
          class="w-5 h-5 text-emerald-400 group-hover:scale-110 transition-transform shrink-0"
          :class="isCollapsed ? '' : 'mr-3'"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span 
          v-show="!isCollapsed" 
          class="font-medium text-stone-200 group-hover:text-white transition-colors truncate whitespace-nowrap"
        >
          Dashboard
        </span>
      </a>

      <a 
        href="/dispositivos"
        :title="isCollapsed ? 'Dispositivos' : ''"
        class="flex items-center py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
        :class="[
          isActive('/dispositivos') ? 'bg-white/15 shadow-lg border border-white/10' : '',
          isCollapsed ? 'justify-center px-0' : 'px-4'
        ]"
      >
        <svg 
          class="w-5 h-5 text-lime-400 group-hover:scale-110 transition-transform shrink-0"
          :class="isCollapsed ? '' : 'mr-3'"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z"/>
        </svg>
        <span 
          v-show="!isCollapsed" 
          class="font-medium text-stone-200 group-hover:text-white transition-colors truncate whitespace-nowrap"
        >
          Dispositivos
        </span>
      </a>

      <a 
        href="/leituras"
        :title="isCollapsed ? 'Leituras' : ''"
        class="flex items-center py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
        :class="[
          isActive('/leituras') ? 'bg-white/15 shadow-lg border border-white/10' : '',
          isCollapsed ? 'justify-center px-0' : 'px-4'
        ]"
      >
        <svg 
          class="w-5 h-5 text-teal-400 group-hover:scale-110 transition-transform shrink-0"
          :class="isCollapsed ? '' : 'mr-3'"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span 
          v-show="!isCollapsed" 
          class="font-medium text-stone-200 group-hover:text-white transition-colors truncate whitespace-nowrap"
        >
          Leituras
        </span>
      </a>

      <a 
        href="#"
        :title="isCollapsed ? 'Usuários' : ''"
        class="flex items-center py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
        :class="isCollapsed ? 'justify-center px-0' : 'px-4'"
      >
        <svg 
          class="w-5 h-5 text-teal-400 group-hover:scale-110 transition-transform shrink-0"
          :class="isCollapsed ? '' : 'mr-3'"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span 
          v-show="!isCollapsed" 
          class="font-medium text-stone-200 group-hover:text-white transition-colors truncate whitespace-nowrap"
        >
          Usuários
        </span>
      </a>

    </nav>
    
    <div 
      class="py-6 border-t border-white/10 transition-all duration-300"
      :class="isCollapsed ? 'px-2' : 'px-4'"
    >
      <form @submit.prevent="logout">
        <button 
          type="submit" 
          :title="isCollapsed ? 'Sair' : ''"
          class="w-full flex items-center py-3 rounded-xl transition-all duration-300 group hover:bg-orange-500/20 text-orange-400 hover:text-orange-300"
          :class="isCollapsed ? 'justify-center px-0' : 'px-4'"
        >
          <svg 
            class="w-5 h-5 group-hover:-translate-x-1 transition-transform shrink-0"
            :class="isCollapsed ? '' : 'mr-3'"
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          <span 
            v-show="!isCollapsed" 
            class="font-medium truncate whitespace-nowrap"
          >
            Sair
          </span>
        </button>
      </form>
    </div>
  </aside>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const isCollapsed = ref(
  typeof window !== 'undefined' && localStorage.getItem('sidebar_collapsed') === 'true'
)

const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
  if (typeof window !== 'undefined') {
    localStorage.setItem('sidebar_collapsed', isCollapsed.value ? 'true' : 'false')
  }
}

const isActive = (path) => {
  return typeof window !== 'undefined' && window.location.pathname === path
}

const logout = () => {
  router.post('/logout')
}
</script>
