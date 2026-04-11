
<script setup lang="ts">
import { inject, computed, type Ref } from 'vue'
import { ChevronDown } from 'lucide-vue-next'

defineProps<{
  label: string
  panelClass?: string
  rightAlign?: boolean
}>()

const id = Symbol()
const openDropdownId = inject<Ref<symbol | null>>('nav-open-dropdown-id')
const setOpenDropdown = inject<(id: symbol | null) => void>('nav-set-open-dropdown')

const isOpen = computed(() => openDropdownId?.value === id)

function toggle() {
  setOpenDropdown?.(isOpen.value ? null : id)
}
</script>

<template>
  <li class="relative">
    <button
      type="button"
      class="flex items-center gap-1 px-2 py-1.5 text-white/75 hover:text-white transition-all duration-150 font-medium whitespace-nowrap bg-transparent border-0 cursor-pointer"
      :aria-expanded="isOpen"
      @click.stop="toggle"
    >
      {{ label }}
      <slot name="trigger-suffix" />
      <ChevronDown :size="14" />
    </button>
    <ul
      v-show="isOpen"
      :class="[
        'xl:absolute xl:top-full static z-1000 min-w-40 py-2',
        'bg-card border border-border rounded-md shadow-md list-none pl-0 ml-4 xl:ml-0',
        rightAlign ? 'xl:right-0 xl:left-auto' : 'xl:left-0',
        panelClass,
      ]"
    >
      <slot />
    </ul>
  </li>
</template>
