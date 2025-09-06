<template>
  <span :class="badgeClass" class="px-2 py-1 rounded text-xs font-semibold">
    {{ status }}
  </span>
</template>

<script setup>
import { computed } from 'vue'
const props = defineProps({ status: String })

const badgeClass = computed(() => {
  switch (props.status) {
    case 'open': return 'bg-red-100 text-red-700'
    case 'in_progress': return 'bg-yellow-100 text-yellow-700'
    case 'closed': return 'bg-green-100 text-green-700'
    default: return 'bg-gray-100 text-gray-700'
  }
})
</script>