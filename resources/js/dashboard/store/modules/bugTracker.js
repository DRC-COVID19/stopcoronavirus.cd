import { ASANA_API_URL, ASANA_TOKEN } from '../../config/env'
import axios from 'axios'
const axiosOptions = {
  headers: {
    'Content-Type': 'application/json',
    Authorization: `Bearer ${ASANA_TOKEN}`
  }
}
export default {
  state: {
    bugTracker: null
  },

  mutation: {},
  actions: {
    bugTracker__store (__, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post(
            `${ASANA_API_URL}/tasks`,
            {
              data: payload.data
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
    }
  }
}
