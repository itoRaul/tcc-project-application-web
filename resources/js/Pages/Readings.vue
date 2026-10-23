<template>
  <Layout title="Leituras">
    <div class="min-h-full bg-slate-50/80">
      <div class="w-full px-2 py-4 sm:px-4 sm:py-5 lg:px-5 lg:py-6">
        
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <div class="border-l-4 border-emerald-600 px-5 py-6 sm:px-7">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
              <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Leituras de Telemetria</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                  Histórico diário de capturas e telemetria. Cada página exibe as transmissões de um único dia, da mais recente à mais antiga.
                </p>
              </div>

              <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative w-full sm:w-72">
                  <input
                    v-model="searchQuery"
                    type="text" 
                    placeholder="Buscar por ID, dispositivo ou MAC..."
                    class="h-11 w-full rounded-xl border border-slate-300 bg-white pl-10 pr-9 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                  />
                  <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                  </span>
                  <button
                    v-if="searchQuery"
                    type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-slate-600"
                    title="Limpar busca"
                    aria-label="Limpar busca"
                    @click="searchQuery = ''"
                  >
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>

                <select
                  v-model="infestationFilter"
                  class="h-11 rounded-xl border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                >
                  <option value="">Todas as infestações</option>
                  <option value="zero">Sem detecção (0 bicudos)</option>
                  <option value="moderate">Atenção (1 a 9 bicudos)</option>
                  <option value="critical">Crítica (≥ 10 bicudos)</option>
                </select>

                <select
                  v-model="batteryFilter"
                  class="h-11 rounded-xl border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                >
                  <option value="">Qualquer nível de bateria</option>
                  <option value="low">Bateria baixa (≤ 20%)</option>
                  <option value="medium">Bateria média (21% - 50%)</option>
                  <option value="good">Bateria boa (> 50%)</option>
                </select>
              </div>
            </div>
          </div>

          <div class="grid border-t border-slate-200 sm:grid-cols-4">
            <div class="flex items-center gap-4 px-5 py-4 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.25 2.25L15 7.5" />
                </svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total de Leituras</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ readings.length }}</p>
              </div>
            </div>

            <div class="flex items-center gap-4 border-t border-slate-200 px-5 py-4 sm:border-l sm:border-t-0 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                </svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Dias Registrados</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ availableDays.length }}</p>
              </div>
            </div>

            <div class="flex items-center gap-4 border-t border-slate-200 px-5 py-4 sm:border-l sm:border-t-0 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Bicudos no Dia</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ currentDay?.weevils ?? 0 }}</p>
              </div>
            </div>

            <div class="flex items-center gap-4 border-t border-slate-200 px-5 py-4 sm:border-l sm:border-t-0 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="2" y="7" width="16" height="10" rx="2" />
                  <path stroke-linecap="round" d="M22 11v2" />
                </svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Bateria Baixa (≤ 20%)</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ lowBatteryCount }}</p>
              </div>
            </div>
          </div>
        </section>

        <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          
          <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <h2 class="font-bold text-slate-900">Histórico de Transmissões</h2>
            <div class="flex flex-wrap items-center gap-2 self-start sm:self-auto">
              <div v-if="availableDays.length > 1" class="inline-flex items-center rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                <button
                  type="button"
                  class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-transparent"
                  :disabled="currentPage === 1"
                  title="Dia mais recente"
                  aria-label="Dia mais recente"
                  @click="goToPage(currentPage - 1)"
                >
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                  </svg>
                </button>

                <select
                  :value="currentPage"
                  class="h-8 cursor-pointer border-0 bg-transparent py-0 pl-2 pr-7 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-0"
                  aria-label="Selecionar data"
                  @change="goToPage(Number($event.target.value))"
                >
                  <option v-for="(day, idx) in availableDays" :key="day.key" :value="idx + 1">
                    {{ day.labelShort }} ({{ day.count }})
                  </option>
                </select>

                <button
                  type="button"
                  class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-transparent"
                  :disabled="currentPage === totalPages"
                  title="Dia anterior (mais antigo)"
                  aria-label="Dia anterior"
                  @click="goToPage(currentPage + 1)"
                >
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                  </svg>
                </button>
              </div>

              <button
                v-if="hasActiveFilters"
                type="button"
                class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-emerald-600 shadow-sm transition hover:bg-emerald-50 hover:text-emerald-800"
                @click="clearFilters"
              >
                Limpar filtros
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" d="m7 7 10 10M17 7 7 17" />
                </svg>
              </button>
            </div>
          </div>

          <template v-if="paginatedReadings.length">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                  <tr>
                    <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">ID</th>
                    <th scope="col" class="py-3.5 pl-5 pr-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 sm:pl-6">Dispositivo / Origem</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Bicudos (Pragas)</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Bateria</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Sinal (RSSI)</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Horário</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                  <tr v-for="reading in paginatedReadings" :key="reading.id" class="transition-colors hover:bg-emerald-50/40">
                    <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-slate-600">
                      #{{ reading.id }}
                    </td>

                    <td class="whitespace-nowrap py-4 pl-5 pr-3 sm:pl-6">
                      <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="4" y="4" width="16" height="16" rx="3" />
                            <path stroke-linecap="round" d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 15h3M1 9h3M1 15h3" />
                          </svg>
                        </span>
                        <div>
                          <p class="text-sm font-semibold text-slate-900">
                            {{ reading.device ? reading.device.name : `Dispositivo #${reading.device_id}` }}
                          </p>
                          <p class="text-xs font-mono text-slate-500">
                            {{ reading.device?.mac_address || `ID: ${reading.device_id}` }}
                          </p>
                        </div>
                      </div>
                    </td>

                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <span
                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset"
                        :class="weevilBadgeClasses(reading.weevil_count)"
                      >
                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                        {{ formatWeevilText(reading.weevil_count) }}
                      </span>
                    </td>

                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <div class="flex items-center gap-2.5">
                        <span
                          class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset"
                          :class="batteryBadgeClasses(reading.battery_level)"
                        >
                          <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="16" height="10" rx="2" />
                            <path stroke-linecap="round" d="M22 11v2" />
                          </svg>
                          {{ formatBattery(reading.battery_level) }}
                        </span>
                      </div>
                    </td>

                    <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                      <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                        </svg>
                        <span>{{ reading.rssi !== null && reading.rssi !== undefined ? `${reading.rssi} dBm` : '-' }}</span>
                      </div>
                    </td>

                    <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                      <div class="flex flex-col">
                        <span class="font-medium text-slate-800">{{ formatTime(reading.read_at || reading.created_at) }}</span>
                        <span class="text-xs text-slate-400">{{ formatDateOnly(reading.read_at || reading.created_at) }}</span>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <nav
              v-if="totalPages > 1"
              class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 px-5 py-4 sm:flex-row sm:px-6"
              aria-label="Paginação por Dia"
            >
              <p class="text-sm text-slate-500">
                Mostrando leituras de <span class="font-semibold text-slate-700">{{ currentDay?.labelShort }}</span>
                (Página <span class="font-semibold text-slate-700">{{ currentPage }}</span> de <span class="font-semibold text-slate-700">{{ totalPages }} dias</span> •
                <span class="font-semibold text-slate-700">{{ paginatedReadings.length }}</span> {{ paginatedReadings.length === 1 ? 'leitura' : 'leituras' }})
              </p>

              <div class="flex flex-wrap items-center justify-center gap-1.5">
                <button
                  type="button"
                  class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 px-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40"
                  :disabled="currentPage === 1"
                  aria-label="Dia mais recente"
                  @click="goToPage(currentPage - 1)"
                >
                  <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                  </svg>
                  <span>Mais recente</span>
                </button>

                <template v-for="(item, index) in visiblePageItems" :key="index">
                  <span v-if="item === '...'" class="inline-flex h-9 w-6 items-center justify-center text-sm text-slate-400">…</span>
                  <button
                    v-else
                    type="button"
                    class="inline-flex h-9 items-center justify-center rounded-lg px-2.5 text-xs font-semibold transition"
                    :class="item.page === currentPage ? 'bg-emerald-600 text-white shadow-sm' : 'border border-slate-200 text-slate-700 hover:bg-slate-100'"
                    :aria-current="item.page === currentPage ? 'page' : undefined"
                    @click="goToPage(item.page)"
                  >
                    {{ item.label }}
                  </button>
                </template>

                <button
                  type="button"
                  class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 px-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40"
                  :disabled="currentPage === totalPages"
                  aria-label="Dia anterior"
                  @click="goToPage(currentPage + 1)"
                >
                  <span>Mais antigo</span>
                  <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                  </svg>
                </button>
              </div>
            </nav>
          </template>

          <div v-else class="px-6 py-16 text-center">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
              <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.25 2.25L15 7.5" />
              </svg>
            </span>
            <h3 class="mt-4 font-bold text-slate-900">
              {{ readings.length === 0 ? 'Nenhuma leitura registrada ainda' : 'Nenhuma leitura encontrada para os filtros aplicados' }}
            </h3>
            <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-slate-500">
              {{ readings.length === 0 
                ? 'Assim que os nós sensores transmitirem telemetria, as leituras aparecerão agrupadas por dia.' 
                : 'Tente alterar os termos da busca ou redefinir os filtros aplicados.' 
              }}
            </p>
            <button
              v-if="hasActiveFilters"
              type="button"
              class="mt-5 text-sm font-semibold text-emerald-600 hover:text-emerald-800"
              @click="clearFilters"
            >
              Limpar todos os filtros
            </button>
          </div>
        </section>

      </div>
    </div>
  </Layout>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import Layout from '@/Layouts/Layout.vue'

const props = defineProps({
  readings: {
    type: Array,
    default: () => [],
  },
})

const searchQuery = ref('')
const infestationFilter = ref('')
const batteryFilter = ref('')

const hasActiveFilters = computed(() => {
  return searchQuery.value.trim() !== '' || infestationFilter.value !== '' || batteryFilter.value !== ''
})

const clearFilters = () => {
  searchQuery.value = ''
  infestationFilter.value = ''
  batteryFilter.value = ''
}

const normalize = (val) => String(val ?? '').toLowerCase()

const filteredReadings = computed(() => {
  const query = normalize(searchQuery.value).trim()

  return (props.readings || []).filter((reading) => {
    const deviceName = reading.device ? reading.device.name : ''
    const macAddress = reading.device ? reading.device.mac_address : ''
    
    const matchesQuery = !query || 
      normalize(reading.id).includes(query) ||
      normalize(reading.device_id).includes(query) ||
      normalize(deviceName).includes(query) ||
      normalize(macAddress).includes(query)

    let matchesInfestation = true
    const count = Number(reading.weevil_count ?? 0)
    if (infestationFilter.value === 'zero') {
      matchesInfestation = count === 0
    } else if (infestationFilter.value === 'moderate') {
      matchesInfestation = count >= 1 && count < 10
    } else if (infestationFilter.value === 'critical') {
      matchesInfestation = count >= 10
    }

    let matchesBattery = true
    const battery = Number(reading.battery_level ?? 0)
    if (batteryFilter.value === 'low') {
      matchesBattery = battery <= 20
    } else if (batteryFilter.value === 'medium') {
      matchesBattery = battery > 20 && battery <= 50
    } else if (batteryFilter.value === 'good') {
      matchesBattery = battery > 50
    }

    return matchesQuery && matchesInfestation && matchesBattery
  })
})

const getDateKey = (dateStr) => {
  if (!dateStr) return 'sem-data'
  const match = String(dateStr).match(/^(\d{4})-(\d{2})-(\d{2})/)
  if (match) {
    return `${match[1]}-${match[2]}-${match[3]}`
  }
  try {
    const d = new Date(dateStr)
    if (!isNaN(d.getTime())) {
      const year = d.getFullYear()
      const month = String(d.getMonth() + 1).padStart(2, '0')
      const day = String(d.getDate()).padStart(2, '0')
      return `${year}-${month}-${day}`
    }
  } catch (e) {}
  return String(dateStr).substring(0, 10)
}

const formatDateInfo = (dateKey) => {
  if (!dateKey || dateKey === 'sem-data') {
    return {
      short: 'Sem data',
      chip: 'Sem data',
      full: 'Data não informada',
    }
  }

  const parts = dateKey.split('-')
  if (parts.length === 3) {
    const year = parseInt(parts[0], 10)
    const month = parseInt(parts[1], 10) - 1
    const day = parseInt(parts[2], 10)
    const dateObj = new Date(year, month, day, 12, 0, 0)

    const short = `${String(day).padStart(2, '0')}/${String(month + 1).padStart(2, '0')}/${year}`
    const chip = `${String(day).padStart(2, '0')}/${String(month + 1).padStart(2, '0')}`

    let weekday = ''
    let monthLong = ''
    try {
      weekday = dateObj.toLocaleDateString('pt-BR', { weekday: 'long' })
      monthLong = dateObj.toLocaleDateString('pt-BR', { month: 'long' })
    } catch (e) {
      weekday = ''
      monthLong = ''
    }
    const capitalizedWeekday = weekday ? weekday.charAt(0).toUpperCase() + weekday.slice(1) : ''

    const today = new Date()
    const todayKey = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`
    
    const yesterday = new Date()
    yesterday.setDate(yesterday.getDate() - 1)
    const yesterdayKey = `${yesterday.getFullYear()}-${String(yesterday.getMonth() + 1).padStart(2, '0')}-${String(yesterday.getDate()).padStart(2, '0')}`

    let prefix = ''
    if (dateKey === todayKey) prefix = 'Hoje - '
    else if (dateKey === yesterdayKey) prefix = 'Ontem - '

    return {
      short,
      chip,
      full: `${prefix}${capitalizedWeekday ? capitalizedWeekday + ', ' : ''}${day} de ${monthLong || (month + 1)} de ${year}`,
    }
  }

  return { short: dateKey, chip: dateKey, full: dateKey }
}

const availableDays = computed(() => {
  const daysMap = new Map()

  for (const reading of filteredReadings.value) {
    const key = getDateKey(reading.read_at || reading.created_at)
    if (!daysMap.has(key)) {
      daysMap.set(key, [])
    }
    daysMap.get(key).push(reading)
  }

  const sortedKeys = Array.from(daysMap.keys()).sort((a, b) => b.localeCompare(a))

  return sortedKeys.map((key) => {
    const items = daysMap.get(key)
    const dateInfo = formatDateInfo(key)
    return {
      key,
      labelShort: dateInfo.short,
      labelChip: dateInfo.chip,
      labelFull: dateInfo.full,
      count: items.length,
      weevils: items.reduce((sum, r) => sum + Number(r.weevil_count ?? 0), 0),
      critical: items.filter((r) => Number(r.weevil_count ?? 0) >= 10).length,
      items,
    }
  })
})

const selectedDateKey = ref(null)

watch(
  availableDays,
  (days) => {
    if (!days.length) return
    if (!selectedDateKey.value) {
      selectedDateKey.value = days[0].key
    }
  },
  { immediate: true }
)

const currentDayIndex = computed(() => {
  if (!availableDays.value.length) return 0
  if (!selectedDateKey.value) return 0
  const idx = availableDays.value.findIndex((d) => d.key === selectedDateKey.value)
  return idx !== -1 ? idx : 0
})

const totalPages = computed(() => Math.max(1, availableDays.value.length))

const currentPage = computed({
  get: () => currentDayIndex.value + 1,
  set: (page) => {
    const targetIdx = Math.min(Math.max(1, page), totalPages.value) - 1
    const day = availableDays.value[targetIdx]
    if (day) {
      selectedDateKey.value = day.key
    }
  },
})

const currentDay = computed(() => {
  if (!availableDays.value.length) return null
  return availableDays.value[currentDayIndex.value] || null
})

const paginatedReadings = computed(() => {
  return currentDay.value ? currentDay.value.items : []
})

const goToPage = (page) => {
  currentPage.value = page
}

const visiblePageItems = computed(() => {
  const total = totalPages.value
  const current = currentPage.value
  const days = availableDays.value

  const makeItem = (p) => ({
    page: p,
    label: days[p - 1]?.labelChip || `Pág ${p}`,
  })

  if (total <= 7) {
    return Array.from({ length: total }, (_, i) => makeItem(i + 1))
  }

  if (current <= 4) {
    return [
      makeItem(1),
      makeItem(2),
      makeItem(3),
      makeItem(4),
      makeItem(5),
      '...',
      makeItem(total),
    ]
  }

  if (current >= total - 3) {
    return [
      makeItem(1),
      '...',
      makeItem(total - 4),
      makeItem(total - 3),
      makeItem(total - 2),
      makeItem(total - 1),
      makeItem(total),
    ]
  }

  return [
    makeItem(1),
    '...',
    makeItem(current - 1),
    makeItem(current),
    makeItem(current + 1),
    '...',
    makeItem(total),
  ]
})

const lowBatteryCount = computed(() => {
  return (props.readings || []).filter((r) => Number(r.battery_level ?? 0) <= 20).length
})

const formatWeevilText = (count) => {
  const num = Number(count ?? 0)
  if (num === 0) return '0 bicudos (Zero)'
  if (num === 1) return '1 bicudo (Atenção)'
  if (num < 10) return `${num} bicudos (Atenção)`
  return `${num} bicudos (Crítico)`
}

const weevilBadgeClasses = (count) => {
  const num = Number(count ?? 0)
  if (num === 0) {
    return 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
  }
  if (num < 10) {
    return 'bg-amber-50 text-amber-700 ring-amber-600/20'
  }
  return 'bg-rose-50 text-rose-700 font-bold ring-rose-600/30'
}

const formatBattery = (level) => {
  if (level === null || level === undefined) return 'N/A'
  const num = Number(level)
  return `${Number.isInteger(num) ? num : num.toFixed(1)}%`
}

const batteryBadgeClasses = (level) => {
  const num = Number(level ?? 0)
  if (num <= 20) {
    return 'bg-red-50 text-red-700 ring-red-600/20'
  }
  if (num <= 50) {
    return 'bg-amber-50 text-amber-700 ring-amber-600/20'
  }
  return 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
}

const formatTime = (dateStr) => {
  if (!dateStr) return '-'
  try {
    const d = new Date(dateStr)
    if (isNaN(d.getTime())) return dateStr
    return d.toLocaleTimeString('pt-BR', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
    })
  } catch (e) {
    return '-'
  }
}

const formatDateOnly = (dateStr) => {
  if (!dateStr) return ''
  try {
    const d = new Date(dateStr)
    if (isNaN(d.getTime())) return ''
    return d.toLocaleDateString('pt-BR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    })
  } catch (e) {
    return ''
  }
}
</script>
