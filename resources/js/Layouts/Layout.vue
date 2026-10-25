<template>
  <div class="flex h-screen bg-gray-50 font-sans text-gray-900 overflow-hidden">
    
    <Sidebar />

    <div class="flex-1 flex flex-col w-full h-full relative overflow-y-auto overflow-x-hidden">
      
      <Topbar :title="pageTitle" />

      <main class="flex-1 p-6 md:p-8 flex flex-col gap-6">
        <slot />
      </main>

    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Topbar from '@/Components/Topbar.vue'

const props = defineProps({
  title: String
})

// Optional title parsing
const pageTitle = computed(() => props.title || 'App')
</script>
