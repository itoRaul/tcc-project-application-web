<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="filter-modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm" @click="emit('close')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
        <div class="flex items-start justify-between border-b border-slate-200 px-6 py-5">
          <div class="flex gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M6 12h12M10 19h4" />
              </svg>
            </span>
            <div>
              <h2 id="filter-modal-title" class="text-lg font-bold text-slate-950">Filtrar dispositivos</h2>
              <p class="mt-1 text-sm text-slate-500">Refine a lista por ID, tipo ou estado.</p>
            </div>
          </div>
          <button
            type="button"
            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            aria-label="Fechar filtros"
            @click="emit('close')"
          >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="applyFilters">
          <div class="space-y-5 px-6 py-6">
            <div>
              <label for="filter-query" class="mb-2 block text-sm font-semibold text-slate-700">Buscar por ID</label>
              <div class="relative">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="11" cy="11" r="7" />
                  <path stroke-linecap="round" d="m20 20-4-4" />
                </svg>
                <input
                  id="filter-query"
                  v-model="draft.query"
                  type="search"
                  placeholder="ID do dispositivo"
                  class="block h-11 w-full rounded-xl border-slate-300 pl-10 pr-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
                >
              </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
              <div>
                <label for="filter-type" class="mb-2 block text-sm font-semibold text-slate-700">Tipo</label>
                <select
                  id="filter-type"
                  v-model="draft.type"
                  class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >
                  <option value="">Todos os tipos</option>
                  <option v-for="type in deviceTypes" :key="type" :value="type">{{ type }}</option>
                </select>
              </div>
              <div>
                <label for="filter-status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                <select
                  id="filter-status"
                  v-model="draft.status"
                  class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >
                  <option value="">Todos os status</option>
                  <option value="active">Ativo</option>
                  <option value="inactive">Inativo</option>
                  <option value="maintenance">Em manutenção</option>
                </select>
              </div>
            </div>
          </div>

          <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-between">
            <button type="button" class="h-10 px-1 text-sm font-semibold text-slate-600 transition hover:text-slate-900" @click="resetDraft">
              Limpar seleção
            </button>
            <div class="flex flex-col-reverse gap-3 sm:flex-row">
              <button type="button" class="h-10 rounded-xl border border-slate-300 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" @click="emit('close')">
                Cancelar
              </button>
              <button type="submit" class="h-10 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Aplicar filtros
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    deviceTypes: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['close', 'apply'])

const emptyFilters = () => ({
    query: '',
    type: '',
    status: '',
})

const draft = ref(emptyFilters())

watch(
    () => props.show,
    (show) => {
        if (show) {
            draft.value = { ...emptyFilters(), ...props.filters }
        }
    },
    { immediate: true },
)

const resetDraft = () => {
    draft.value = emptyFilters()
}

const applyFilters = () => {
    emit('apply', { ...draft.value })
}
</script>
