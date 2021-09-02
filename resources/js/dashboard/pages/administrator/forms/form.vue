<template>
  <b-container>
      <b-row  class="mb-3 mt-4">
        <b-col cols="12" md="5" lg="4">
          <b-col cols="12" class="p-0">
            <b-card>
              <b-list-group flush>
                <b-list-group-item>
                  <small class="text-muted"> Nom du formulaire </small> <br>
                  <span> {{form.title}} </span>
                </b-list-group-item>
                <b-list-group-item>
                  <small class="text-muted"> Réccurence </small> <br>
                  <span> {{form.form_recurrence.name}} </span>
                </b-list-group-item>
                <b-list-group-item
                  v-if="form.form_recurrence_value"
                >
                  <small class="text-muted"> Valeur de la recurrence </small> <br>
                  <span> {{form.form_recurrence_value}} </span>
                </b-list-group-item>
                <b-list-group-item>
                  <small class="text-muted"> Statut de publication </small> <br>
                  <span> {{ form.publish ? 'Publié' : 'Non publié' }} </span>
                </b-list-group-item>
                <b-list-group-item>
                  <small class="text-muted"> Date de création </small> <br>
                  <span> {{ formatDateFns(form.created_at) }} </span>
                </b-list-group-item>
              </b-list-group>
              <b-card-footer>
                <a href="#" class="card-link d-flex justify-content-between align-items-center">
                  Aperçu
                  <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
              </b-card-footer>
            </b-card>
          </b-col>
        </b-col>
        <b-col cols="12" md="7" lg="8">
          <FormFieldIndex />
        </b-col>
      </b-row>
  </b-container>
</template>
<script>
import { mapActions } from 'vuex'
import FormFieldIndex from './components/formField/Index.vue'
export default {
  components: {
    FormFieldIndex
  },
  data(){
    return{
      form:{}
    }
  },

  mounted(){
    this.init()

  },

  methods:{
     ...mapActions([
       "showForm"
     ]),

    async init () {
      this.form = await this.showForm({ id: this.$route.params.form_id })
    }

  }

}
</script>

<style lang="scss" scoped>
.card-footer{
  border-top: none;
  a {
    text-decoration: none;
  }
}
</style>
