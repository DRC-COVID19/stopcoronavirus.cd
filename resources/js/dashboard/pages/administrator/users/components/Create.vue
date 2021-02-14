<template>
  <b-container>
      <div class="main">
        <b-form @submit="onSubmit" v-if="show">
          <b-form-group
            id="input-group-1"
            label="Nom d'utilisateur *"
            label-for="input-1"
          >
            <b-form-input
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
            label-for="input-2"
          >
            <b-form-input
              id="input-2"
              v-model="form.email"
              type="email"
              placeholder="Enter email"
              required
              @blur="validateMail()"
            ></b-form-input>
          </b-form-group>
          <b-alert show v-if="validateMailMessage !== ''" variant="light">{{validateMailMessage}}</b-alert>
          <b-form-group id="input-group-3" label="Nom *" label-for="input-3">
            <b-form-input
              id="input-3"
              v-model="form.name"
              placeholder="Entrer le nom"
              required
            ></b-form-input>
          </b-form-group>
          <label for="text-password">Roles *</label>
          <b-form-checkbox-group
            id="checkbox-group-1"
            v-model="selected"
            :options="roles"
            :aria-describedby="ariaDescribedby"
            name="flavour-1"
          ></b-form-checkbox-group>
          <label for="text-password">Mot de passe *</label>
          <b-form-input type="password" id="text-password" aria-describedby="password-help-block" v-model="form.password"></b-form-input>
          <b-form-text id="password-help-block">
            Votre mot de passe doit contenir 8 carateres au minimum 
          </b-form-text>
          <label for="text-password-confirm">Confirmation de mot de passe *</label>
          <b-form-input type="password" id="text-password-confirm" aria-describedby="password-help-block" v-model="form.confirmPassword"></b-form-input>
          <b-alert show variant="light">{{warningMissMatch}}</b-alert>
          <b-button type="submit" variant="primary" class="my-2 btn-dash-blue">Enreigistrer</b-button>
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
          email: '',
          password: '',
          confrimPassword: '',
        },
        selected: [],
        roles: [],
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
          axios.post('/api/admin_users', {
            username: this.form.username,
            name: this.form.name,
            roles_id: this.selected,
            email: this.form.email,
            password: this.form.password,
            password_confirmation: this.form.confrimPassword
          })
            .then(({data}) => {
              if (data === null) {
                console.log('Added')
              } else {
                console.log('Error')
              }
            })
            .catch(e => console.log(e))
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
            this.roles = data
            console.log(this.roles)
          })
          .catch(error => {
            console.log(error);
          })
      }
    },
    computed: {
      warningMissMatch () {
        return this.form.password === this.form.confrimPassword ? '' : 'Les mot de passes ne correspondent pas'
      }
    }
  }
</script>

<style>

</style>
