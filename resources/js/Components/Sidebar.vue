<template>
  <aside 
    class="bg-gradient-to-b from-stone-900 to-emerald-950 text-white w-64 min-h-screen hidden md:flex flex-col shadow-2xl flex-shrink-0 transition-all duration-300 relative z-20"
  >
    <div class="h-16 flex items-center justify-center border-b border-white/10 px-6">
      <span class="text-xl font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-lime-400">
        SYS.AGRO
      </span>
    </div>

    <nav class="flex-1 py-8 px-4 space-y-2 overflow-y-auto">
      <a 
        href="/dashboard"
        class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
        :class="{'bg-white/15 shadow-lg border border-white/10': isActive('/dashboard')}"
      >
        <svg class="w-5 h-5 mr-3 text-emerald-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="font-medium text-stone-200 group-hover:text-white transition-colors">Dashboard</span>
      </a>

      <a 
        href="#"
        class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
      >
        <svg class="w-5 h-5 mr-3 text-lime-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z"/>
        </svg>
        <span class="font-medium text-stone-200 group-hover:text-white transition-colors">Dispositivos</span>
      </a>

      <a 
        href="#"
        class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-white/10"
      >
        <svg class="w-5 h-5 mr-3 text-teal-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span class="font-medium text-stone-200 group-hover:text-white transition-colors">Usuários</span>
      </a>

    </nav>
    
    <div class="px-4 py-6 border-t border-white/10">
      <form @submit.prevent="logout">
        <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-orange-500/20 text-orange-400 hover:text-orange-300">
           <svg class="w-5 h-5 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
           </svg>
           <span class="font-medium">Sair</span>
        </button>
      </form>
    </div>
  </aside>
</template>

<script setup>
const isActive = (path) => {
  return window.location.pathname === path;
}

const logout = () => {

}
</script>
