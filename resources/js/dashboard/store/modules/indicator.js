
import { event } from 'vue-gtag';

export default {
  state: {
    geoGranularity: null,
    geoOptions: [],
    formErrors: {},
    isLoading: false,
    labelAxeX: null,
    labelAxeY: null,
    indicatorData: []
  },
  mutations: {
    setIndicatorGeoGranularity(state, payload) {
      state.geoGranularity = payload
    },
    setIndicatorGeoOptions(state, payload) {
      state.geoOptions = payload;
    },
  },
  actions: {
    submitFilters({ state }, form) {

      event("fetch_indicator_data_request", {
        event_category: "fetch_indicator_data",
        event_label: "indicators_req_send",
      });

      state.isLoading = true;
      let url = "/api/dashboard/indicators";
      switch (form.geoGranularity) {
        case 1:
          url += '/provinces'
          break;
        case 2:
          url += '/zones'
        default:
          break;
      }
      state.labelAxeX = form.x;
      state.labelAxeY = form.y;
      axios.get(url, {
        params: form
      }).then(({ data }) => {
        const dates = [...new Set(data.map(x => x.date))];
        console.log('dates',dates);
        const statisticData = [];
        let totalX = 0;
        let totalY = 0;
        let averageX = 0;
        let averageY = 0;
        dates.map(value => {
          const axeX = data.find(x => x.x && x.date == value);
          const axeY = data.find(x => x.y && x.date == value);
          if (!axeY || !axeX) {
            return;
          }
          const item = {
            date: value,
            y: Number(axeY.y),
            x: Number(axeX.x)
          }
          totalY += Number(axeY.y);
          totalX += Number(axeX.x);
          statisticData.push(item);
        });
        averageX = totalX / statisticData.length;
        averageY = totalY / statisticData.length;

        statisticData.forEach(item => {
          item.moY = averageY;
          item.ecartMoY = item.y - averageY;
          item.moX = averageX;
          item.ecartMoX = item.x - averageX;
          item.prodEcart = item.ecartMoX * item.ecartMoY;
          item.ecartX2 = item.ecartMoX * item.ecartMoX;
          item.ecartY2 = item.ecartMoY * item.ecartMoY
          item.xProdY = item.x * item.y;
        });
        state.indicatorData = statisticData;

        event("fetch_indicator_data_response", {
          event_category: "fetch_indicator_data",
          event_label: "indicators",
        });
      }).catch(({response}) => {
        state.formErrors = response.data.errors
        exception(response)
      }).finally(() => {
        state.isLoading = false;
      });
    }
  }
}
