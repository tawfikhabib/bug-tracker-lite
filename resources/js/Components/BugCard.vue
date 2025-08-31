<template>
  <div class="border rounded p-4 shadow-sm bg-white">
    <div class="flex justify-between items-center">
      <h3 class="font-bold text-lg">{{ bug.title }}</h3>
      <StatusBadge :status="bug.status" />
    </div>
    <p class="text-sm text-gray-600 mt-2">{{ bug.description }}</p>
    <div class="mt-2 text-sm text-gray-500 flex items-center gap-2">
    <span :class="priorityClass" class="px-2 py-1 rounded text-xs font-bold">
        {{ bug.priority }}
    </span>
    • Project: {{ bug.project?.name }}
    </div>

  </div>
</template>

<script setup>
import StatusBadge from './StatusBadge.vue'
defineProps({ bug: Object })

const priorityClass = computed(() => {
  switch (bug.priority) {
    case 'high': return 'bg-red-100 text-red-700'
    case 'medium': return 'bg-yellow-100 text-yellow-700'
    case 'low': return 'bg-green-100 text-green-700'
    default: return 'bg-gray-100 text-gray-700'
  }
})
</script>