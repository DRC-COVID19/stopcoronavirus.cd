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
    bugTracker__addTask ({ commit, dispatch }, { task }) {
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
      formData.append('file', attachements[0].original_filename)
      formData.append('name', +new Date().getDate())
      formData.append('url', attachements[0].secure_url)
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
          })
          .catch(response => {
            reject(response)
          })
      })
    }
  }
}
