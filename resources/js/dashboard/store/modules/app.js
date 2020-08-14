export default {
  state: {
    healthZones: []
  },
  actions: {
    getHealthZone({ state }) {
      axios.get("api/dashboard/health-zones")
        .then(({ data }) => {
          state.healthZones = data;
        });
    }
  }
}