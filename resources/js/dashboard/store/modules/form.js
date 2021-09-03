export default{
  actions:{
    formShow (_, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/dashboard/forms/${payload.id}`)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
  }
}
