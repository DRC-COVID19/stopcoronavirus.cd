<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse h-100">
      <b-col cols="12" md="4" class="mt-3">
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
          <b-card class="border-0 p-0 p-0" no-gutters>
            <ValidationObserver v-slot="{ invalid }" novalidate ref="form">
              <b-form @submit.prevent="submit_form">
                <b-form-group
                  :invalid-feedback="
                    errors.publish_date ? errors.publish_date[0] : null
                  "
                  :state="errors.publish_date ? false : null"
                  :disabled="isCreating"
                  class="mb-4"
                >
                  <label for="dataId" class="text-dash-color">
                    Date<span class="text-danger">*</span></label
                  >
                  <v-date-picker
                    v-model="form.publish_date"
                    opens="center"
                    :max-date="new Date()"
                    class="d-flex input-dash"
                    id="dateId"
                    show-weeknumbers
                    is-required
                  >
                    <template v-slot="{ inputEvents }">
                      <div class="d-flex btn-container-calendar">
                        <i
                          for="publish_date"
                          class="fas fa-light fa-calendar p-2"
                        ></i>
                        <input
                          id="publish_date"
                          class="p-1 w-full"
                          style="font-size: 16px"
                          :value="
                            form.publish_date
                              ? moment(form.publish_date).format('DD.MM.YYYY')
                              : 'Choisir la date'
                          "
                          v-on="inputEvents"
                          readonly
                        />
                      </div>
                    </template>
                  </v-date-picker>
                </b-form-group>
                <b-form-group :disabled="isCreating">
                  <label for="titleId" class="text-dash-color"
                    >Titre <span class="text-danger">*</span></label
                  >
                  <FormFieldInput
                    v-model="form.title"
                    type="text"
                    rules="required"
                    name="titre"
                    label="Titre"
                    :state="errors.title ? false : null"
                    id="titleId"
                  />
                  <b-form-text id="password-help-block"
                    ><span class="text-danger">{{
                      errors.title ? errors.title[0] : null
                    }}</span></b-form-text
                  >
                </b-form-group>
                <b-form-group class="mt-4">
                  <form-field-text-area
                    v-model="form.description"
                    type="text"
                    rules="required"
                    name="description"
                    labelText="Description"
                    :state="errors.description ? false : null"
                    id="descriptionId"
                    :rows="5"
                    :isObligated="true"
                  />
                  <b-form-text id="description-help-block"
                    ><span class="text-danger">{{
                      errors.description ? errors.description[0] : null
                    }}</span></b-form-text
                  >
                </b-form-group>
                <div class="mt-4">
                  <b-button
                    type="submit"
                    variant="primary"
                    :disabled="isCreating || invalid ? true : false"
                  >
                    <span v-if="isCreating"
                      ><b-spinner class="align-middle"></b-spinner>
                      <span>en cours ...</span>
                    </span>
                    <div v-else>
                      <span v-if="isEditingMode">Modifier</span>
                      <span v-else>Enregistrer</span>
                    </div>
                  </b-button>
                  <b-button
                    type="reset"
                    variant="outline-danger"
                    :disabled="isCreating"
                    class="ml-4"
                    @click="resetForm()"
                    >{{ isEditingMode ? "Annuler" : "Réinitialiser" }}</b-button
                  >
                </div>
              </b-form>
            </ValidationObserver>
          </b-card>
          <template #header="{ hide }">
            <div
              class="
                w-100
                d-flex
                bg-white
                align-items-center
                justify-content-between
                py-0
                px-0
              "
            >
              <h2 class="h2">
                {{ isEditingMode ? "Modifier log" : "Nouveau log" }}
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
          <Header title="Change log" iconClass="fa fa-history" />
        </div>
        <div class="hide-waiting" v-if="isCreating || isEditingMode"></div>
        <div class="container-fluid">
          <b-row class="mb-3" no-gutters>
            <b-col
              cols="12"
              md="12 d-flex flex-row-reverse justify-content-between"
            >
              <div class="container-filter">
                <v-date-picker
                  v-model="filter"
                  opens="center"
                  :max-date="new Date()"
                  @input="onRangeDateObservation"
                  class="d-flex style-picker mb-2"
                  show-weeknumbers
                  ref="datepicker"
                  :attributes="attrs"
                >
                  <template v-slot="{ inputEvents }">
                    <div class="d-flex btn-container-calendar">
                      <i for="filter" class="fas fa-light fa-calendar p-2"></i>
                      <input
                        id="filter"
                        class="p-1 w-full"
                        style="font-size: 16px"
                        :value="
                          filter
                            ? moment(filter).format('DD.MM.YYYY')
                            : 'Choisir la date'
                        "
                        v-on="inputEvents"
                        readonly
                      />
                    </div>
                  </template>
                  <div
                    slot="footer"
                    slot-scope=""
                    class="d-flex justify-content-between ml-2 mr-2 mb-2 mt-n2"
                    style="width: 330px"
                  >
                    <span
                      class="btn-date-picker today"
                      style=""
                      @click="btnToday"
                      >Aujourd'hui
                    </span>
                    <span class="btn-date-picker reset" @click="btnReset">
                      Annuler</span
                    >
                  </div>
                </v-date-picker>
              </div>
              <div class="container-new-btn d-lg-none">
                <b-button
                  @click="openToogle()"
                  v-b-toggle.sidebar-right
                  class="btn-dash-blue d-block"
                  ><span class="default-label">Nouveau</span>
                  <i class="fas fa-plus responsive-label"></i>
                </b-button>
              </div>
            </b-col>
          </b-row>

          <b-row no-gutters>
            <b-col cols="12">
              <b-skeleton-table
                v-if="isLoading"
                :rows="15"
                :columns="5"
                :table-props="{
                  bordered: false,
                  striped: true,
                  responsive: true,
                }"
              ></b-skeleton-table>

              <b-table
                v-else
                hover
                striped
                responsive
                :fields="fields"
                :items="changeLogsData"
              >
                <template #cell(number)="data">
                  {{ data.index + 1 }}
                </template>
                <template #cell(from)="data">
                  {{ moment(data.item.from).format("DD.MM.YYYY") }}
                </template>
                <template #cell(Titre)="data">
                  {{ data.title }}
                </template>
                <template #cell(action)="data">
                  <b-button
                    variant="outline-success mb-1"
                    class="btn-dash"
                    @click="toEdit(data.item)"
                    v-b-toggle.sidebar-right
                    >Editer</b-button
                  >
                  <b-button
                    variant="outline-danger mb-1"
                    class="btn-dash"
                    @click="remove(data.item)"
                  >
                    Supprimer
                  </b-button>
                </template>
              </b-table>
            </b-col>
          </b-row>
          <b-row>
            <b-col class="d-flex justify-content-end">
              <b-pagination
                v-model="changeLogsMeta.current_page"
                :total-rows="changeLogsMeta.total"
                :per-page="changeLogsMeta.per_page"
                @change="switchPage"
                :disabled="isCreating"
              ></b-pagination>
            </b-col>
          </b-row>
        </div>
      </b-col>
    </b-row>
    <b-modal id="confirmation-box" centered hide-header>
      <b-container class="text-center"
        >Voulez-vous supprimer cette ligne ?</b-container
      >
      <template #modal-footer="{ hide }">
        <b-button
          size="sm"
          variant="outline-success mb-1"
          class="btn-dash"
          @click="onValidate"
        >
          Accepter
        </b-button>
        <b-button
          size="sm"
          variant="outline-danger mb-1"
          class="btn-dash"
          @click="hide('confirmation-box')"
        >
          Annuler
        </b-button>
      </template>
    </b-modal>
  </b-container>
</template>

<script>
import { mapActions, mapState } from "vuex";
import Header from "../components/Header";
import FormFieldInput from "../../../components/forms/FormFieldInput";
import FormFieldTextArea from "../../../components/forms/FormFieldTextArea";
import { ValidationObserver } from "vee-validate";

export default {
  components: {
    Header,
    FormFieldInput,
    FormFieldTextArea,
    ValidationObserver,
  },
  data() {
    return {
      filter: null,
      fields: [
        {
          key: "from",
          label: "Date",
        },
        {
          key: "title",
          label: "Titre",
        },
        {
          key: "action",
          label: "Actions",
        },
      ],
      form: {},
      errors: {},
      isEditingMode: false,
      itemToRemove: {},
      attrs: [],
    };
  },

  mounted() {
    this.resetForm();
    this.getListChangedLogs();
  },

  watch: {
    filter() {
      this.search();
    },
  },

  computed: {
    ...mapState({
      listChangeLogs: (state) => state.changeLog.listChangeLogs,
      isCreating: (state) => state.changeLog.isCreating,
      isLoading: (state) => state.changeLog.isLoading,
    }),
    changeLogsData() {
      return this.listChangeLogs.data;
    },

    changeLogsMeta() {
      return this.listChangeLogs.meta
        ? this.listChangeLogs.meta
        : {
            current_page: 1,
            from: 1,
            last_page: 1,
            path: "#",
            per_page: 1,
            to: 1,
            total: 1,
          };
    },
  },

  methods: {
    ...mapActions(["createChangeLog"]),
    ...mapActions([
      "getListChangedLogs",
      "updateChangeLog",
      "removeChangeLog",
      "searchChangeLog",
    ]),
    submit_form() {
      if (this.isEditingMode) {
        this.submitUpdatingChangeLog();
      } else {
        this.submitcreateChangeLog();
      }
      this.resetForm();
    },
    throwError() {
      throw new Error("Sentry Error");
    },
    submitcreateChangeLog() {
      this.errors = {};
      this.createChangeLog(this.form)
        .then(() => {
          this.form = {};
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Nouveau log",
            text: "Ajouter avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$notify({
            group: "alert",
            title: "Nouveau log",
            text: "Une erreur est surveni",
            type: "error",
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },
    submitUpdatingChangeLog() {
      this.errors = {};
      this.updateChangeLog(this.form)
        .then(() => {
          this.form = {};
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Modifer log",
            text: "Modifier avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$notify({
            group: "alert",
            title: "Modifer log",
            text: "Une erreur est survenue",
            type: "error",
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },
    openToogle() {
      this.isEditingMode = false;
      this.form = {};
      this.form.publish_date = null;
    },
    switchPage(page) {
      this.getListChangedLogs({ page }).then(() => {
        window.scrollTo(0, 0);
      });
    },
    toEdit(item) {
      this.isEditingMode = false;
      this.form = {};
      this.form.publish_date = null;

      if (Object.keys(item).length !== 0) {
        this.isEditingMode = true;
        this.form = { ...item };
        this.form.publish_date = item.from;
      }
    },
    resetForm() {
      this.isEditingMode = false;
      this.form = {};
      this.$refs.form.reset();
    },
    search() {
      this.searchChangeLog(moment(this.filter).format("DD.MM.YYYY")).catch(
        (error) => {
          console.log(error);
        }
      );
    },
    onValidate() {
      this.$bvModal.hide("confirmation-box");
      this.removeChangeLog(this.itemToRemove)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer log",
            text: "Supprimer avec succès",
            type: "success",
          });
        })
        .catch(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer log",
            text: "Une erreur est surveni",
            type: "error",
          });
        });
    },
    remove(item) {
      this.itemToRemove = item;
      this.$bvModal.show("confirmation-box");
    },
    onRangeDateObservation(inputValueDate) {
      // this.filter = inputValueDate
      this.attrs = [];
    },
    btnReset() {
      this.attrs = [];
      this.filter = null;
      this.getListChangedLogs();
    },
    btnToday() {
      this.filter = new Date();
      this.attrs.push({
        key: "today",
        dates: new Date(),
        highlight: true,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.btn-action {
  cursor: pointer;
}
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;

  input {
    border: none !important;
    width: 100%;
    height: 100%;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
}
.style-picker {
  padding: 5px;
  width: 100%;
}
.btn-date-picker {
  cursor: pointer;
  border: 1px solid #c3c8ced2;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 16px;
  transition: 0.3s ease-in-out;
}
.today {
  &:hover {
    color: #0013c1;
    border: 1px solid #0013c1;
  }
}
.reset {
  &:hover {
    color: red;
    border: 1px solid red;
  }
}
.responsive-label {
  display: none;
}
.default-label {
  display: block;
}
.container-new-btn {
  display: block !important;
}
@media (max-width: $max-width) {
  .default-label {
    display: none;
  }
  .responsive-label {
    display: block;

    font-size: 20px;
  }
}
</style>
