<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse">
      <b-col md="4">
        <b-card class="mt-3">
          <h3>Ajouter</h3>
          <b-form @submit.prevent="submit_form" class="px-3">
            <b-row>
              <b-col>
                <b-form-group
                  label="Date"
                  label-class="text-dash-color"
                  :invalid-feedback="
                    errors.last_update ? errors.last_update[0] : null
                  "
                  :state="errors.last_update ? false : null"
                  :disabled="isEditingMode"
                >
                  <b-form-datepicker
                    v-model="form.last_update"
                    :state="errors.last_update ? false : null"
                    class="input-dash"
                    :max="new Date()"
                    required
                  />
                  <label class="mt-2 text-dash-color" for="check-group-1"
                    >Zone de sante *</label
                  >
                  <v-select
                    required
                    class="input-dash"
                    v-model="form.health_zone_id"
                    :options="healthZonesData"
                    label="name"
                    :reduce="item => item.id"
                  />
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-2"
                  label="Confirmes "
                  label-for="input-2"
                >
                  <b-form-input
                    id="input-two"
                    class="input-dash"
                    v-model="form.confirmed"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-3"
                  label="Actifs "
                  label-for="input-3"
                >
                  <b-form-input
                    id="input-three"
                    class="input-dash"
                    v-model="form.sick"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-4"
                  label="Grave"
                  label-for="input-4"
                >
                  <b-form-input
                    id="input-four"
                    class="input-dash"
                    v-model="form.seriously"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-5"
                  label="Gueris"
                  label-for="input-5"
                >
                  <b-form-input
                    id="input-five"
                    class="input-dash"
                    v-model="form.healed"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-6"
                  label="Deces"
                  label-for="input-6"
                >
                  <b-form-input
                    id="input-six"
                    class="input-dash"
                    v-model="form.dead"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-button
                  type="submit"
                  class="btn-dash-sucess"
                  :disabled="isCreating"
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
                  :disabled="isCreating"
                  v-if="isEditingMode"
                  class="btn-dash-danger"
                  @click="cancelEditMode"
                  >Annuler</b-button
                >
              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-col>
      <b-col md="8">
        <div class="hide-waiting" v-if="isEditingMode"></div>
        <Header title="Pandemie" iconClass="fas fa-procedures" />
        <b-row class="my-3" align-h="start">
          <b-col cols="12" md="6">
            <b-form-datepicker
              label-today-button="Aujourd'hui"
              label-reset-button="Effacer"
              reset-button
              today-button
              :max="new Date()"
              v-model="filter"
              placeholder="Choisir la date"
              class="mb-2"
            >
            </b-form-datepicker>
          </b-col>
          <b-col cols="12" md="6">
            <v-select
              placeholder="Zone de sante"
              class="input-dash"
              v-model="selectedHealthZoneFilter"
              :options="healthZonesData"
              label="name"
              :reduce="item => item.id"
            />
          </b-col>
        </b-row>
        <b-skeleton-table
          v-if="isLoading"
          :rows="15"
          :columns="9"
          :table-props="{ bordered: false, striped: true, responsive: true }"
        >
        </b-skeleton-table>
        <b-table
          v-else
          hover
          striped
          responsive
          :items="pandemicsData"
          :fields="fields"
        >
          <template #cell(actions)="data">
            <i
              class="mx-2 fas fa-edit btn-action text-warning"
              @click="toEdit(data.item)"
            ></i>
            <i
              class="mx-2 fas fa-trash btn-action text-danger"
              @click="toRemove(data.item)"
            ></i>
          </template>
          <template #cell(last_update)="data">
            {{ moment(data.item.last_update).format("DD.MM.YYYY") }}
          </template>
          <template #cell(health_zone)="data">
            {{ data.item.health_zone ? data.item.health_zone.name : "" }}
          </template>
        </b-table>
        <b-row>
          <b-col class="d-flex justify-content-end">
            <b-pagination
              v-model="pandemicsMeta.current_page"
              :total-rows="totalRows"
              :per-page="perPage"
              :current-page="currentPage"
              :disabled="isCreating"
            ></b-pagination>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <b-modal id="confirmation-box">
      Voulez-vous supprimer cette ligne ?
      <template #modal-footer="{ hide }">
        <b-button size="sm" variant="success" @click="onDelete">
          Accepter
        </b-button>
        <b-button size="sm" variant="danger" @click="hide('confirmation-box')">
          Annuler
        </b-button>
      </template>
    </b-modal>
  </b-container>
</template>

<script>
import Header from "../components/Header";
import { mapActions, mapState } from "vuex";
export default {
  components: {
    Header
  },
  data() {
    return {
      fields: [
        {
          key: "id",
          label: "ID"
        },
        {
          key: "confirmed",
          label: "Confirmes"
        },
        {
          key: "sick",
          label: "Actifs"
        },
        {
          key: "seriously",
          label: "Grave"
        },
        {
          key: "healed",
          label: "Gueris"
        },
        {
          key: "dead",
          label: "Deces"
        },
        {
          key: "last_update",
          label: "Date"
        },
        {
          key: "health_zone",
          label: "Zone de sante"
        },
        "actions"
      ],
      totalRows: 10,
      isEditingMode: false,
      currentPage: 1,
      perPage: 15,
      errors: {},
      filter: null,
      selectedHealthZoneFilter: null,
      form: {},
      currentItem: {}
    };
  },

  mounted() {
    this.getListHealthZones();
    this.getListPandemics();
  },

  computed: {
    ...mapState({
      listHealthZones: state => state.pandemics.listHealthZones,
      listPandemics: state => state.pandemics.listPandemics,
      isLoading: state => state.pandemics.isLoading,
      isCreating: state => state.pandemics.isCreating,
      isUpdating: state => state.pandemics.isUpdating
    }),

    pandemicsData() {
      return this.listPandemics.data;
    },

    healthZonesData() {
      return this.listHealthZones.data;
    },

    pandemicsMeta() {
      return this.listPandemics.meta
        ? this.listPandemics.meta
        : {
            current_page: 1,
            from: 1,
            last_page: 1,
            path: "#",
            per_page: 1,
            to: 1,
            total: 1
          };
    }
  },

  watch: {
    filter() {
      this.search();
    },
    selectedHealthZoneFilter() {
      this.search();
    }
  },

  methods: {
    ...mapActions(["createPandemics"]),
    ...mapActions([
      "getListHealthZones",
      "getListPandemics",
      "updatePandemics",
      "searchPandemics",
      "removePandemics"
    ]),

    search() {
      this.searchPandemics({last_update: this.filter ? this.filter : "", health_zone: this.selectedHealthZoneFilter ? this.selectedHealthZoneFilter : ""}).catch(error => {
        console.log(error);
      })
    },

    toEdit(item) {
      this.isEditingMode = true;
      this.form = { ...item };
    },

    toRemove(item) {
      this.currentItem = item;
      this.$bvModal.show("confirmation-box");
    },

    submit_form() {
      if (this.isEditingMode) {
        this.onUpdatePandemic();
      } else {
        this.onCreatePandemics();
      }
    },

    onCreatePandemics() {
      this.errors = {};
      this.createPandemics(this.form)
        .then(() => {
          this.form = {};
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Ajout",
            text: "Ajout reussi",
            type: "success"
          });
        })
        .catch(err => {
          this.$notify({
            group: "alert",
            title: "Ajout",
            text: "Une erreur est survenu lors de l'enregistrement",
            type: "error"
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },

    cancelEditMode() {
      this.isEditingMode = false;
      this.form = {};
    },

    onDelete() {
      this.$bvModal.hide("confirmation-box");
      this.removePandemics(this.currentItem)
        .then(result => {
          this.$notify({
            group: "alert",
            title: "Suppression",
            text: "Supprimee avec succès",
            type: "success"
          });
        })
        .catch(err => {
          this.$notify({
            group: "alert",
            title: "Supprimer log",
            text: "Une erreur est surveni",
            type: "error"
          });
        });
    },
    onUpdatePandemic() {
      this.errors = {};
      this.updatePandemics(this.form)
        .then(() => {
          this.form = {};
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Modification",
            text: "Modifié avec succès",
            type: "success"
          });
        })
        .catch(err => {
          this.$notify({
            group: "alert",
            title: "Modification",
            text: "Une erreur est survenu lors de la modification",
            type: "error"
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    }
    // search () {

    // }
  }
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.btn-action {
  cursor: pointer;
}
</style>
