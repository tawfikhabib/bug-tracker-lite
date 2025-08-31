import { defineStore } from 'pinia'
import axios from 'axios'

export const useBugStore = defineStore('bug', {
  state: () => ({
    bugs: [],
  }),
  actions: {
    async load(page = 1, filters = {}) {
      const { data } = await axios.get('/api/bugs', {
        params: { page, ...filters }
      })
      this.bugs = data.data
      this.pagination = data.meta
    },
  },
})
