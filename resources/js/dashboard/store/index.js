import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import flux from './modules/flux';
import hospital from './modules/hospital';
import nav from './modules/nav';
import epidemic from './modules/epidemic';
import indicator from './modules/indicator';
import app from './modules/app';
import changeLog from './modules/changeLog';
import form from './modules/form';
import formFieldType from './modules/formFieldType';
import formField from './modules/formField';
import formStep from './modules/formStep';
import hospitalSituation from './modules/hospitalSituation';
import completedForm from './modules/completedForm';
import completedFormHistory from './modules/completedFormHistory';
import township from './modules/township';
import bugTracker from './modules/bugTracker';
import adminUser from './modules/adminUser';
import notification from './modules/notification';
import bookmark from './modules/bookmark';
import reporting from './modules/reporting';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  modules: {
    app,
    bugTracker,
    auth,
    flux,
    hospital,
    nav,
    epidemic,
    indicator,
    changeLog,
    form,
    formFieldType,
    formField,
    formStep,
    hospitalSituation,
    completedForm,
    completedFormHistory,
    township,
    adminUser,
    notification,
    bookmark,
    reporting,
  },
});
