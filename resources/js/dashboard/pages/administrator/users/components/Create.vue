<template>
  <b-container>
      <div class="px-4 py-4 main">
        <h2 class="h2"> Ajouter un utiisateur</h2>
        <b-form @submit.prevent="onSubmit" v-if="show" label-class="text-dash-color">
          <b-form-group
            label-class="text-dash-color"
            id="input-group-1"
            label="Nom d'utilisateur *"
            label-for="input-1"
          >
            <b-form-input
              class="input-dash"
              id="input-1"
              v-model="form.username"
              type="text"
              placeholder="Entrer le username"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group
            id="input-group-2"
            label="Email address *"
            label-class="text-dash-color"
            label-for="input-2"
          >
            <b-form-input
              class="input-dash"
              id="input-2"
              v-model="form.email"
              type="email"
              placeholder="Enter email"
              required
              @blur="validateMail()"
            ></b-form-input>
          </b-form-group>
          <b-alert show v-if="validateMailMessage !== ''" variant="light">{{validateMailMessage}}</b-alert>
          <b-form-group label-class="text-dash-color" id="input-group-3" label="Nom *" label-for="input-3">
            <b-form-input
              id="input-3"
              class="input-dash"
              v-model="form.name"
              placeholder="Entrer le nom"
              required
            ></b-form-input>
          </b-form-group>
          <label class="text-dash-color" for="check-group-1">Roles *</label>
          <b-form-checkbox-group
            id="checkbox-group-1"
            v-model="form.selected"
            :options="form.roles"
            name="flavour-1"
          ></b-form-checkbox-group>
          <label class="text-dash-color" for="text-password">Mot de passe *</label>
          <b-form-input class="input-dash" type="password" id="text-password" aria-describedby="password-help-block" v-model="form.password"></b-form-input>
          <b-form-text id="password-help-block">
            Votre mot de passe doit contenir 8 carateres au minimum 
          </b-form-text>
          <label class="text-dash-color" for="text-password-confirm">Confirmation de mot de passe *</label>
          <b-form-input class="input-dash" type="password" id="text-password-confirm" aria-describedby="password-help-block" v-model="form.confirmPassword"></b-form-input>
          <b-alert show variant="light">{{warningMissMatch}}</b-alert>
          <b-button type="submit" variant="primary" class="btn-dash-blue">Enreigistrer</b-button>
        </b-form>
      </div>
  </b-container>
</template>

<script>
  export default {
    data() {
      return {
        title: "Creation d'un utilisateur",
        iconClass: 'fas fa-plus-square',
        validateMailMessage: '',
        form: {
          username: '',
          name: '',
          roles: [],
          selected: [],
          email: '',
          password: '',
          confirmPassword: '',
        },
        // roles: [],
        show: true
      }
    },
    mounted () {
      // Fetch the user roles
      this.getUserRoles()
    },
    methods: {
      onSubmit(event) {
        if (this.password === this.confrimPassword) {
          this.$emit('onCreate', this.form)
        } else {
          
        }
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
            for (let i = 0; i < data.length;  i++) {
              this.form.roles.push(data[i].id)
            }
          })
          .catch(error => {
            console.log(error);
          })
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
