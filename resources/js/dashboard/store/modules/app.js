import * as turf from "@turf/turf";

export default {
  state: {
    healthZones: [],
    healthZoneGeojsonCentered: null,
    healthZoneGeojson: null,
    healthProvinceGeojson: null,
    healthProvinceGeojsonCentered: null,
    isLoading: false,
  },
  mutations: {
    setIsLoading(state, payload) {
      state.isLoading = payload;
    }
  },
  actions: {
    getHealthZone({ state }) {
      axios.get("api/dashboard/health-zones")
        .then(({ data }) => {
          state.healthZones = data;
        });
    },
    loadSource({ state }) {
      axios
        .get(
          `${location.protocol}//${location.host}/storage/geojson/rdc_micro_zonesdedante_regroupees.json`,
          {
            headers: {
              Accept: "application/json",
            },
          }
        )
        .then(({ data }) => {
          state.healthZoneGeojson = data;
          const features = data.features.map((item) => {
            let polygone = null;
            switch (item.geometry.type) {
              case "MultiPolygon":
                polygone = turf.multiPolygon(item.geometry.coordinates);
                break;
              case "Polygon":
                polygone = turf.polygon(item.geometry.coordinates);
                break;
              default:
                break;
            }
            const feature = turf.centerOfMass(polygone);
            const area = turf.area(polygone);
            console.log('zone', {
              area,
              name: item.properties['Zone+Peupl']
            });
            feature.properties = item.properties;
            feature.properties.area=area;
            return feature;
          });
          state.healthZoneGeojsonCentered = {
            type: "FeatureCollection",
            features: features,
          };
        });

      axios
        .get(
          `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`,
          {
            headers: {
              Accept: "application/json",
            },
          }
        )
        .then(({ data }) => {
          state.healthProvinceGeojson = data;
          const features = data.features.map((item) => {
            let polygone = null;
            switch (item.geometry.type) {
              case "MultiPolygon":
                polygone = turf.multiPolygon(item.geometry.coordinates);
                break;
              case "Polygon":
                polygone = turf.polygon(item.geometry.coordinates);
                break;
              default:
                break;
            }
            const feature = turf.centerOfMass(polygone);
            const area = turf.area(polygone);
            console.log('zone', {
              area,
              name: item.properties.name
            });
            feature.properties = item.properties;
            feature.properties.area = area;
            return feature;
          });
          state.healthProvinceGeojsonCentered = {
            type: "FeatureCollection",
            features: features,
          };
        });
    },
  }
}