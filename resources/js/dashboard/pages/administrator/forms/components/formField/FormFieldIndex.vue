<template>
  <div>
    <b-card>
      <b-card-body class="py-0">
        <div class="d-flex justify-content-between align-items-center">
          <strong class="mb-0">
            CHAMPS
          </strong>
          <i class="fab fa-wpforms" aria-hidden="true"></i>
        </div>
      </b-card-body>
    </b-card>
    <FormFieldForm
      :target-form="form"
      @created="onCreatedFormStep"
      class="mt-4"
    />
    <FormFieldList 
      :target-form="form"
      class="mt-4"
    />
</div>
</template>

<script>
import { mapActions } from 'vuex'
import FormFieldForm from './FormFieldForm'
import FormFieldList from './FormFieldList'
export default {
  props: {
    form: {
      type: Object,
      required: true
    }
  },
  components: {
    FormFieldForm,
    FormFieldList
  },
  mounted () {
    this.init()
  },
  methods: {
    ...mapActions([
      'formShow'
    ]),
    onCreatedFormStep(){
        this.init()
    },
    async init () {
      this.form = await this.formShow({ id: this.form.id })
    }

  }
}
</script>
