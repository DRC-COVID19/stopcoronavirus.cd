<template>
  <b-container class="px-md-4 my-5">
      <div class="px-3 py-4 main">
        <h2 class="h2">{{title}}</h2>
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" label-class="text-dash-color">
          <b-row class="mx-1 d-flex justify-content-start">
            <b-form-group
              label-class="text-dash-color"
              id="input-group-1"
              label="Date *"
              label-for="datepicker"
              :invalid-feedback="errors.last_update ? errors.last_update[0] : null"
              :state="!errors.last_update"
            >
              <b-form-datepicker :state="errors.last_update ? false : null" :disabled="disableDate" id="datepicker" v-model="form.last_update" class="mb-2"></b-form-datepicker>
            </b-form-group>
          </b-row>
          <b-row class="d-flex justify-content-start">
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Confirmés " label-for="input-3">
                <b-form-input
                  id="input-one"
                  class="input-dash"
                  v-int
                  v-model="form.confirmed"
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Actifs " label-for="input-3">
                <b-form-input
                  id="input-two"
                  class="input-dash"
                  v-model="form.sick"
                  v-int
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Grave " label-for="input-3">
                <b-form-input
                  id="input-three"
                  class="input-dash"
                  v-int
                  v-model="form.seriously"
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Déces " label-for="input-3">
                <b-form-input
                  id="input-four"
                  v-int
                  class="input-dash"
                  v-model="form.dead"
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Importés " label-for="input-3">
                <b-form-input
                  id="input-five"
                  class="input-dash"
                  v-int
                  v-model="form.imported"
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Locales " label-for="input-3">
                <b-form-input
                  id="input-six"
                  class="input-dash"
                  v-int
                  v-model="form.local"
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Guéris " label-for="input-3">
                <b-form-input
                  id="input-seven"
                  class="input-dash"
                  v-int
                  v-model="form.healed"
                  placeholder=""
                ></b-form-input>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row class="px-3 pt-4 d-flex justify-content-start">
            <b-button type="submit" variant="primary" class="btn-dash-blue">{{btnTitle}}</b-button>
            <b-button type="reset" v-if="isUpdating" variant="primary" class="ml-4 btn-edit">Annuler</b-button>
          </b-row>
        </b-form>
      </div>
      <b-alert :show="showWarning" variant="light"><i class="minus-circle"></i> Veuillez entrer des données correctes</b-alert>
  </b-container>
</template>

<script>
  export default {
    props : {
      isSituationAdded: {
        type: Boolean,
        required: false,
        default: false
      },
      isSituationUpdated: {
        type: Boolean,
        required: false,
        default: false
      },
      formToPopulate: {
        type: Object,
        required: false,
        default: () => {return {}}
      },
      errors: {
        type: Object,
        default: () => ({})
      }
    },
    data() {
      return {
        title: "Nouvelle Situation",
        btnTitle: 'Envoyer',
        iconClass: 'fas fa-plus-square',
        validateMailMessage: '',
        disableDate: false,
        isUpdating: false,
        warningMessage: '',
        form: {
          last_update: '',
          confirmed: '',
          sick: '',
          seriously: '',
          dead: '',
          imported: '',
          local: '',
          healed: '',
        },
        showWarning: false,
        toBeCanceled: true,
        roles:[]
      }
    },
    watch: {
      isSituationAdded () {
        this.resetForm()
      },
      isSituationUpdated () {
        this.resetForm()
      },
      formToPopulate () {
        this.populateForm
      }
    },
    mounted () {
      this.resetForm ();
    },
    watch: {
      isSituationAdded () {
        this.resetForm()
      },
      formToPopulate () {
        this.populateForm()
      }
    },
    methods: {
      onSubmit () {
        if (this.btnTitle === "Envoyer" ) {
          if (this.form.last_update.trim() !== '') {
            this.$emit('onCreateSituation', this.form);
          } else {
            this.showWarning = true
          }
        } else {
          this.$emit('onUpdateSituation', this.form);
        }
      },
      onReset () {
        this.toToCanceled = true;
        this.resetForm();
        this.form = {};
        this.title = "Nouvelle Situation";
        this.btnTitle = "Envoyer";
        this.$emit('onCancelUpdate', {});
      },
      validateMail () {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(String(this.form.email).toLowerCase())){
          this.validateMailMessage = 'Adresse email incorrecte'
        };
      },
      resetForm () {
        this.isUpdating = false;
        this.disableDate = false;
        if (this.isSituationAdded | this.isSituationUpdated) {
          this.form = {};
          this.btnTitle = 'Envoyer';
          this.title = "Nouvelle Situation";
        }
      },
      populateForm () {
        this.disableDate = true;
        this.isUpdating = true;
        this.form.id = this.formToPopulate.id,
        this.form.last_update = this.formToPopulate.last_update
        this.form.confirmed = this.formToPopulate.confirmed
        this.form.sick = this.formToPopulate.sick
        this.form.seriously = this.formToPopulate.seriously
        this.form.dead = this.formToPopulate.dead
        this.form.imported = this.formToPopulate.imported
        this.form.local = this.formToPopulate.local
        this.form.healed = this.formToPopulate.healed
        this.title = "Editer la situation"
        this.btnTitle = "Valider"
      }
    },
    computed: {
      warningMissMatch () {
        return this.form.password === this.form.confirmPassword ? '' : 'Les mot de passes ne correspondent pas'
      }
    }
  }
</script>

<style lang='scss' scoped>
  @import "@~/sass/_variables";
  .main {
    background-color: white;
    border-radius: 10px;
    h2 {
      margin-bottom: 20px;  
    }
  }
</style>
