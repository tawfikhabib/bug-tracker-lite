<template>
  <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">✏️ Edit Bug</h2>

      <form @submit.prevent="submit">
        <input v-model="form.title" placeholder="Title" class="w-full mb-2 border px-3 py-2 rounded" />
        <textarea v-model="form.description" placeholder="Description" class="w-full mb-2 border px-3 py-2 rounded" />

        <select v-model="form.status" class="w-full mb-2 border px-3 py-2 rounded">
          <option value="open">Open</option>
          <option value="in_progress">In Progress</option>
          <option value="closed">Closed</option>
        </select>

        <select v-model="form.priority" class="w-full mb-4 border px-3 py-2 rounded">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <button @click="close" type="button" class="ml-2 text-gray-600">Cancel</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useBugStore } from '../stores/bug'

const props = defineProps({ visible: Boolean, bug: Object })
const emit = defineEmits(['close'])

const toast = useToast()
const store = useBugStore()

const form = ref({ ...props.bug })

watch(() => props.bug, (newBug) => {
  form.value = { ...newBug }
})

const submit = async () => {
  try {
    await axios.put(`/api/bugs/${form.value.id}`, form.value)
    toast.success('✅ Bug updated')
    store.load()
    emit('close')
  } catch {
    toast.error('❌ Update failed')
  }
}

const close = () => emit('close')
</script>