import moment from 'moment';
import { format } from 'date-fns';

export default {
  computed: {
    isSmOrMd() {
      return this.$mq == 'md' || this.$mq == 'sm';
    },
  },
  methods: {
    moment(value, local = 'en') {
      moment.locale(local);
      return moment(value);
    },
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    formatCash(n) {
      if (n == 0) return 0;
      else if (!n) {
        return null;
      }
      n = Math.abs(n);
      if (n < 1e3) return n;
      if (n >= 1e3 && n < 1e6) return +(n / 1e3).toFixed(1) + 'K';
      if (n >= 1e6 && n < 1e9) return +(n / 1e6).toFixed(1) + 'M';
      if (n >= 1e9 && n < 1e12) return +(n / 1e9).toFixed(1) + 'B';
      if (n >= 1e12) return +(n / 1e12).toFixed(1) + 'T';
    },
    formatFluxDataByMedian({ references, observations }) {
      if (!observations || !references) {
        return {
          percent: null,
          difference: null,
        };
      }
      let referenceVolume = null;
      let observationVolume = null;

      references.sort((a, b) => {
        return new Number(a.volume ?? 0) > new Number(b.volume ?? 0) ? 1 : -1;
      });
      observations.sort((a, b) => {
        return new Number(a.volume ?? 0) > new Number(b.volume ?? 0) ? 1 : -1;
      });

      const countReference = references.length;
      if (countReference > 0) {
        if (countReference % 2 == 0) {
          let index = (countReference + 1) / 2;
          index = parseInt(index);
          const volume1 = Number(references[index].volume);
          const volume2 = Number(references[index - 1].volume);
          referenceVolume = (volume1 + volume2) / 2;
        } else {
          const index = (countReference + 1) / 2;
          referenceVolume = references[index - 1].volume;
        }
      }

      const countObservation = observations.length;
      if (countObservation > 0) {
        if (countObservation % 2 == 0) {
          let index = (countObservation + 1) / 2;
          index = parseInt(index);
          const volume1 = Number(observations[index].volume);
          const volume2 = Number(observations[index - 1].volume);
          observationVolume = (volume1 + volume2) / 2;
        } else {
          const index = (countObservation + 1) / 2;
          observationVolume = observations[index - 1].volume;
        }
      }
      const difference = observationVolume - referenceVolume;

      return {
        difference,
        observationVolume,
        referenceVolume,
        percent: Math.round((difference / referenceVolume) * 100),
      };
    },
    formatFluxGeneralData(flux24DailyIn, flux24DailyOut) {
      const referencesByDateIn = flux24DailyIn.referencesByDate ?? [];
      const observationsByDateIn = flux24DailyIn.observationsByDate ?? [];

      const referencesByDateOut = flux24DailyOut.referencesByDate ?? [];
      const observationsByDateOut = flux24DailyOut.observationsByDate ?? [];

      const referencesByDate = [];
      const observationsByDate = [];
      [...referencesByDateIn, ...referencesByDateOut].map((item) => {
        const element = referencesByDate.find(
          (x) =>
            x.date == item.date &&
            x.origin == item.origin &&
            x.destination == item.destination
        );
        if (element) {
          element.volume += item.volume;
        } else {
          referencesByDate.push({
            volume: item.volume,
            date: item.date,
            origin: item.origin,
            destination: item.destination,
          });
        }
      });

      [...observationsByDateIn, ...observationsByDateOut].map((item) => {
        const element = observationsByDate.find((x) => x.date == item.date);
        if (element) {
          element.volume += item.volume;
        } else {
          observationsByDate.push({
            volume: item.volume,
            date: item.date,
            origin: item.origin,
            destination: item.destination,
          });
        }
      });
    },
    drawHorizontalChart(localData, key, ref, color, title = null) {
      const dataChart = {
        labels: localData.map((d) => d[key]),
        datasets: [
          {
            label: 'Référence',
            backgroundColor: '#33ac2e',
            borderColor: '#33ac2e',
            borderWidth: 1,
            data: localData.map((d) => d.volume_reference),
          },
          {
            label: 'Observation',
            backgroundColor: color,
            borderColor: color,
            data: localData.map((d) => d.volume),
          },
        ],
      };

      this.configBarChart2 = {
        type: 'horizontalBar',
        data: dataChart,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          legend: {
            position: 'bottom',
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: !!title,
            text: title,
            color: '#6c757d',
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
        },
      };

      if (this.barChart2[ref]) this.barChart2[ref].destroy();
      this.barChart2[ref] = new Chart(
        this.$refs[ref].getContext('2d'),
        this.configBarChart2
      );
    },
    formatDateFns(date) {
      return format(new Date(date), 'dd/MM/yyyy à HH:mm:ss');
    },
    addParamToUrl(param, value) {
      const url = new URL(window.location.href);
      url.searchParams.delete(param);
      if (value !== undefined && value !== null) {
        url.searchParams.set(param, value);
      }
      window.history.replaceState(null, null, url);
    },
    removeAllParamsFromUrl() {
      const url = new URL(window.location.href);
      url.search = '';
      window.history.replaceState(null, null, url);
    },
    userHaveRole(role) {
      return (
        this.user &&
        this.user.roles &&
        this.user.roles.find((a) => a.name == role)
      );
    },
  },
};
