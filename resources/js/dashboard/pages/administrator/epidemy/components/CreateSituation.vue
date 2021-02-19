<template>
  <b-container class="px-5 my-5">
      <div class="px-3 py-4 main">
        <h2 class="h2">{{title}}</h2>
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show" label-class="text-dash-color">
          <b-row class="mx-1 d-flex justify-content-start">
            <b-form-group
              label-class="text-dash-color"
              id="input-group-1"
              label="Date *"
              label-for="datepicker"
            >
              <b-form-datepicker id="datepicker" v-model="form.last_update" class="mb-2"></b-form-datepicker>
            </b-form-group>
          </b-row>
          <b-row class="d-flex justify-content-start">
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Confirmés " label-for="input-3">
                <b-form-input
                  id="input-one"
                  class="input-dash"
                  v-model="form.confirmed"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Actifs " label-for="input-3">
                <b-form-input
                  id="input-two"
                  class="input-dash"
                  v-model="form.sick"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Grave " label-for="input-3">
                <b-form-input
                  id="input-three"
                  class="input-dash"
                  v-model="form.seriously"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Déces " label-for="input-3">
                <b-form-input
                  id="input-four"
                  class="input-dash"
                  v-model="form.dead"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Importés " label-for="input-3">
                <b-form-input
                  id="input-five"
                  class="input-dash"
                  v-model="form.imported"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Locales " label-for="input-3">
                <b-form-input
                  id="input-six"
                  class="input-dash"
                  v-model="form.local"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col md="4">
              <b-form-group label-class="text-dash-color" id="input-group-3" label="Guéris " label-for="input-3">
                <b-form-input
                  id="input-seven"
                  class="input-dash"
                  v-model="form.healed"
                  placeholder=""
                  required
                ></b-form-input>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row class="px-3 pt-4 d-flex justify-content-start">
            <b-button type="submit" variant="primary" class="btn-dash-blue">{{btnTitle}}</b-button>
            <b-button type="reset" v-if="title !== 'Creation d\'un utilisateur'" variant="primary" class="ml-4 btn-edit">Annuler</b-button>
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
        default: () => false
      },
      formToPopulate: {
        type: Object,
        required: false,
        default: () => {}
      }
    },
    data() {
      return {
        title: "Nouvelle Situation",
        btnTitle: 'Envoyer',
        iconClass: 'fas fa-plus-square',
        validateMailMessage: '',
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
        show: true,
        showWarning: false,
        toBeCanceled: true,
        roles:[]
      }
    },
    mounted () {
      // Fetch the user roles
      this.getUserRoles(),
      this.resetForm ()
    },
    watch: {
      situationAdded () {
        this.resetForm()
      },
      formToPopulate () {
        this.populateForm()
      }
    },
    methods: {
      onSubmit () {
        if (this.btnTitle === "Envoyer") {
          if (this.form.last_update.trim() !== '') {
            this.$emit('onCreateSituation', this.form)
          } else {
            this.showWarning = true
          }
        } else {
          // To handle the update route
        }
      },
      onReset () {
        this.toToCanceled = true
        this.form = {}
        this.title = "Nouvelle Situation"
        this.btnTitle = "Envoyer"
        this.$emit('onCancelUpdate', {})
      },
      validateMail () {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(String(this.form.email).toLowerCase())){
          this.validateMailMessage = 'Adresse email incorrecte'
        };
      },
      getUserRoles () {
        axios.get('/api/admin_roles', {
          params: {}
        })
          .then(({data}) => {
            this.roles=data;
          })
          .catch(error => {
            console.log(error);
          })
      },
      resetForm () {
        if (this.situationAdded) {
          this.form = {}
        }
      },
      populateForm () {
        this.form.username = this.formToPopulate.usernmae
        this.form.email = this.formToPopulate.email
        this.form.name = this.formToPopulate.name
        this.title = "Modification de l'utilisateur"
        this.btnTitle = "Modifier"
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
