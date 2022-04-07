/* eslint-disable no-sequences */
<template>
  <b-card class="border-0">
    <h2 class="h2 mb-4">{{ title }}</h2>
    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" class="mt-2">
      <b-row class="d-flex justify-content-start">
        <b-col class="md-12 mb-2">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-1"
            label-for="datepicker"
            class="md-12"
            :invalid-feedback="
              errors.last_update ? errors.last_update[0] : null
            "
            :state="!errors.last_update"
          >
            <label for="input-group-1" class="text-dash-color"
              >Date <span class="text-danger">*</span></label
            >
            <v-date-picker
              v-model="form.last_update"
              opens="center"
              :max-date="new Date()"
              class="d-flex input-dash mb-2"
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
                      form.last_update
                        ? moment(form.last_update).format('DD.MM.YYYY')
                        : 'Choisir la date'
                    "
                    v-on="inputEvents"
                    :disabled="isUpdating"
                    readonly
                  />
                </div>
              </template>
            </v-date-picker>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="d-flex justify-content-start">
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Confirmés "
            label-for="input-3"
          >
            <b-form-input
              id="input-one"
              class="input-dash"
              v-int
              v-model="form.confirmed"
              type="number"
              placeholder=""
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Actifs "
            label-for="input-3"
          >
            <b-form-input
              id="input-two"
              class="input-dash"
              v-model="form.sick"
              v-int
              type="number"
              placeholder=""
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Grave "
            label-for="input-3"
          >
            <b-form-input
              id="input-three"
              class="input-dash"
              v-int
              v-model="form.seriously"
              placeholder=""
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Déces "
            label-for="input-3"
          >
            <b-form-input
              id="input-four"
              v-int
              class="input-dash"
              v-model="form.dead"
              placeholder=""
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Importés "
            label-for="input-3"
          >
            <b-form-input
              id="input-five"
              class="input-dash"
              v-int
              v-model="form.imported"
              placeholder=""
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Locales "
            label-for="input-3"
          >
            <b-form-input
              id="input-six"
              class="input-dash"
              v-int
              v-model="form.local"
              placeholder=""
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col md="12">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-3"
            label="Guéris "
            label-for="input-3"
          >
            <b-form-input
              id="input-seven"
              class="input-dash"
              v-int
              v-model="form.healed"
              placeholder=""
              type="number"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
        <b-button type="submit" variant="primary">
          <span v-if="isLoading">
            <b-spinner class="align-middle"></b-spinner>
            <span>en cours ...</span>
          </span>
          <div v-else>
            {{ btnTitle }}
          </div>
        </b-button>
        <b-button type="reset" variant="outline-danger" class="ml-4">{{
          isUpdating ? "Annuler" : "Réinitialiser"
        }}</b-button>
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
export default {
  props: {
    isSituationAdded: {
      type: Boolean,
      required: false,
      default: false,
    },
    isSituationUpdated: {
      type: Boolean,
      required: false,
      default: false,
    },
    formToPopulate: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },

  data() {
    return {
      title: "Nouvelle Situation",
      btnTitle: "Enregistrer",
      iconClass: "fas fa-plus-square",
      validateMailMessage: "",
      disableDate: false,
      isUpdating: false,
      isLoading: false,
      warningMessage: "",
      form: {
        last_update: null,
        confirmed: "",
        sick: "",
        seriously: "",
        dead: "",
        imported: "",
        local: "",
        healed: "",
      },
      showWarning: false,
      toBeCanceled: true,
      roles: [],
    };
  },
  mounted() {
    this.resetForm();
  },
  watch: {
    isSituationAdded() {
      this.resetForm();
    },
    isSituationUpdated() {
      this.resetForm();
    },
    formToPopulate() {
      this.resetForm();
      this.populateForm();
    },
  },

  methods: {
    onSubmit() {
      this.isLoading = true;
      if (this.btnTitle === "Enregistrer") {
        if (this.form.last_update !== null) {
          this.$emit("onCreateSituation", this.form);
        } else {
          this.showWarning = true;
        }
      } else {
        this.$emit("onUpdateSituation", this.form);
      }
    },
    onReset() {
      this.toToCanceled = true;
      this.resetForm();
      this.form = {};
      this.title = "Nouvelle Situation";
      this.btnTitle = "Enregistrer";
      this.$emit("onCancelUpdate", {});
    },

    resetForm() {
      this.isUpdating = false;
      this.isLoading = false;
      this.disableDate = false;
      this.form = {};
      this.form.last_update = null;
      this.btnTitle = "Enregistrer";
      this.title = "Nouvelle Situation";
    },
    populateForm() {
      this.disableDate = false;
      this.isUpdating = false;

      if (Object.keys(this.formToPopulate).length !== 0) {
        this.disableDate = true;
        this.isUpdating = true;
        // eslint-disable-next-line no-unused-expressions
        (this.form.id = this.formToPopulate.id),
          (this.form.last_update = this.formToPopulate.last_update);
        this.form.confirmed = this.formToPopulate.confirmed;
        this.form.sick = this.formToPopulate.sick;
        this.form.seriously = this.formToPopulate.seriously;
        this.form.dead = this.formToPopulate.dead;
        this.form.imported = this.formToPopulate.imported;
        this.form.local = this.formToPopulate.local;
        this.form.healed = this.formToPopulate.healed;
        this.title = "Modification de la situation";
        this.btnTitle = "Valider";
      }
    },
  },

  computed: {},
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
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
}
</style>
