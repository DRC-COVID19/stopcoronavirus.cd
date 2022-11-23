<template>
  <b-container>
    <loading
      v-if="isLoading"
      class="h-100"
      message="Chargement du Formulaire ..."
    />
    <b-row v-else class="mb-3 mt-4">
      <b-col cols="12" md="5">
        <b-col cols="12" class="p-0">
          <b-card>
            <b-list-group flush>
              <b-list-group-item>
                <small class="text-muted"> Nom du formulaire </small> <br />
                <span> {{ form.title }} </span>
              </b-list-group-item>
              <b-list-group-item v-if="form.form_recurrence">
                <small class="text-muted"> Réccurence </small> <br />
                <span> {{ form.form_recurrence.name }} </span>
              </b-list-group-item>
              <b-list-group-item v-if="form.form_recurrence_value">
                <small class="text-muted"> Valeur de la recurrence </small>
                <br />
                <span> {{ form.form_recurrence_value }} </span>
              </b-list-group-item>
              <b-list-group-item>
                <small class="text-muted"> Statut de publication </small> <br />
                <span> {{ form.publish ? 'Publié' : 'Non publié' }} </span>
              </b-list-group-item>
              <b-list-group-item>
                <small class="text-muted"> Date de création </small> <br />
                <span> {{ formatDateFns(form.created_at) }} </span>
              </b-list-group-item>
            </b-list-group>
            <b-card-footer>
              <a
                href="#"
                class="card-link d-flex justify-content-between align-items-center"
              >
                Aperçu
                <i class="fas fa-arrow-right" aria-hidden="true"></i>
              </a>
            </b-card-footer>
          </b-card>
        </b-col>
        <b-col cols="12" class="p-0">
          <FormStepIndex :formId="+$route.params.form_id" />
        </b-col>
      </b-col>
      <b-col cols="12" md="7">
        <FormFieldIndex
          :form="form"
          @formFieldCreated="onFormFieldCreated"
          @formFieldUpdated="onFormFieldUpdated"
          @formFieldDeleted="onFormFieldDeleted"
        />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { mapActions } from 'vuex';
import Loading from '../../../components/Loading.vue';
import FormFieldIndex from './components/formField/FormFieldIndex.vue';
import FormStepIndex from './components/formStep/FormStepIndex';

export default {
  components: {
    FormFieldIndex,
    FormStepIndex,
    Loading,
  },
  data() {
    return {
      isLoading: false,
      form: {},
    };
  },

  mounted() {
    this.init();
  },

  methods: {
    ...mapActions(['formShow']),
    async init() {
      this.isLoading = true;
      this.form = await this.formShow({ id: this.$route.params.form_id });
      if (this.form.length !== 0) {
        this.isLoading = false;
      }
    },
    onFormFieldCreated() {
      this.init();
    },
    onFormFieldUpdated() {
      this.init();
    },
    onFormFieldDeleted() {
      this.init();
    },
  },
};
</script>

<style lang="scss" scoped>
.card-footer {
  border-top: none;
  a {
    text-decoration: none;
  }
}
@media (min-width: 1200px) {
  .container-xl,
  .container-lg,
  .container-md,
  .container-sm,
  .container {
    max-width: 1400px;
  }
}
</style>
