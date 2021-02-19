<template>
  <b-container fluid>
    <b-row>
      <b-col cols="12">
        <h3>1. Habitude de mobilité</h3>
      </b-col>

      <b-col cols="12">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité Générale entrant dans la commune de la Gombe
          </div>
          <div class="d-flex justify-content-center">
            <div class="flux-chart-lenged-item mr-3">
              <span
                class="flux-chart-lenged-color"
                :style="{ background: '#225ea8' }"
              ></span>
              <span class="flux-chart-lenged-text">Jours fériés</span>
            </div>
            <div class="flux-chart-lenged-item">
              <span
                :style="{ background: '#88419d' }"
                class="flux-chart-lenged-color"
              ></span>
              <span class="flux-chart-lenged-text">Dimanche</span>
            </div>
            <div class="flux-chart-lenged-item ml-3">
              <span
                :style="{ background: '#339966' }"
                class="flux-chart-lenged-color"
              ></span>
              <span class="flux-chart-lenged-text">Date covid</span>
            </div>
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_1"
              id="rapport_1"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="12">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité Professionelle entrant dans la commune de la Gombe
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_1_3"
              id="rapport_1_3"
            ></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <h3>2. Provenance par commune</h3>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Zones de provenance de la mobilité (en moyenne mensuelle) entrant
            dans la commune de la Gombe <br />
            du 18-03-2020 au 30-06-2020
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_2"
              id="rapport_2"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Zones de provenance de la mobilité (en moyenne mensuelle) entrant
            dans la commune de la Gombe <br />
            du 01-07-2020 au 31-12-2020
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_2_1"
              id="rapport_2_1"
            ></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <h3>3. Comparative de mobilité des communes en fonction des heures</h3>
        <div class="mb-3">
          <div class="flux-chart-lenged-item mr-3">
            <span
              class="flux-chart-lenged-color"
              :style="{ background: '#225ea8' }"
            ></span>
            <span class="flux-chart-lenged-text"
              >Avant le couvre feu du 17-11-2020 au 17-12-2020</span
            >
          </div>
          <div class="flux-chart-lenged-item">
            <span
              :style="{ background: '#E31A1C' }"
              class="flux-chart-lenged-color"
            ></span>
            <span class="flux-chart-lenged-text"
              >Après le couvre feu du 18-12-2020 au 31-12-2020</span
            >
          </div>
        </div>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne entrant par heure dans la Commune Gombe
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3"
              id="rapport_3"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne sortant par heure dans la Commune Gombe
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_bis"
              id="rapport_3_bis"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne entrant par heure dans la Commune Gombe Limete
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_1"
              id="rapport_3_1"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne sortant par heure dans la Commune Gombe Limete
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_1_bis"
              id="rapport_3_1_bis"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne entrant par heure dans la Commune Gombe Ndjili
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_2"
              id="rapport_3_2"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne sortant par heure dans la Commune Gombe Ndjili
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_2_bis"
              id="rapport_3_2_bis"
            ></canvas>
          </div>
        </b-card>
      </b-col>

      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne entrant par heure dans la Commune Gombe Binza Meteo
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_3"
              id="rapport_3_3"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Mobilité moyenne sortant par heure dans la Commune Gombe Binza Meteo
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_3_3_bis"
              id="rapport_3_3_bis"
            ></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <h3>4. Résidence par commune</h3>
      </b-col>
      <b-col cols="12">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Evolution de présence de résidents
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_4"
              id="rapport_4"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="12">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Présence moyenne dans les communes de la ville de Kinshasa en 1 ans
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_4_3"
              id="rapport_4_3"
            ></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <h3>6. Fréquentation des marchés</h3>
      </b-col>
      <b-col>
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title"></div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_6"
              id="rapport_6"
            ></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <h3>7. Flux migratoire inter-province et Provenance</h3>
      </b-col>
      <b-col cols="12">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Flux migratoire entrant dans la ville de Kinshasa
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_7_1"
              id="rapport_7_1"
            ></canvas>
          </div>
        </b-card>
      </b-col>
      <b-col cols="12">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">
            Flux migratoire sortant de la ville de Kinshasa
          </div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_7_2"
              id="rapport_7_2"
            ></canvas>
          </div>
        </b-card>
      </b-col>

      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">Provenance avant Covid du 01-02-2020 au 18-03-2020</div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_7_3"
              id="rapport_7_3"
            ></canvas>
          </div>
        </b-card>
      </b-col>

      <b-col cols="6">
        <b-card no-body class="cardtype1 mb-3 p-2">
          <div class="general-top-title">Provenance après Covid du 18-03-2020 au 31-12-2020</div>
          <div class="chart-container">
            <canvas
              height="200"
              width="100vh"
              ref="rapport_7_4"
              id="rapport_7_4"
            ></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { PALETTE } from "../config/env";
import * as d3 from "d3";
export default {
  data() {
    return {
      configBarChart: {},
      barChart: {},
      lineCharts: {},
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.drawRapport2();
      this.drawRapport1();
      this.drawRapport3();
      this.drawRapport4();
      this.drawRapport6();
      this.drawRapport7();
    });
  },
  methods: {
    drawRapport1() {
      axios
        .get("api/flux-test/data-1")
        .then(({ data }) => {
          const pointColor = [];
          const pointRadius = [];
          const holyday = [
            "2020-01-01",
            "2020-01-04",
            "2020-01-16",
            "2020-01-17",
            "2020-04-30",
            "2020-05-01",
            "2020-05-17",
            "2020-06-30",
            "2020-08-01",
            "2020-12-25",
          ];
          const covid = [
            "2020-03-18",
            "2020-07-22",
            "2020-12-16",
            "2020-12-20",
          ];

          const school = [
            {
              date: moment("2020-10-12"),
              name: "Rentrée scolaire",
              color: PALETTE.dash_green,
            },
            {
              date: moment("2020-12-15"),
              name: "Rentrée académique",
              color: PALETTE.dash_green,
            },
          ];
          data.map((item) => {
            if (covid.includes(item.date)) {
              pointColor.push("#339966");
              pointRadius.push(3);
              return;
            }
            if (holyday.includes(item.date)) {
              pointColor.push(PALETTE.flux_in_color);
              pointRadius.push(2);
              return;
            }
            if (moment(item.date).day() == 0) {
              pointColor.push(PALETTE.flux_out_color);
              pointRadius.push(2);
              return;
            }
            pointColor.push(PALETTE.flux_presence);
            pointRadius.push(1);
          });
          this.drawLineChart(
            data,
            PALETTE.flux_presence,
            "rapport_1",
            pointColor,
            pointRadius,
            school
          );
        })
        .catch((error) => {
          console.log("error", error);
        });

      axios
        .get("api/flux-test/data-1?activity=work")
        .then(({ data }) => {
          const pointColor = [];
          const pointRadius = [];
          data.map((item) => {
            if (moment(item.date).day() == 0) {
              pointColor.push(PALETTE.flux_out_color);
              pointRadius.push(2);
              return;
            }
            pointColor.push(PALETTE.flux_presence);
            pointRadius.push(1);
          });
          this.drawLineChart(
            data,
            PALETTE.flux_presence,
            "rapport_1_3",
            pointColor,
            pointRadius
          );
        })
        .catch((error) => {
          console.log("error", error);
        });
    },
    drawRapport2() {
      const ref = "rapport_2",
        height = 300;
      axios
        .get("api/flux-test/data-2?start=2020-03-18&end=2020-06-30")
        .then(({ data }) => {
          this.drawBarChart(
            data.slice(0, 10),
            PALETTE.flux_presence,
            ref,
            height
          );
        })
        .catch((error) => {
          console.log(error);
        });
      axios
        .get("api/flux-test/data-2?start=2020-07-01&end=2020-08-07")
        .then(({ data }) => {
          this.drawBarChart(
            data.slice(0, 10),
            PALETTE.flux_presence,
            "rapport_2_1",
            height
          );
        })
        .catch((error) => {
          console.log(error);
        });
    },

    drawRapport3() {
      const data_1 = axios.get("api/flux-test/data-3?zone=Gombe");
      const data_1_bis = axios.get("api/flux-test/data-3-out?zone=Gombe");
      const data_2 = axios.get("api/flux-test/data-3?zone=Limete");
      const data_2_bis = axios.get("api/flux-test/data-3-out?zone=Limete");
      const data_3 = axios.get("api/flux-test/data-3?zone=Ndjili");
      const data_3_bis = axios.get("api/flux-test/data-3-out?zone=Ndjili");

      const data_4 = axios.get("api/flux-test/data-3?zone=Binza Meteo");
      const data_4_bis = axios.get("api/flux-test/data-3-out?zone=Binza Meteo");

      Promise.all([data_1])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_1_bis])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_bis", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_2])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_1", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_2_bis])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_1_bis", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_3])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_2", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_3_bis])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_2_bis", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_4])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_3", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });

      Promise.all([data_4_bis])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormattedBefore = response[0].data.before.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));
            const dataFormattedAfter = response[0].data.after.map((item) => ({
              date: item.date,
              x: moment(item.date, "hh:mm:ss"),
              y: item.volume,
            }));

            // dataFormatted.sort((a, b) => {
            //   return a.x.toDate() - b.x.toDate();
            // });

            dataset.push({
              label: "Avant couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormattedBefore,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
            dataset.push({
              label: "Après couvre feu",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormattedAfter,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }

          this.drawLineChart2(dataset, "rapport_3_3_bis", [], 200, true);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    drawRapport4() {
      const data_1 = axios.get("api/flux-test/data-4?zone=Gombe");
      const data_2 = axios.get("api/flux-test/data-4?zone=Limete");
      const data_3 = axios.get("api/flux-test/data-4?zone=Ndjili");
      const data_4 = axios.get("api/flux-test/data-4?zone=Binza Meteo");

      Promise.all([data_1, data_2, data_3, data_4])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const pointColor = [];
            const pointRadius = [];
            const dataFormatted = response[0].data.map((item) => {
              if (moment(item.date).day() == 0) {
                pointColor.push(PALETTE.flux_out_color);
                pointRadius.push(2);
              } else {
                pointColor.push(PALETTE.flux_presence);
                pointRadius.push(1);
              }
              return {
                date: item.date,
                x: moment(item.date),
                y: item.volume,
              };
            });

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Gombe",
              fill: false,
              pointBackgroundColor: pointColor,
              pointBorderColor: pointColor,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: pointRadius,
              lineTension: 0.08,
            });
          }
          if (response[1]) {
            const dataFormatted = response[1].data.map((item) => ({
              date: item.date,
              x: moment(item.date),
              y: item.volume,
            }));

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Limete",
              fill: false,
              pointBackgroundColor: PALETTE.flux_out_color,
              pointBorderColor: PALETTE.flux_out_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_out_color,
              backgroundColor: PALETTE.flux_out_color,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }
          if (response[2]) {
            const dataFormatted = response[2].data.map((item) => ({
              date: item.date,
              x: moment(item.date),
              y: item.volume,
            }));

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Ndjili",
              fill: false,
              pointBackgroundColor: PALETTE.flux_in_color,
              pointBorderColor: PALETTE.flux_in_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }
          if (response[3]) {
            const dataFormatted = response[3].data.map((item) => ({
              date: item.date,
              x: moment(item.date),
              y: item.volume,
            }));

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Binza Meteo",
              fill: false,
              pointBackgroundColor: PALETTE.dash_green,
              pointBorderColor: PALETTE.dash_green,
              pointHitRadius: 2,
              borderColor: PALETTE.dash_green,
              backgroundColor: PALETTE.dash_green,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }
          this.drawLineChart2(dataset, "rapport_4");
        })
        .catch((error) => {
          console.log(error);
        });

      axios
        .get("api/flux-test/data-4-1")
        .then(({ data }) => {
          this.drawBarChart(data, PALETTE.flux_presence, "rapport_4_3", 600);
        })
        .catch((error) => {
          console.log("error", error);
        });
    },
    drawRapport6() {
      const data_1 = axios.get(
        "api/flux-test/data-6?zone=Wenze Muselu/Gambela"
      );
      const data_2 = axios.get("api/flux-test/data-6?zone=Marché central");
      const data_3 = axios.get("api/flux-test/data-6?zone=Marché BAYAKA");

      Promise.all([data_1, data_2, data_3])
        .then((response) => {
          const dataset = [];
          if (response[0]) {
            const dataFormatted = response[0].data.map((item) => {
              return {
                date: item.date,
                x: moment(item.date),
                y: item.volume,
              };
            });

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Wenze Muselu/Gambela",
              fill: false,
              pointBackgroundColor: PALETTE.flux_presence,
              pointBorderColor: PALETTE.flux_presence,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_presence,
              backgroundColor: PALETTE.flux_presence,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }
          if (response[1]) {
            const dataFormatted = response[1].data.map((item) => ({
              date: item.date,
              x: moment(item.date),
              y: item.volume,
            }));

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Marché central",
              fill: false,
              pointBackgroundColor: PALETTE.flux_out_color,
              pointBorderColor: PALETTE.flux_out_color,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_out_color,
              backgroundColor: PALETTE.flux_out_color,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            });
          }
          if (response[2]) {
            const pointColor = [];
            const pointRadius = [];
            const holyday = [
              "2020-01-01",
              "2020-01-04",
              "2020-01-16",
              "2020-01-17",
              "2020-04-30",
              "2020-05-01",
              "2020-05-17",
              "2020-06-30",
              "2020-08-01",
              "2020-12-25",
            ];
            const dataFormatted = response[2].data.map((item) => {
              if (moment(item.date).day() == 0) {
                pointColor.push(PALETTE.flux_out_color);
                pointRadius.push(2);
              } else if (holyday.includes(item.date)) {
                pointColor.push(PALETTE.flux_in_color);
                pointRadius.push(2);
              } else {
                pointColor.push(PALETTE.flux_presence);
                pointRadius.push(1);
              }

              return {
                date: item.date,
                x: moment(item.date),
                y: item.volume,
              };
            });

            dataFormatted.sort((a, b) => {
              return a.x.toDate() - b.x.toDate();
            });
            dataset.push({
              label: "Marché BAYAKA",
              fill: false,
              pointBackgroundColor: pointColor,
              pointBorderColor: pointColor,
              pointHitRadius: 2,
              borderColor: PALETTE.flux_in_color,
              backgroundColor: PALETTE.flux_in_color,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: pointRadius,
              lineTension: 0.08,
            });
          }
          this.drawLineChart2(dataset, "rapport_6");
        })
        .catch((error) => {
          console.log(error);
        });
    },
    drawRapport7() {
      axios
        .get("api/flux-test/data-7-in")
        .then(({ data }) => {
          this.drawLineChart(data, PALETTE.flux_presence, "rapport_7_1");
        })
        .catch((error) => {
          console.log("error", error);
        });
      axios
        .get("api/flux-test/data-7-out")
        .then(({ data }) => {
          this.drawLineChart(data, PALETTE.flux_presence, "rapport_7_2");
        })
        .catch((error) => {
          console.log("error", error);
        });

      axios
        .get(
          "api/flux-test/data-7-top-in?date_start=2020-02-01&date_end=2020-03-18"
        )
        .then(({ data }) => {
          this.drawBarChart(data, PALETTE.flux_presence, "rapport_7_3", 500);
        })
        .catch((error) => {
          console.log("error", error);
        });

      axios
        .get(
          "api/flux-test/data-7-top-in?date_start=2020-03-19&date_end=2020-12-31"
        )
        .then(({ data }) => {
          this.drawBarChart(data, PALETTE.flux_presence, "rapport_7_4", 500);
        })
        .catch((error) => {
          console.log("error", error);
        });
    },
    drawLineChart(
      data,
      color,
      ref,
      pointColor = null,
      pointRadius = null,
      annotations = []
    ) {
      const dataFormatted = data.map((item) => ({
        date: item.date,
        x: moment(item.date),
        y: item.volume,
      }));

      dataFormatted.sort((a, b) => {
        return a.x.toDate() - b.x.toDate();
      });
      this.configBarChart[ref] = {
        type: "line",
        data: {
          // labels: data.map(x => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              pointBackgroundColor: pointColor || color,
              pointBorderColor: pointColor || color,
              pointHitRadius: 2,
              borderColor: color,
              backgroundColor: color,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: pointRadius || 1,
              lineTension: 0.08,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
          title: {
            display: false,
            text: "",
          },
          annotation: {
            annotations: annotations.map((item, index) => {
              return {
                id: "line" + index,
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: new Date(item.date),
                borderColor: item.color,
                borderWidth: 2,
                label: {
                  content: item.name,
                  enabled: true,
                  position: "top",
                  font: {
                    size: 8,
                  },
                },
              };
            }),
          },
          plugins: {
            crosshair: {
              line: {
                color: "#F66", // crosshair line color
                width: 1, // crosshair line width
                dashPattern: [5, 5], // crosshair line dash pattern
              },
              zoom: {
                enabled: true, // enable zooming
                zoomboxBackgroundColor: "rgba(66,133,244,0.2)", // background color of zoom box
                zoomboxBorderColor: "#48F", // border color of zoom box
                zoomButtonText: "Reset Zoom", // reset zoom button text
                zoomButtonClass: "reset-zoom", // reset zoom button class
              },
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
          tooltips: {
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                let titleFormat = this.moment(a[0].xLabel).format("DD.MM.Y");
                return titleFormat;
              },

              label: (i, d) => {
                return (
                  d.datasets[i.datasetIndex].label +
                  ": " +
                  this.formatCash(i.yLabel)
                );
              },
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                // id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                time: {
                  unit: "day",
                  // unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                    hour: "HH:mm",
                    minute: "HH:mm",
                  },
                },
                ticks: {
                  fontSize: 9,
                  major: {
                    enabled: true,
                    fontStyle: "bold",
                    fontColor: PALETTE.flux_in_color,
                    fontSize: 12,
                  },
                },
              },
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  fontSize: 9,
                  callback: (value) => {
                    return this.formatCash(value);
                  },
                },
                scaleLabel: {
                  display: false,
                  labelString: "Pourcentage",
                  fontSize: 9,
                },
              },
            ],
          },
        },
      };

      let reference = this.$refs[ref];
      if (this.lineCharts[ref]) this.lineCharts[ref].destroy();
      this.lineCharts[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      reference.style.height = "200px";
      reference.style.maxHeight = "200px";
    },
    drawLineChart2(
      datasets,
      ref,
      annotations = [],
      height = 400,
      isTime = false
    ) {
      this.configBarChart[ref] = {
        type: "line",
        data: {
          // labels: data.map(x => new Date(x.date)),
          datasets: datasets,
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: true,
          },
          title: {
            display: false,
            text: "",
          },
          annotation: {
            annotations: annotations.map((item, index) => {
              return {
                id: "line" + index,
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: new Date(item.date),
                borderColor: item.color,
                borderWidth: 2,
                label: {
                  content: item.name,
                  enabled: true,
                  position: "top",
                  font: {
                    size: 8,
                  },
                },
              };
            }),
          },
          plugins: {
            crosshair: {
              line: {
                color: "#F66", // crosshair line color
                width: 1, // crosshair line width
                dashPattern: [5, 5], // crosshair line dash pattern
              },
              zoom: {
                enabled: true, // enable zooming
                zoomboxBackgroundColor: "rgba(66,133,244,0.2)", // background color of zoom box
                zoomboxBorderColor: "#48F", // border color of zoom box
                zoomButtonText: "Reset Zoom", // reset zoom button text
                zoomButtonClass: "reset-zoom", // reset zoom button class
              },
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
          tooltips: {
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                let titleFormat = this.moment(a[0].xLabel).format("DD.MM.Y");
                return titleFormat;
              },

              label: (i, d) => {
                return (
                  d.datasets[i.datasetIndex].label +
                  ": " +
                  this.formatCash(i.yLabel)
                );
              },
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                // id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                time: {
                  unit: isTime ? "hour" : "day",
                  // unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                    hour: "HH:mm",
                    minute: "HH:mm",
                  },
                },
                ticks: {
                  fontSize: 9,
                  major: {
                    enabled: true,
                    fontStyle: "bold",
                    fontColor: PALETTE.flux_in_color,
                    fontSize: 12,
                  },
                },
              },
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  fontSize: 9,
                  callback: (value) => {
                    return this.formatCash(value);
                  },
                },
                scaleLabel: {
                  display: false,
                  labelString: "Volume",
                  fontSize: 9,
                },
              },
            ],
          },
        },
      };

      let reference = this.$refs[ref];
      if (this.lineCharts[ref]) this.lineCharts[ref].destroy();
      this.lineCharts[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      reference.style.height = `${height}px`;
      reference.style.maxHeight = `${height}px`;
    },
    drawBarChart(data, color, ref, height) {
      let localData = [...data];
      const total = localData.reduce((a, b) => {
        return a + Number(b.volume);
      }, 0);

      console.log(ref, total);

      this.configBarChart[ref] = {
        type: "horizontalBar",
        data: {
          labels: localData.map((x) => x.origin),
          datasets: [
            {
              // label: "Observation",
              backgroundColor: PALETTE.flux_presence,
              borderColor: PALETTE.flux_presence,
              barThickness: 17,
              data: localData.map((x) => x.volume),
            },
          ],
        },
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: false,
            text: "",
            fontSize: 15,
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 11,
                  callback: (value, index, values) => {
                    const sign = value < 0 ? "-" : "";
                    return `${sign}${this.formatCash(value)}`;
                  },
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 11,
                  callback: function (label, index, labels) {
                    const value = data.find((x) => x.origin == label);
                    if (value && value.volume) {
                      const percent = (value.volume / total) * 100;
                      return `${label} (${Math.round(percent)}%)`;
                    } else {
                      return label;
                    }
                  },
                },
              },
            ],
          },
          plugins: {
            crosshair: false,
          },
        },
      };
      const reference = this.$refs[ref];
      if (!reference) {
        return;
      }
      if (this.barChart[ref]) this.barChart[ref].destroy();
      this.barChart[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      this.configBarChart[ref].height = height;
      reference.style.height = `${height}px`;
      reference.style.maxHeight = `${height}px`;
    },
  },
};
</script>
<style scoped lang='scss'>
.flux-chart-lenged-color {
  display: inline-block;
  height: 15px;
  width: 15px;
}
.flux-chart-lenged-item {
  &:hover {
    cursor: pointer;
    opacity: 0.7;
  }
}
.flux-chart-lenged-text {
  font-size: 0.8rem;
}
</style>
