<template>
  <b-container class="form-response">
    <b-row>
      <b-col cols="12" class="">
        <b-card class="infos-card default-card">
          <div class="btn-export-wrapper">
            <export-excel :fetch="uploadFile" :name="fileName">
              <b-button
                :disabled="isFileLoading"
                class="button-icon text-sm btn-export"
                variant="primary"
                size="sm"
              >
                <div class="text-center text-danger" v-if="isFileLoading">
                  <b-spinner label="Spinning"></b-spinner>
                </div>
                <div v-else>
                  <small>Exporter</small>
                  <i class="fa fa-file-excel ml-1" aria-hidden="true"></i>
                </div>
              </b-button>
            </export-excel>
          </div>
          <div class="d-flex flex-wrap position-relative">
            <b-col
              cols="12"
              lg="6"
              class="response-text text-center text-lg-left"
            >
              <h3>{{ totalCompletedForm }} réponse(s)</h3>
            </b-col>
            <b-col cols="12" class="text-center recurrence-text">
              <h3>
                Récurrence: <strong> {{ form.form_recurrence.name }} </strong>
              </h3>
            </b-col>
          </div>
        </b-card>
      </b-col>
    </b-row>

    <b-row>
      <b-col cols="12">
        <CompletedFormList
          ref="completedFormList"
          :formId="$route.params.form_id"
          :showNewAction="false"
          :showFormColumn="false"
          :showFormFilter="false"
          @totalChanged="updateTotalCompletedForm"
        />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import CompletedFormList from '../../../../components/completedForm/CompletedFormList';
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      form: {},
      totalCompletedForm: 0,
      isFileLoading: false,
      completedFormsToExport: [],
    };
  },
  components: {
    CompletedFormList,
  },
  async mounted() {
    this.form = await this.formShow({ id: this.$route.params.form_id });
  },
  computed: {
    fileName() {
      const dateTime = new Date().toISOString().replace(/:/g, '-');
      return `export_du_${dateTime}.xls`;
    },
  },
  methods: {
    ...mapActions(['formShow', 'completedForm__getAllFiltered']),
    updateTotalCompletedForm(value) {
      this.totalCompletedForm = value;
    },
    async uploadFile() {
      this.isFileLoading = true;

      this.completedFormsToExport = await this.completedForm__getAllFiltered({
        ...this.$refs.completedFormList.allCurrentFilters,
        per_page: this.totalCompletedForm,
      });
      this.isFileLoading = false;
      return this.completedFormsToExport.data.map((completedForm) => {
        return {
          Date: completedForm.last_update,
          Nom: completedForm.created_manager_name,
          Prénom: completedForm.created_manager_first_name,
          Ctco: completedForm.hospital.name,
          Formulaire: completedForm.form.title,
        };
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';
.form-response {
  padding-top: 60px;
  .infos-card {
    padding: 10px 20px 50px 20px;
    margin-bottom: 40px;
    .response-text {
      @media (min-width: 992px) {
        position: absolute;
      }
    }
    .recurrence-text {
      strong {
        color: $dash-red;
      }
    }
    .btn-export-wrapper {
      text-align: right;
      margin-bottom: 20px;
    }
  }
}
</style>
@m
