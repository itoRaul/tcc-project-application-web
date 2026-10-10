<template>
  <Layout title="Mapa de calor">
    <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg shadow-gray-200/50">
      <header class="flex flex-col gap-3 border-b border-gray-100 px-4 py-3 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex min-w-0 flex-col gap-3 sm:flex-row sm:items-center">
          <div class="shrink-0 pr-2">
            <div class="flex items-center gap-2">
              <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-50"></span>
              <h2 class="font-semibold text-gray-900">Mapa de densidade</h2>
            </div>
            <p class="mt-0.5 pl-[18px] text-xs text-gray-400">{{ validDevices.length }} pontos georreferenciados</p>
          </div>

          <div class="grid grid-cols-3 divide-x divide-gray-200 rounded-xl border border-gray-100 bg-gray-50/80 px-1 py-2" aria-label="Resumo dos dispositivos">
            <div class="min-w-20 px-3 text-center">
              <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Mapeados</p>
              <p class="mt-0.5 text-base font-bold leading-none text-gray-800">{{ validDevices.length }}</p>
            </div>
            <div class="min-w-20 px-3 text-center">
              <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Disponíveis</p>
              <p class="mt-0.5 text-base font-bold leading-none text-emerald-600">{{ availability }}%</p>
            </div>
            <div class="min-w-20 px-3 text-center">
              <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Gateways</p>
              <p class="mt-0.5 text-base font-bold leading-none text-gray-800">{{ gatewayDevices }}</p>
            </div>
          </div>
        </div>

        <div class="flex shrink-0 flex-wrap items-center gap-2">
          <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-xs font-semibold transition focus:outline-none focus:ring-2 focus:ring-emerald-500/30"
            :class="isHeatVisible ? 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50'"
            :aria-pressed="isHeatVisible"
            @click="toggleHeatLayer"
          >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2 3 5 5.25 5 9a5 5 0 0 1-10 0c0-2.2 1.1-4 2.5-5.5.25 1.5 1 2.5 2 3 .5-2.5.5-4.5.5-6.5Z" />
            </svg>
            Calor
          </button>
          <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 disabled:cursor-not-allowed disabled:opacity-50"
            :disabled="validDevices.length === 0"
            @click="fitDevices"
          >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 3H5a2 2 0 0 0-2 2v3m13-5h3a2 2 0 0 1 2 2v3M8 21H5a2 2 0 0 1-2-2v-3m13 5h3a2 2 0 0 0 2-2v-3" />
            </svg>
            Enquadrar
          </button>
        </div>
      </header>

      <div class="relative isolate bg-slate-100">
        <div
          ref="mapContainer"
          class="h-[calc(100vh-16rem)] min-h-[36rem] w-full max-h-[64rem]"
          role="region"
          aria-label="Mapa interativo com a localização dos dispositivos"
        ></div>

        <div
          v-if="validDevices.length === 0"
          class="pointer-events-none absolute inset-0 z-[500] flex items-center justify-center bg-slate-100/80 p-6 backdrop-blur-[2px]"
        >
          <div class="max-w-sm rounded-2xl border border-white/80 bg-white/95 p-6 text-center shadow-xl shadow-slate-300/40">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
              <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18.75 3.75 21V5.25L9 3m0 15.75L15 21m-6-2.25V3m6 18 5.25-2.25V3L15 5.25M15 21V5.25M15 5.25 9 3" />
              </svg>
            </span>
            <h3 class="mt-4 font-semibold text-gray-900">Nenhum dispositivo mapeado</h3>
            <p class="mt-1 text-sm leading-5 text-gray-500">Cadastre coordenadas válidas de latitude e longitude para visualizar a rede.</p>
          </div>
        </div>
      </div>

      <footer class="grid gap-3 border-t border-gray-100 px-4 py-2.5 md:grid-cols-[1fr_auto] md:items-center">
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-[11px] text-gray-500">
          <span class="font-semibold uppercase tracking-wider text-gray-400">Status</span>
          <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>Ativo ({{ activeDevices }})</span>
          <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>Manutenção ({{ maintenanceDevices }})</span>
          <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-stone-400"></span>Inativo ({{ inactiveDevices }})</span>
        </div>

        <div class="flex min-w-44 items-center gap-2 text-[11px] text-gray-500">
          <span>Baixa</span>
          <span class="h-2 flex-1 rounded-full bg-gradient-to-r from-cyan-400 via-lime-400 via-55% to-rose-500 md:w-32"></span>
          <span>Alta densidade</span>
        </div>
      </footer>
    </section>
  </Layout>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import 'leaflet.heat'
import Layout from '@/Layouts/Layout.vue'

const props = defineProps({
  devices: {
    type: Array,
    default: () => [],
  },
})

const mapContainer = ref(null)
const isHeatVisible = ref(true)

let map = null
let heatLayer = null
let markersLayer = null
let baseLayer = null

const tileProviders = [
  {
    url: 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
    options: {
      attribution: '&copy; OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team',
      maxZoom: 19,
      subdomains: 'abc',
    },
  },
  {
    url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
    options: {
      attribution: 'Tiles &copy; Esri',
      maxZoom: 19,
    },
  },
]

const loadTileProvider = (providerIndex = 0) => {
  if (!map) return

  if (baseLayer) {
    map.removeLayer(baseLayer)
  }

  const provider = tileProviders[providerIndex]
  baseLayer = L.tileLayer(provider.url, provider.options)

  if (providerIndex < tileProviders.length - 1) {
    baseLayer.once('tileerror', () => loadTileProvider(providerIndex + 1))
  }

  baseLayer.addTo(map)
}

const validDevices = computed(() => props.devices
  .map((device) => ({
    ...device,
    latitude: Number(device.latitude),
    longitude: Number(device.longitude),
  }))
  .filter((device) => Number.isFinite(device.latitude)
    && Number.isFinite(device.longitude)
    && device.latitude >= -85.05112878
    && device.latitude <= 85.05112878
    && device.longitude >= -180
    && device.longitude <= 180))

const activeDevices = computed(() => validDevices.value.filter((device) => device.status === 'ACTIVE').length)
const maintenanceDevices = computed(() => validDevices.value.filter((device) => device.status === 'MAINTENANCE').length)
const inactiveDevices = computed(() => validDevices.value.filter((device) => device.status === 'INACTIVE').length)
const gatewayDevices = computed(() => validDevices.value.filter((device) => device.type === 'GATEWAY').length)
const availability = computed(() => validDevices.value.length
  ? Math.round((activeDevices.value / validDevices.value.length) * 100)
  : 0)

const statusMeta = {
  ACTIVE: { label: 'Ativo', color: '#10b981' },
  MAINTENANCE: { label: 'Em manutenção', color: '#f59e0b' },
  INACTIVE: { label: 'Inativo', color: '#78716c' },
}

const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({
  '&': '&amp;',
  '<': '&lt;',
  '>': '&gt;',
  "'": '&#039;',
  '"': '&quot;',
})[character])

const popupContent = (device) => {
  const status = statusMeta[device.status] ?? { label: 'Desconhecido', color: '#64748b' }
  const type = device.type === 'GATEWAY' ? 'Gateway' : 'Nó sensor'

  return `
    <div class="device-popup">
      <div class="device-popup__eyebrow">${escapeHtml(type)}</div>
      <strong class="device-popup__title">${escapeHtml(device.name)}</strong>
      <div class="device-popup__status">
        <span style="background:${status.color}"></span>${escapeHtml(status.label)}
      </div>
      <div class="device-popup__coordinates">
        ${device.latitude.toFixed(6)}, ${device.longitude.toFixed(6)}
      </div>
    </div>
  `
}

const fitDevices = () => {
  if (!map || validDevices.value.length === 0) return

  const bounds = L.latLngBounds(validDevices.value.map((device) => [device.latitude, device.longitude]))

  if (validDevices.value.length === 1) {
    map.setView(bounds.getCenter(), 16, { animate: true })
    return
  }

  map.fitBounds(bounds, {
    animate: true,
    maxZoom: 15,
    padding: [48, 48],
  })
}

const updateMapLayers = (shouldFit = false) => {
  if (!map || !heatLayer || !markersLayer) return

  const heatPoints = validDevices.value.map((device) => [device.latitude, device.longitude, 1])
  heatLayer.setLatLngs(heatPoints)
  markersLayer.clearLayers()

  validDevices.value.forEach((device) => {
    const status = statusMeta[device.status] ?? { color: '#64748b' }
    const marker = L.circleMarker([device.latitude, device.longitude], {
      radius: device.type === 'GATEWAY' ? 7 : 5.5,
      color: '#ffffff',
      weight: 2,
      fillColor: status.color,
      fillOpacity: 1,
      opacity: 0.95,
    })

    marker.bindPopup(popupContent(device), {
      closeButton: false,
      maxWidth: 260,
      offset: [0, -4],
    })
    marker.bindTooltip(escapeHtml(device.name), {
      direction: 'top',
      offset: [0, -7],
      opacity: 0.95,
    })
    marker.addTo(markersLayer)
  })

  if (shouldFit) fitDevices()
}

const toggleHeatLayer = () => {
  if (!map || !heatLayer) return

  isHeatVisible.value = !isHeatVisible.value

  if (isHeatVisible.value) {
    heatLayer.addTo(map)
    heatLayer.bringToBack()
  } else {
    map.removeLayer(heatLayer)
  }
}

const initializeMap = async () => {
  await nextTick()
  if (!mapContainer.value || map) return

  map = L.map(mapContainer.value, {
    attributionControl: true,
    minZoom: 3,
    maxZoom: 19,
    preferCanvas: true,
    scrollWheelZoom: true,
    zoomControl: false,
  }).setView([-14.235, -51.9253], 4)

  loadTileProvider()

  L.control.zoom({ position: 'bottomright' }).addTo(map)

  heatLayer = L.heatLayer([], {
    radius: 42,
    blur: 30,
    maxZoom: 17,
    minOpacity: 0.32,
    gradient: {
      0.15: '#22d3ee',
      0.35: '#22c55e',
      0.55: '#a3e635',
      0.72: '#facc15',
      0.86: '#fb923c',
      1: '#ef4444',
    },
  }).addTo(map)

  markersLayer = L.layerGroup().addTo(map)
  updateMapLayers(true)

  requestAnimationFrame(() => map?.invalidateSize())
}

watch(() => props.devices, () => updateMapLayers(true), { deep: true })

onMounted(initializeMap)

onBeforeUnmount(() => {
  map?.remove()
  map = null
  heatLayer = null
  markersLayer = null
  baseLayer = null
})
</script>

<style scoped>
:deep(.leaflet-container) {
  background: #e2e8f0;
  color: #1f2937;
  font-family: inherit;
}

:deep(.leaflet-control-attribution) {
  background: rgb(255 255 255 / 82%);
  color: #64748b;
  font-size: 10px;
  backdrop-filter: blur(8px);
}

:deep(.leaflet-control-attribution a) {
  color: #047857;
}

:deep(.leaflet-control-zoom) {
  overflow: hidden;
  border: 1px solid rgb(226 232 240 / 90%);
  border-radius: 12px;
  box-shadow: 0 8px 24px rgb(15 23 42 / 12%);
}

:deep(.leaflet-control-zoom a) {
  border-color: #e2e8f0;
  color: #334155;
  line-height: 30px;
}

:deep(.leaflet-control-zoom a:hover) {
  background: #ecfdf5;
  color: #047857;
}

:deep(.leaflet-popup-content-wrapper) {
  border: 1px solid rgb(226 232 240 / 80%);
  border-radius: 16px;
  box-shadow: 0 16px 40px rgb(15 23 42 / 18%);
}

:deep(.leaflet-popup-content) {
  margin: 16px 18px;
}

:deep(.device-popup__eyebrow) {
  margin-bottom: 4px;
  color: #059669;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

:deep(.device-popup__title) {
  display: block;
  color: #111827;
  font-size: 14px;
}

:deep(.device-popup__status) {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-top: 9px;
  color: #475569;
  font-size: 12px;
}

:deep(.device-popup__status span) {
  width: 8px;
  height: 8px;
  border-radius: 999px;
}

:deep(.device-popup__coordinates) {
  margin-top: 8px;
  color: #94a3b8;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  font-size: 10px;
}

:deep(.leaflet-tooltip) {
  border: 0;
  border-radius: 8px;
  padding: 6px 9px;
  background: #0f172a;
  color: #fff;
  font-family: inherit;
  font-size: 11px;
  font-weight: 600;
  box-shadow: 0 8px 20px rgb(15 23 42 / 18%);
}

:deep(.leaflet-tooltip-top::before) {
  border-top-color: #0f172a;
}
</style>
