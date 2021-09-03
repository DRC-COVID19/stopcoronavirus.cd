export default {
  actions: {
    formFieldStore (_, payload) {
      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/form-fields', payload)
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
