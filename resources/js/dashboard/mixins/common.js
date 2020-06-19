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
    }

}