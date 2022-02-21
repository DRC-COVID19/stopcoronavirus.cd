export default {
  state: {},
  mutations: {},
  actions: {
    completedFormStore (_, payload) {
      return new Promise((resolve, reject) => {
        axios.post(`/api/dashboard/completed_forms`, payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    completedFormUpdate (_, payload) {
      return new Promise((resolve, reject) => {
        axios.put(`/api/dashboard/completed_forms/${payload.id}`, payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    }
  }
}
