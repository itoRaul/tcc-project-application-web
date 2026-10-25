<template>
  <Layout title="Dispositivos">
    <div class="min-h-full bg-slate-50/80">
      <div class="w-full px-2 py-4 sm:px-4 sm:py-5 lg:px-5 lg:py-6">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <div class="border-l-4 border-emerald-600 px-5 py-6 sm:px-7">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
              <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Dispositivos</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                  Consulte o estado dos equipamentos e mantenha o inventário da operação organizado.
                </p>
              </div>

              <div class="flex flex-col gap-3 sm:flex-row">
                <button
                  type="button"
                  class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                  @click="openFilterModal"
                >
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M6 12h12M10 19h4" />
                  </svg>
                  Filtros
                  <span
                    v-if="activeFilterCount"
                    class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-emerald-600 px-1.5 text-[11px] font-bold text-white"
                  >
                    {{ activeFilterCount }}
                  </span>
                </button>
                <button
                  type="button"
                  class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                  @click="openAddModal"
                >
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                  </svg>
                  Novo dispositivo
                </button>
              </div>
            </div>
          </div>

          <div class="grid border-t border-slate-200 sm:grid-cols-3">
            <div class="flex items-center gap-4 px-5 py-4 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                  <rect x="4" y="4" width="16" height="16" rx="3" />
                  <path stroke-linecap="round" d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 15h3M1 9h3M1 15h3" />
                </svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Cadastrados</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ devices.length }}</p>
              </div>
            </div>
            <div class="flex items-center gap-4 border-t border-slate-200 px-5 py-4 sm:border-l sm:border-t-0 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <span class="h-3 w-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Em operação</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ operationalDevices }}</p>
              </div>
            </div>
            <div class="flex items-center gap-4 border-t border-slate-200 px-5 py-4 sm:border-l sm:border-t-0 sm:px-7">
              <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 4.3 2.7 17.5A2 2 0 0 0 4.4 20h15.2a2 2 0 0 0 1.7-2.5L13.7 4.3a2 2 0 0 0-3.4 0Z" />
                </svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Em manutenção</p>
                <p class="mt-0.5 text-xl font-bold text-slate-900">{{ maintenanceDevices }}</p>
              </div>
            </div>
          </div>
        </section>

        <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
              <h2 class="font-bold text-slate-900">Lista de dispositivos</h2>
              <p class="mt-0.5 text-sm text-slate-500">
                {{ filteredDevices.length }} {{ filteredDevices.length === 1 ? 'resultado encontrado' : 'resultados encontrados' }}
              </p>
            </div>
            <button
              v-if="activeFilterCount"
              type="button"
              class="inline-flex items-center gap-1.5 self-start text-sm font-semibold text-emerald-600 transition hover:text-emerald-800 sm:self-auto"
              @click="clearFilters"
            >
              Limpar filtros
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" d="m7 7 10 10M17 7 7 17" />
              </svg>
            </button>
          </div>

          <template v-if="filteredDevices.length">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
              <thead class="bg-slate-50">
                <tr>
                  <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">ID</th>
                  <th scope="col" class="py-3.5 pl-5 pr-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 sm:pl-6">Dispositivo</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Tipo</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Ações</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 bg-white">
                <tr v-for="device in paginatedDevices" :key="device.id" class="transition-colors hover:bg-emerald-50/40">
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-slate-600">#{{ device.id }}</td>
                  <td class="whitespace-nowrap py-4 pl-5 pr-3 sm:pl-6">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="text-sm font-semibold text-slate-900">{{ device.name }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-600">{{ formatType(device.type) }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm">
                    <span
                      class="inline-flex items-center gap-2 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset"
                      :class="statusClasses(device.status)"
                    >
                      <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                      {{ formatStatus(device.status) }}
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm">
                    <div class="flex items-center gap-1.5">
                      <button
                        type="button"
                        class="rounded-lg p-1.5 text-slate-500 transition hover:bg-slate-100 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        title="Editar dispositivo"
                        aria-label="Editar dispositivo"
                        @click="openEditModal(device)"
                      >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                      </button>
                      <button
                        type="button"
                        class="rounded-lg p-1.5 text-slate-500 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                        title="Excluir dispositivo"
                        aria-label="Excluir dispositivo"
                        @click="deleteDevice(device)"
                      >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <nav
            v-if="totalPages > 1"
            class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 px-5 py-4 sm:flex-row sm:px-6"
            aria-label="Paginação"
          >
            <p class="text-sm text-slate-500">
              Mostrando
              <span class="font-semibold text-slate-700">{{ pageStart }}</span>
              a
              <span class="font-semibold text-slate-700">{{ pageEnd }}</span>
              de
              <span class="font-semibold text-slate-700">{{ filteredDevices.length }}</span>
            </p>

            <div class="flex items-center gap-1">
              <button
                type="button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent"
                :disabled="currentPage === 1"
                aria-label="Página anterior"
                @click="goToPage(currentPage - 1)"
              >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
              </button>

              <template v-for="(page, index) in visiblePages" :key="index">
                <span v-if="page === '...'" class="inline-flex h-9 w-9 items-center justify-center text-sm text-slate-400">…</span>
                <button
                  v-else
                  type="button"
                  class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-sm font-semibold transition"
                  :class="page === currentPage ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                  :aria-current="page === currentPage ? 'page' : undefined"
                  @click="goToPage(page)"
                >
                  {{ page }}
                </button>
              </template>

              <button
                type="button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent"
                :disabled="currentPage === totalPages"
                aria-label="Próxima página"
                @click="goToPage(currentPage + 1)"
              >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                </svg>
              </button>
            </div>
          </nav>
          </template>

          <div v-else class="px-6 py-16 text-center">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
              <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M6 12h12M10 19h4" />
              </svg>
            </span>
            <h3 class="mt-4 font-bold text-slate-900">Nenhum dispositivo encontrado</h3>
            <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-slate-500">
              Ajuste os filtros utilizados ou limpe a busca para visualizar todos os dispositivos.
            </p>
            <button type="button" class="mt-5 text-sm font-semibold text-emerald-600 hover:text-emerald-800" @click="clearFilters">
              Limpar todos os filtros
            </button>
          </div>
        </section>
      </div>
    </div>

    <DeviceFilterModal
      :show="showFilter"
      :device-types="deviceTypes"
      :filters="appliedFilters"
      @close="showFilter = false"
      @apply="applyFilters"
    />

    <AddDeviceModal
      :show="showModal"
      :form="form"
      :is-editing="isEditing"
      @close="closeModal"
      @submit="submitForm"
    />

    <DeviceSuccessModal
      :show="showSuccessModal"
      :action="successAction"
      @close="showSuccessModal = false"
    />

    <DeleteDeviceModal
      :show="!!deletingDevice"
      :device="deletingDevice"
      :processing="isDeleting"
      @close="deletingDevice = null"
      @confirm="confirmDelete"
    />
  </Layout>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import AddDeviceModal from '@/Components/Devices/AddDeviceModal.vue'
import DeleteDeviceModal from '@/Components/Devices/DeleteDeviceModal.vue'
import DeviceFilterModal from '@/Components/Devices/DeviceFilterModal.vue'
import DeviceSuccessModal from '@/Components/Devices/DeviceSuccessModal.vue'
import Layout from '@/Layouts/Layout.vue'

const props = defineProps({
    devices: {
        type: Array,
        required: true,
    },
})

const showModal = ref(false)
const showFilter = ref(false)
const showSuccessModal = ref(false)
const successAction = ref('create')
const editingDevice = ref(null)
const deletingDevice = ref(null)
const isDeleting = ref(false)
const isEditing = computed(() => !!editingDevice.value)

const emptyFilters = () => ({
    query: '',
    type: '',
    status: '',
})

const appliedFilters = ref(emptyFilters())

const normalize = (value) => String(value ?? '').toLowerCase()

const deviceTypes = computed(() => {
    return [...new Set(props.devices.map((device) => device.type).filter(Boolean))]
        .sort((first, second) => String(first).localeCompare(String(second)))
})

const filteredDevices = computed(() => {
    const query = normalize(appliedFilters.value.query).trim()

    return props.devices.filter((device) => {
        const matchesQuery = !query || normalize(device.id).includes(query)
        const matchesType = !appliedFilters.value.type || device.type === appliedFilters.value.type
        const matchesStatus = !appliedFilters.value.status || normalize(device.status) === appliedFilters.value.status

        return matchesQuery && matchesType && matchesStatus
    })
})

const activeFilterCount = computed(() => {
    return Object.values(appliedFilters.value).filter((value) => String(value).trim() !== '').length
})

const perPage = 10
const currentPage = ref(1)

const totalPages = computed(() => Math.max(1, Math.ceil(filteredDevices.value.length / perPage)))

const paginatedDevices = computed(() => {
    const start = (currentPage.value - 1) * perPage
    return filteredDevices.value.slice(start, start + perPage)
})

const pageStart = computed(() => (currentPage.value - 1) * perPage + 1)
const pageEnd = computed(() => Math.min(currentPage.value * perPage, filteredDevices.value.length))

const visiblePages = computed(() => {
    const total = totalPages.value
    const current = currentPage.value

    if (total <= 7) {
        return Array.from({ length: total }, (_, i) => i + 1)
    }

    if (current <= 4) return [1, 2, 3, 4, 5, '...', total]
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total]

    return [1, '...', current - 1, current, current + 1, '...', total]
})

const goToPage = (page) => {
    currentPage.value = Math.min(Math.max(1, page), totalPages.value)
}

// Volta para a primeira página ao mudar os filtros
watch(appliedFilters, () => {
    currentPage.value = 1
})

// Evita ficar numa página vazia após excluir o último item dela
watch(totalPages, (total) => {
    if (currentPage.value > total) currentPage.value = total
})

const operationalDevices = computed(() => {
    return props.devices.filter((device) => normalize(device.status) === 'active').length
})

const maintenanceDevices = computed(() => {
    return props.devices.filter((device) => normalize(device.status) === 'maintenance').length
})

const openFilterModal = () => {
    showFilter.value = true
}

const applyFilters = (filters) => {
    appliedFilters.value = filters
    showFilter.value = false
}

const clearFilters = () => {
    appliedFilters.value = emptyFilters()
    showFilter.value = false
}

const form = useForm({
    mac_address: '',
    name: '',
    type: 'SENSOR_NODE',
    latitude: '',
    longitude: '',
    status: 'ACTIVE',
})

const openAddModal = () => {
    editingDevice.value = null
    form.reset()
    form.clearErrors()
    form.mac_address = ''
    form.name = ''
    form.type = 'SENSOR_NODE'
    form.latitude = ''
    form.longitude = ''
    form.status = 'ACTIVE'
    showModal.value = true
}

const openEditModal = (device) => {
    editingDevice.value = device
    form.clearErrors()
    form.mac_address = device.mac_address || ''
    form.name = device.name || ''
    form.type = device.type || 'SENSOR_NODE'
    form.latitude = device.latitude ?? ''
    form.longitude = device.longitude ?? ''
    form.status = device.status || 'ACTIVE'
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
    editingDevice.value = null
    form.clearErrors()
}

const showSuccess = (action) => {
    successAction.value = action
    showSuccessModal.value = true
}

const submitForm = () => {
    if (editingDevice.value) {
        form.put(`/dispositivos/${editingDevice.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
                showSuccess('edit')
            },
        })
    } else {
        form.post('/dispositivos', {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
                showSuccess('create')
            },
        })
    }
}

const deleteDevice = (device) => {
    deletingDevice.value = device
}

const confirmDelete = () => {
    if (!deletingDevice.value) return

    router.delete(`/dispositivos/${deletingDevice.value.id}`, {
        preserveScroll: true,
        onStart: () => {
            isDeleting.value = true
        },
        onSuccess: () => {
            deletingDevice.value = null
        },
        onFinish: () => {
            isDeleting.value = false
        },
    })
}

const formatType = (type) => {
    if (!type) return 'Não informado'

    const map = {
        sensor_node: 'Nó sensor',
        gateway: 'Gateway',
    }

    return map[normalize(type)] || type
}

const formatStatus = (status) => {
    if (!status) return 'Não informado'

    const map = {
        active: 'Ativo',
        inactive: 'Inativo',
        maintenance: 'Em manutenção',
    }

    return map[normalize(status)] || status
}

const statusClasses = (status) => {
    const normalizedStatus = normalize(status)

    if (normalizedStatus === 'active') {
        return 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
    }

    if (normalizedStatus === 'maintenance') {
        return 'bg-amber-50 text-amber-700 ring-amber-600/20'
    }

    if (normalizedStatus === 'inactive') {
        return 'bg-red-50 text-red-700 ring-red-600/20'
    }

    return 'bg-slate-100 text-slate-600 ring-slate-500/20'
}
</script>
