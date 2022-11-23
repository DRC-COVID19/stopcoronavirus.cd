<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse h-100" no-gutterse>
      <b-col cols="12" md="4" class="mt-3">
        <b-alert
          :show="showWarning"
          dismissible
          fade
          variant="danger"
          class="mx-3 mt-3 alert"
          @dismiss-count-down="countDownChanged"
        >
          {{ WarningMessageCreate }}
        </b-alert>
        <b-sidebar
          id="sidebar-right"
          right
          bg-variant="white"
          width="25rem"
          backdrop
          :no-close-on-route-change="true"
          shadow
          backdrop-variant="transparent"
        >
          <CreateSituation
            @onUpdateSituation="updateSit"
            @onCancelUpdate="cancelUpdate"
            @onCreateSituation="createSituation"
            :isSituationAdded="isSituationAdded"
            :isSituationUpdated="isSituationUpdated"
            :formToPopulate="formToPopulate"
            :errors="errors"
          />
          <template #header="{ hide }" fluid>
            <div
              class="w-100 d-flex bg-white align-items-center justify-content-between py-0 px-0"
            >
              <h2 class="h2">
                {{
                  Object.keys(formToPopulate).length !== 0
                    ? 'Modification de la Situation'
                    : 'Nouvelle Situation'
                }}
              </h2>
              <b-button
                size="sm"
                class="btn-circle btn-xl"
                variant="outline-danger"
                @click="hide"
                >X</b-button
              >
            </div>
          </template>
        </b-sidebar>
      </b-col>
      <b-col cols="12" md="12" class="h-100">
        <div class="ml-2">
          <Header :title="title" :iconClass="iconClass" />
        </div>

        <div class="hide-waiting" v-if="isUpdating"></div>
        <ListSituation
          @onDeleteSituation="deleteSituation"
          :situations="situations"
          @onSearch="search"
          :isLoading="isLoading"
          @onEditSituation="editSituation"
          @onGetSituations="getSituations"
          @openToogle="openToogle"
        />
        <b-col cols="12" class="d-flex justify-content-end">
          <b-pagination
            page-class="text-blue-dash"
            v-model="situationMeta.current_page"
            :per-page="situationMeta.per_page"
            :total-rows="situationMeta.total"
            @change="getSituationList"
            :disabled="isUpdating"
          ></b-pagination>
        </b-col>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Header from '../components/Header';
import Waiting from '../../../components/Waiting';
import ListSituation from './components/ListSituation';
import CreateSituation from './components/CreateSituation';
import moment from 'moment';
export default {
  components: {
    Header,
    ListSituation,
    CreateSituation,
    Waiting,
  },
  mounted() {
    this.getSituationList();
  },
  data() {
    return {
      title: 'Situation épidémiologique',
      iconClass: 'fas fa-virus',
      isSituationAdded: false,
      isSituationUpdated: false,
      isSituationDeleted: false,
      isLoading: true,
      errors: {},
      showSuccess: 0,
      showWarning: 0,
      WarningMessageCreate: '',
      timeOut: 3,
      situations: {},
      isUpdating: false,
      formToPopulate: {},
      currentPage: 1,
    };
  },
  computed: {
    situationMeta() {
      if (!this.situations.meta) {
        return {
          current_page: 1,
          from: 1,
          last_page: 1,
          path: '#',
          per_page: 1,
          to: 1,
          total: 1,
        };
      }
      return this.situations.meta;
    },
  },
  methods: {
    getSituations() {
      this.getSituationList();
    },
    search(filter) {
      this.isLoading = true;
      const filterDate = moment(filter).format('YYYY-MM-DD');
      if (filter !== '') {
        axios
          .get('api/pandemic-stats/filter?date=' + filterDate)
          .then(({ data }) => {
            this.situations = data;
            this.isLoading = false;
            console.log('this.situations', this.situations);
          })
          .catch(({ response }) => {
            this.$gtag.exception(response);
            this.isLoading = false;
          });
      } else {
        this.getSituationList();
        this.isLoading = false;
      }
    },
    countDownChangedS(showSuccess) {
      this.showSuccess = showSuccess;
    },
    countDownChanged(showWarning) {
      this.showWarning = showWarning;
    },
    showAlert() {
      this.showWarning = this.timeOut;
    },
    openToogle(state) {
      this.formToPopulate = {};
      this.updating = state;
    },
    deleteSituation(currentSituationId) {
      this.errors = {};
      axios
        .delete('/api/pandemic-stats/' + currentSituationId)
        .then(() => {
          this.getSituationList;
          this.isSituationDeleted = true;
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });
    },
    updateSit(form) {
      this.isLoading = true;
      this.isSituationUpdated = false;
      axios
        .put('/api/pandemic-stats/' + form.id, {
          confirmed: form.confirmed,
          local: form.local,
          imported: form.imported,
          sick: form.sick,
          seriously: form.seriously,
          healed: form.healed,
          dead: form.dead,
          last_update: form.last_update,
        })
        .then(() => {
          this.isSituationUpdated = true;
          this.showSuccess = this.timeOut;
          this.isSituationUpdated = true;
          this.isLoading = false;
          this.isUpdating = false;
          this.getSituationList();
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });
    },
    createSituation(form) {
      this.isSituationAdded = false;
      this.isLoading = true;
      this.errors = {};
      axios
        .post('/api/pandemic-stats', {
          confirmed: form.confirmed,
          local: form.local,
          imported: form.imported,
          sick: form.sick,
          seriously: form.seriously,
          healed: form.healed,
          dead: form.dead,
          last_update: form.last_update,
        })
        .then(() => {
          this.isSituationAdded = true;
          this.isUpdating = false;
          this.isLoading = false;
          this.showSuccess = this.timeOut;
          this.getSituationList();
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
          this.$gtag.exception(response);
          this.showAlert();
          this.isLoading = false;
          this.WarningMessageCreate = response.data.message;
        });
    },
    editSituation(form) {
      this.isUpdating = true;
      this.errors = {};
      this.formToPopulate = form;
    },
    getSituationList(page = 1) {
      this.isLoading = true;
      axios
        .get('/api/pandemic-stats', {
          params: { page },
        })
        .then(({ data }) => {
          this.situations = data;
          this.isLoading = false;
        })
        .catch((e) => console.log(e));
    },
    cancelUpdate() {
      this.errors = {};
      this.isUpdating = false;
      this.formToPopulate = {};
    },
    switchPage(page) {
      this.getSituationList(page);
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';
.mask {
  position: absolute;
  z-index: 100;
  background-color: $dash-background;
  opacity: 0.5;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.alert {
  position: absolute;
  z-index: 100;
  opacity: 0.6;
  top: 0;
  right: 0;
  width: 100%;
}
</style>
