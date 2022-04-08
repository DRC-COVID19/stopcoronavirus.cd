import { ASANA_API_URL, ASANA_TOKEN } from '../../config/env'
import axios from 'axios'

const formData = new FormData()
const Authorization = `Bearer ${ASANA_TOKEN}`
const axiosOptions = {
  headers: {
    'Content-Type': 'application/json',
    Authorization
  }
}
export default {
  state: {
    bugTracker: null,
    isCreating: false
  },

  mutation: {
    SET_TASK (state, payload) {
      state.bugTracker = payload
    }
  },
  actions: {
    bugTracker__addTask ({ commit, dispatch }, { task, attachements }) {
      commit('SET_TASK', false)
      return new Promise((resolve, reject) => {
        axios
          .post(
            `${ASANA_API_URL}/tasks`,
            {
              data: task
            },
            axiosOptions
          )
          .then(({ data }) => {
            resolve(data)
            commit('SET_TASK', data)
            // dispatch('bugTracker__addAttachementsToTask', attachements)
          })
          .catch(response => {
            reject(response)
          })
      })
    },
    bugTracker__addAttachementsToTask (
      { commit, dispatch },
      { task, attachements }
    ) {
      const url =
        'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.nameslook.com%2Fasna%2F&psig=AOvVaw0-UIrObDMBLIU2Rv-TEdgd&ust=1649521414568000&source=images&cd=vfe&ved=2ahUKEwivsv6g8IT3AhWEAWMBHZexClgQr4kDegUIARDrAQ'

      formData.append('file', 'test.png')
      formData.append('name', 'test')
      formData.append('url', url)
      formData.append('resource_subtype', 'external')
      return new Promise((resolve, reject) => {
        axios({
          method: 'post',
          url: `${ASANA_API_URL}/tasks/${task.gid}/attachments`,
          data: formData,
          headers: { 'Content-Type': 'multipart/form-data', Authorization }
        })
          .then(({ data }) => {
            resolve(data)
            alert('esimbi')
          })
          .catch(response => {
            alert('esimbi te')
            reject(response)
          })
      })
    }
  }
}
