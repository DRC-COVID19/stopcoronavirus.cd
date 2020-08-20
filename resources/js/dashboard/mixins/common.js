import moment from 'moment'
export default {
    methods: {
        moment(value, local = 'fr') {
            moment.locale(local);
            return moment(value);
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        formatCash(n) {
            if (!n) {
                return null;
            }
            n = Math.abs(n);
            if (n < 1e3) return n;
            if (n >= 1e3 && n < 1e6) return +(n / 1e3).toFixed(1) + "K";
            if (n >= 1e6 && n < 1e9) return +(n / 1e6).toFixed(1) + "M";
            if (n >= 1e9 && n < 1e12) return +(n / 1e9).toFixed(1) + "B";
            if (n >= 1e12) return +(n / 1e12).toFixed(1) + "T";
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
            const countReference = references.length;
            if (countReference > 0) {
                if (countReference % 2 == 0) {
                    let index = (countReference + 1) / 2;
                    index = parseInt(index);
                    const volume1 = references[index].volume;
                    const volume2 = references[index - 1].volume;
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
                    const volume1 = observations[index].volume;
                    const volume2 = observations[index - 1].volume;
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
                percent: Math.round((difference / referenceVolume) * 100)
            };
        },
        formatFluxGeneralData(flux24DailyIn, flux24DailyOut) {
            const referencesByDateIn = flux24DailyIn.referencesByDate ?? [];
            const observationsByDateIn =
                flux24DailyIn.observationsByDate ?? [];

            const referencesByDateOut = flux24DailyOut.referencesByDate ?? [];
            const observationsByDateOut =
                flux24DailyOut.observationsByDate ?? [];

            const referencesByDate = [];
            const observationsByDate = [];
            [...referencesByDateIn, ...referencesByDateOut].map((item) => {
                const element = referencesByDate.find((x) => x.date == item.date && x.origin == item.origin && x.destination == item.destination);
                if (element) {
                    element.volume += item.volume;
                } else {
                    referencesByDate.push({
                        volume: item.volume,
                        date: item.date,
                        origin: item.origin,
                        destination: item.destination
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
                        destination: item.destination
                    });
                }
            });
        }
    }

}