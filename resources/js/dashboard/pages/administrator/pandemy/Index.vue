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
                    errors.publish_date ? errors.publish_date[0] : null
                  "
                  :state="errors.publish_date ? false : null"
                  :disabled="isCreating"
                >
                  <b-form-datepicker
                    v-model="form.publish_date"
                    :state="errors.publish_date ? false : null"
                    class="input-dash"
                    :max="new Date()"
                    required
                  />
                  <label class="mt-2 text-dash-color" for="check-group-1"
                    >Zone de sante *</label
                  >
                  <v-select
                    v-model="form.zone"
                    class="input-select"
                    :options="zones"
                    label="name"
                    :reduce="item => item.id"
                  />
                </b-form-group>
              </b-col>
            </b-row>
            <b-row class="d-flex justify-content-start px-o">
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
            <b-row class="mx-1">
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
                  <span v-if="isUpdating">Modifier</span>
                  <span v-else>Enregistrer</span>
                </div>
              </b-button>
              <b-button
                :disabled="isCreating"
                v-if="isUpdating"
                class="btn-dash-danger"
                @click="cancelEditMode"
                >Annuler</b-button
              >
            </b-row>
          </b-form>
        </b-card>
      </b-col>
      <b-col md="8">
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
              v-model="form.zone"
              :options="zones"
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
          :items="listPandemics"
          :fields="fields"
        >
          <template #cell(actions)="data">
            <i
              class="mx-2 fas fa-edit btn-action text-warning"
              @click="toEdit(data.item)"
            ></i>
            <i
              class="mx-2 fas fa-trash btn-action text-danger"
              @click="remove(data.item)"
            ></i>
          </template>
        </b-table>
        <b-row>
          <b-col class="d-flex justify-content-end">
            <b-pagination
              :total-rows="totalRows"
              :per-page="perPage"
              :current-page="currenPage"
              :disabled="isCreating"
            ></b-pagination>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Header from "../components/Header";
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
      currenPage: 1,
      perPage: 15,
      errors: {},
      filter: null,
      zones: ["Nord-Kivu", "Kinshasa", "Sud-Kivu", "Katanga"],
      form: {},
      isUpdating: false,
      currentItem: {},
      isCreating: false,
      isLoading: false,
      listPandemics: [
        {
          id: "1",
          confirmed: 12,
          seriously: 29,
          sick: 13,
          healed: 23,
          last_update: "02-23-2021",
          dead: 34,
          health_zone: "Afia"
        },
        {
          id: "1",
          confirmed: 12,
          seriously: 29,
          sick: 13,
          healed: 23,
          last_update: "02-23-2021",
          dead: 34,
          health_zone: "Afia"
        },
        {
          id: "1",
          confirmed: 12,
          seriously: 29,
          sick: 13,
          healed: 23,
          last_update: "02-23-2021",
          dead: 34,
          health_zone: "Afia"
        },
        {
          id: "1",
          confirmed: 12,
          seriously: 29,
          sick: 13,
          healed: 23,
          last_update: "02-23-2021",
          dead: 34,
          health_zone: "Afia"
        },
        {
          id: "1",
          confirmed: 12,
          seriously: 29,
          sick: 13,
          healed: 23,
          last_update: "02-23-2021",
          dead: 34,
          health_zone: "Afia"
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped></style>
