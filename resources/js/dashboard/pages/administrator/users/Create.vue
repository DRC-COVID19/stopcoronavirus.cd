<template>
  <div class="main">
    <Header :title="title" :iconClass="iconClass"/>
    <b-form @submit="onSubmit" @reset="onReset" v-if="show" class="col-sm-10 col-md-6 mx-auto my-3 bg-light p-3" >
      <b-form-group
        id="input-group-1"
        label="Nom d'utilisateur:"
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
        id="input-group-1"
        label="Email address:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.email"
          type="email"
          placeholder="Enter email"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-2" label="Nom:" label-for="input-2">
        <b-form-input
          id="input-2"
          v-model="form.name"
          placeholder="Entrer le nom"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Role" label-for="input-3">
        <b-form-select
          id="input-3"
          v-model="form.roles"
          :options="roles"
          required
        ></b-form-select>
      </b-form-group>
      <label for="text-password">Mot de passe</label>
      <b-form-input type="password" id="text-password" aria-describedby="password-help-block" v-model="form.password"></b-form-input>
      <b-form-text id="password-help-block">
        Votre mot de passe doit contenir 8 carateres au minimum 
      </b-form-text>
      <label for="text-password-confirm">Confirmation de mot de passe</label>
      <b-form-input type="password" id="text-password-confirm" aria-describedby="password-help-block" v-model="form.confirmPassword"></b-form-input>
      <b-form-text id="password-help-block">
        {{warningMissMatch}}
      </b-form-text>

      <!--<b-form-group id="input-group-4" v-slot="{ ariaDescribedby }">
        <b-form-checkbox-group
          v-model="form.checked"
          id="checkboxes-4"
          :aria-describedby="ariaDescribedby"
        >
          <b-form-checkbox value="me">Check me out</b-form-checkbox>
          <b-form-checkbox value="that">Check that out</b-form-checkbox>
        </b-form-checkbox-group>
      </b-form-group>-->

      <b-button type="submit" variant="primary" class="my-2 btn-dash-blue">Enreigistrer</b-button>
    </b-form>
    <!--<b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ form }}</pre>
    </b-card>-->
  </div>
</template>

<script>
  import Header from '../components/Header';
  export default {
    components: {
      Header
    },
    data() {
      return {
        title: "Creation d'un utilisateur",
        iconClass: 'fas fa-plus-square',
        form: {
          username: '',
          name: '',
          roles: null,
          email: '',
          password: '',
          confrimPassword: '',
          checked: []
        },
        roles: [{ text: 'Choir un role', value: null }, 'Admininstrateur', 'Utilisateur'],
        show: true
      }
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        alert(JSON.stringify(this.form))
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.name = ''
        this.form.food = null
        this.form.checked = []
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    },
    computed: {
      warningMissMatch() {
        return this.form.password === this.form.confrimPassword ? '' : 'Les mot de passes ne correspondent pas'
      }
    }
  }
</script>

<style>
  .main {
    padding: 10px 3%;
  }
  .bg-light {
    background-color: white !important;
    border-radius: 10px;
  }
</style>
