<template>
     <tab-content>
              <b-row align-h="center" >
                <b-col cols="12" md="6">
              <b-form-group
                  v-for="(item, index) in formFied"
                  :key="index"
                  :label="item.name"
                  :label-for="item.name"
                >
                  <b-row>
                    <b-col class="col-sm-12 col-md-12">
                      <b-form-group
                        v-slot="{ ariaDescribedby }"
                        v-if="item.form_field_type.name === 'boolean'"
                      >
                        <b-form-radio-group
                          :options="requiredOptions"
                          :aria-describedby="ariaDescribedby"
                          id="required"
                        ></b-form-radio-group>
                      </b-form-group>
                      <b-form-input
                        v-else
                        :v-model="item.form_field_type.name"
                        :type="item.form_field_type.name"
                        :value="item.default_value"
                        :placeholder="`Entrer ${item.name}`"
                        :id="item.name">
                      </b-form-input>
                    </b-col>
                  </b-row>
              </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
  name: 'HospitalCreateField',
  props: {
    formFied: {
      type: Object,
      required: true
    }
  },
  components: {
  },
  data () {
    return {
      formFieldFilter: [],
      requiredOptions: [
        { text: 'Oui', value: 1 },
        { text: 'Non', value: 0 }
      ],
      formStepsField: [],
      isDeleteModalShown: false,
      formFieldToDelete: ''
    }
  },
  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps
    }),
    formListSteps () {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.formStepsField = this.formSteps.slice()
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.formStepsField.push({
        id: null,
        title: 'Champs affectés à aucune étape'
      })
      return this.formStepsField
    },
    formFieldSorted () {
      return this.formFieldFilter
        ? this.formFieldFilter
          .slice()
          .sort((a, b) => a.order_field - b.order_field)
        : []
    }
  },
  mounted (
  ) {
    this.formFieldSorted()
  },
  methods: {
    ...mapActions(['removeFormField']),
    formStepFilter (id) {
      // eslint-disable-next-line camelcase
      this.formFieldFilter = this.targetForm.form_fields.filter((formField) => {
        return formField.form_step_id === id
      })
    }
  }

}
</script>

<style>

</style>
