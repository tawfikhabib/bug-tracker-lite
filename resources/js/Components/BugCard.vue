<template>
  <div class="border rounded p-4 shadow-sm bg-white">
    <div class="flex justify-between items-center">
      <h3 class="font-bold text-lg">{{ bug.title }}</h3>
      <StatusBadge :status="bug.status" />
    </div>
    <p class="text-sm text-gray-600 mt-2">{{ bug.description }}</p>
    <BugEditModal :visible="showEdit" :bug="bug" @close="showEdit = false" />
    <div class="mt-2 text-sm text-gray-500 flex items-center gap-2">
    <span :class="priorityClass" class="px-2 py-1 rounded text-xs font-bold">
        {{ bug.priority }}
    </span>
        • Project: {{ bug.project?.name }}
    </div>
    <div class="flex gap-2">
      <button @click="showEdit = true" class="text-blue-600 text-sm hover:underline">✏️ Edit</button>
      <button @click="deleteBug" class="text-red-600 text-sm hover:underline">🗑️ Delete</button>
    </div>


  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, computed } from 'vue'
import StatusBadge from './StatusBadge.vue'
import { useBugStore } from '../stores/bug'
import { useToast } from 'vue-toastification'
import BugEditModal from './BugEditModal.vue'

const store = useBugStore()
const props = defineProps({ bug: Object })
const toast = useToast()
const showEdit = ref(false)

const priorityClass = computed(() => {
  switch (props.bug.priority) {
    case 'high': return 'bg-red-100 text-red-700'
    case 'medium': return 'bg-yellow-100 text-yellow-700'
    case 'low': return 'bg-green-100 text-green-700'
    default: return 'bg-gray-100 text-gray-700'
  }
})

const deleteBug = async () => {
  try {
    await axios.delete(`/api/bugs/${props.bug.id}`)
    toast.success('✅ Bug deleted successfully!')
    store.load()
  } catch (error) {
    toast.error('❌ Failed to delete bug.')
  }
}
</script>