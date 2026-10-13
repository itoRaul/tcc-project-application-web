<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="add-device-modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm" @click="emit('close')"></div>
    <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
      <div class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
        <div class="flex items-start justify-between border-b border-slate-200 px-5 py-5 sm:px-7">
          <div class="flex gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="5" y="3" width="14" height="18" rx="3" />
                <path stroke-linecap="round" d="M9 7h6M12 17h.01" />
              </svg>
            </span>
            <div>
              <h2 id="add-device-modal-title" class="text-lg font-bold text-slate-950">{{ isEditing ? 'Editar dispositivo' : 'Adicionar dispositivo' }}</h2>
              <p class="mt-1 text-sm text-slate-500">{{ isEditing ? 'Atualize os dados e a localização do equipamento.' : 'Cadastre a identificação e a localização do equipamento.' }}</p>
            </div>
          </div>
          <button
            type="button"
            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            aria-label="Fechar cadastro"
            @click="emit('close')"
          >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="emit('submit')">
          <div class="max-h-[70vh] space-y-7 overflow-y-auto px-5 py-6 sm:px-7">
            <div v-if="form.hasErrors" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
              <p class="font-semibold">{{ isEditing ? 'Não foi possível salvar as alterações.' : 'Não foi possível cadastrar o dispositivo.' }}</p>
              <p class="mt-1 text-xs">Por favor, revise os campos abaixo e tente novamente.</p>
            </div>

            <fieldset>
              <legend class="mb-4 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                <span class="h-px w-5 bg-slate-300"></span>
                Identificação
              </legend>
              <div class="grid gap-5 sm:grid-cols-2">
                <div>
                  <label for="device-name" class="mb-2 block text-sm font-semibold text-slate-700">Nome do dispositivo</label>
                  <input
                    id="device-name"
                    v-model="form.name"
                    type="text"
                    required
                    maxlength="100"
                    placeholder="Ex.: Sensor da estufa 01"
                    class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
                  >
                  <span v-if="form.errors.name" class="mt-1.5 block text-xs font-medium text-red-600">{{ form.errors.name }}</span>
                </div>
                <div>
                  <label for="device-type" class="mb-2 block text-sm font-semibold text-slate-700">Tipo</label>
                  <select
                    id="device-type"
                    v-model="form.type"
                    required
                    class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                  >
                    <option value="" disabled>Selecione o tipo</option>
                    <option value="SENSOR_NODE">Nó sensor (SENSOR_NODE)</option>
                    <option value="GATEWAY">Gateway (GATEWAY)</option>
                  </select>
                  <span v-if="form.errors.type" class="mt-1.5 block text-xs font-medium text-red-600">{{ form.errors.type }}</span>
                </div>
                <div class="sm:col-span-2">
                  <label for="device-mac" class="mb-2 block text-sm font-semibold text-slate-700">Endereço MAC</label>
                  <input
                    id="device-mac"
                    v-model="form.mac_address"
                    type="text"
                    required
                    maxlength="17"
                    placeholder="04:B2:47:97:8A:11"
                    class="block h-11 w-full rounded-xl border-slate-300 px-3 font-mono text-sm uppercase text-slate-900 shadow-sm placeholder:font-sans placeholder:normal-case placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
                  >
                  <span v-if="form.errors.mac_address" class="mt-1.5 block text-xs font-medium text-red-600">{{ form.errors.mac_address }}</span>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <legend class="mb-4 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                <span class="h-px w-5 bg-slate-300"></span>
                Localização e operação
              </legend>
              <div class="grid gap-5 sm:grid-cols-2">
                <div>
                  <label for="device-latitude" class="mb-2 block text-sm font-semibold text-slate-700">Latitude</label>
                  <input
                    id="device-latitude"
                    v-model="form.latitude"
                    type="number"
                    step="any"
                    min="-90"
                    max="90"
                    required
                    placeholder="-12.085000"
                    class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
                  >
                  <span v-if="form.errors.latitude" class="mt-1.5 block text-xs font-medium text-red-600">{{ form.errors.latitude }}</span>
                </div>
                <div>
                  <label for="device-longitude" class="mb-2 block text-sm font-semibold text-slate-700">Longitude</label>
                  <input
                    id="device-longitude"
                    v-model="form.longitude"
                    type="number"
                    step="any"
                    min="-180"
                    max="180"
                    required
                    placeholder="-45.785000"
                    class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
                  >
                  <span v-if="form.errors.longitude" class="mt-1.5 block text-xs font-medium text-red-600">{{ form.errors.longitude }}</span>
                </div>
                <div class="sm:col-span-2">
                  <label for="device-status" class="mb-2 block text-sm font-semibold text-slate-700">{{ isEditing ? 'Status' : 'Status inicial' }}</label>
                  <select
                    id="device-status"
                    v-model="form.status"
                    class="block h-11 w-full rounded-xl border-slate-300 px-3 text-sm text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                  >
                    <option value="ACTIVE">Ativo</option>
                    <option value="INACTIVE">Inativo</option>
                    <option value="MAINTENANCE">Em manutenção</option>
                  </select>
                  <span v-if="form.errors.status" class="mt-1.5 block text-xs font-medium text-red-600">{{ form.errors.status }}</span>
                </div>
              </div>
            </fieldset>
          </div>

          <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-7">
            <button type="button" class="h-10 rounded-xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" @click="emit('close')">
              Cancelar
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
            >
              <svg v-if="form.processing" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" />
                <path class="opacity-75" fill="currentColor" d="M12 3a9 9 0 0 1 9 9h-3a6 6 0 0 0-6-6V3Z" />
              </svg>
              {{ form.processing ? 'Salvando...' : (isEditing ? 'Salvar alterações' : 'Salvar dispositivo') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    form: {
        type: Object,
        required: true,
    },
    isEditing: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close', 'submit'])
</script>
