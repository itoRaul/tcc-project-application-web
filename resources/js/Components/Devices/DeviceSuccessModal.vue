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
      aria-labelledby="success-modal-title"
      role="dialog"
      aria-modal="true"
    >
      <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm" @click="emit('close')"></div>

      <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl" @click.stop>
          <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 ring-8 ring-emerald-50">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M20 6 9 17l-5-5" />
            </svg>
          </span>

          <h2 id="success-modal-title" class="mt-5 text-lg font-bold text-slate-950">
            {{ action === 'edit' ? 'Dispositivo atualizado!' : 'Dispositivo cadastrado!' }}
          </h2>
          <p class="mt-1 text-sm text-slate-500">
            {{ action === 'edit' ? 'As alterações foram salvas com sucesso.' : 'O dispositivo foi cadastrado com sucesso.' }}
          </p>

          <button
            type="button"
            class="mt-6 h-10 w-full rounded-xl bg-emerald-600 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            @click="emit('close')"
          >
            OK
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    action: {
        type: String,
        default: 'create',
    },
})

const emit = defineEmits(['close'])
</script>
