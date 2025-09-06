<template>
  <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">➕ Create New Bug</h2>

      <form @submit.prevent="submit">
        <input v-model="form.title" placeholder="Title" class="w-full mb-2 border px-3 py-2 rounded" />
        
        <select v-model="form.project_id" class="w-full mb-2 border px-3 py-2 rounded">
          <option disabled value="">Select Project</option>
          <option v-for="project in projects" :key="project.id" :value="project.id">
            {{ project.name }}
          </option>
        </select>

        <select v-model="form.assigned_to" class="w-full mb-2 border px-3 py-2 rounded">
          <option disabled value="">Assign To</option>
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.name }}
          </option>
        </select>

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

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Create</button>
        <button @click="close" type="button" class="ml-2 text-gray-600">Cancel</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useBugStore } from '../stores/bug'
import { useToast } from 'vue-toastification'

const props = defineProps({
  visible: Boolean,
  projects: {
    type: Array,
    required: true
  },
  users: {
    type: Array,
    required: true
  }
})

const toast = useToast()
const emit = defineEmits(['close'])

const form = ref({
  title: '',
  project_id: '',
  description: '',
  status: 'open',
  priority: 'medium',
})

const store = useBugStore()

const submit = async () => {
  await axios.post('/api/bugs', form.value)
  toast.success('✅ Bug created successfully!')
  store.load() // reload bugs
  emit('close')
}

const close = () => emit('close')
</script>