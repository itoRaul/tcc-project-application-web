<template>
  <Transition
    enter-active-class="transition duration-200 ease-out"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition duration-150 ease-in"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="show"
      class="fixed inset-0 z-50 overflow-y-auto"
      aria-labelledby="delete-modal-title"
      role="alertdialog"
      aria-modal="true"
    >
      <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm" @click="cancel"></div>

      <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl" @click.stop>
          <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600 ring-8 ring-red-50">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
          </span>

          <h2 id="delete-modal-title" class="mt-5 text-lg font-bold text-slate-950">Excluir dispositivo?</h2>
          <p class="mt-1 text-sm text-slate-500">
            O dispositivo
            <span class="font-semibold text-slate-700">#{{ device?.id }} {{ device?.name }}</span>
            será removido permanentemente.
          </p>

          <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row">
            <button
              type="button"
              :disabled="processing"
              class="h-10 flex-1 rounded-xl border border-slate-300 bg-white text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
              @click="cancel"
            >
              Cancelar
            </button>
            <button
              type="button"
              :disabled="processing"
              class="inline-flex h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-red-600 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
              @click="emit('confirm')"
            >
              <svg v-if="processing" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" />
                <path class="opacity-75" fill="currentColor" d="M12 3a9 9 0 0 1 9 9h-3a6 6 0 0 0-6-6V3Z" />
              </svg>
              {{ processing ? 'Excluindo...' : 'Excluir' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    device: {
        type: Object,
        default: null,
    },
    processing: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close', 'confirm'])

const cancel = () => {
    if (!props.processing) emit('close')
}
</script>
