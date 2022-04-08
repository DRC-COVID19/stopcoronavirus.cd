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
    bugTracker__addTask (__, { task, attachements }) {
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
            const { gid } = data
            // axiosOptions.headers['Content-Type'] = 'multipart/form-data'
            // return new Promise((resolve, reject) => {
            //   axios
            //     .post(
            //       `${ASANA_API_URL}/tasks/${gid}/attachments`,
            //       {
            //         file: attachements.upload.filename,
            //         name: attachements.upload.filename,
            //         resource_subtype: 'external',
            //         url: attachements.dataURL
            //       },
            //       axiosOptions
            //     )
            //     .then(({ data }) => {
            //       resolve(data)
            //     })
            //     .catch(response => {
            //       reject(response)
            //     })
            // })
          })
          .catch(response => {
            reject(response)
          })
      })
    },
    bugTracker__addAttachementsToTask () {

    }
  }
}
