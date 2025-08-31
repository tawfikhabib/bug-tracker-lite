<template>
  <div>
    <button @click="showModal = true" class="bg-green-600 text-white px-4 py-2 rounded mb-4">
    ➕ New Bug
    </button>

    <CreateBugModal :projects="projects" :users="users" :visible="showModal" @close="showModal = false" />

    <input
    v-model="searchQuery"
    type="text"
    placeholder="🔎 Search bugs..."
    class="border rounded px-3 py-2 w-full"
    />

    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold">All Bugs</h2>
      <button @click="loadBugs" class="bg-blue-600 text-white px-4 py-2 rounded">🔄 Refresh</button>
    </div>

    <div class="flex gap-4 mb-6">
      <select v-model="selectedStatus" class="border rounded px-3 py-2">
        <option value="">All Statuses</option>
        <option value="open">Open</option>
        <option value="in_progress">In Progress</option>
        <option value="closed">Closed</option>
      </select>

      <select v-model="selectedPriority" class="border rounded px-3 py-2">
        <option value="">All Priorities</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>
    </div>

    <button
        @click="clearFilters"
        class="text-sm text-gray-600 underline hover:text-gray-900"
        >
        Clear Filters
    </button>


    <div class="grid gap-4">
      <BugCard
        v-for="bug in filteredBugs"
        :key="bug.id"
        :bug="bug"
      />
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useBugStore } from '../stores/bug'
import BugCard from '../Components/BugCard.vue'
import CreateBugModal from '../Components/CreateBugModal.vue'

const showModal = ref(false)
const store = useBugStore()
const bugs = store.bugs

const projects = ref([])
const users = ref([])
const loadBugs = store.load

const loadProjects = async () => {
  try {
    const res = await fetch('/api/projects')
    if (res.ok) {
      const data = await res.json()
      projects.value = Array.isArray(data) ? data : data.data || []
    }
  } catch (e) {
    console.error('Failed to load projects', e)
  }
}

const loadUsers = async () => {
  try {
    const res = await fetch('/api/users')
    if (res.ok) {
      const data = await res.json()
      users.value = Array.isArray(data) ? data : data.data || []
    }
  } catch (e) {
    console.error('Failed to load users', e)
  }
}

const selectedStatus = ref('')
const selectedPriority = ref('')

const searchQuery = ref('')

const filteredBugs = computed(() => {
  return bugs.filter(bug => {
    const statusMatch = selectedStatus.value ? bug.status === selectedStatus.value : true
    const priorityMatch = selectedPriority.value ? bug.priority === selectedPriority.value : true
    const searchMatch = searchQuery.value
      ? bug.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        bug.description.toLowerCase().includes(searchQuery.value.toLowerCase())
      : true
    return statusMatch && priorityMatch && searchMatch
  })
})

const clearFilters = () => {
  selectedStatus.value = ''
  selectedPriority.value = ''
  searchQuery.value = ''
}

onMounted(() => {
  loadBugs()
  loadProjects()
  loadUsers()
})
</script>