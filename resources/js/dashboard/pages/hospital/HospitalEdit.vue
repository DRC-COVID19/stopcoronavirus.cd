/* eslint-disable space-before-blocks */
<template>

          <form-wizard
            title="FORMULAIRE"
            subtitle
            shape="tab"
            color="#2e5bff"
            nextButtonText="Suivant"
            backButtonText="Précédent"
            finishButtonText="Modifier"
            @on-complete="onComplete"
            :startIndex="0"
          >
            <b-alert variant="success" v-if="!!isLoading" show
              >L'insertion reussi avec success</b-alert
            >
            <tab-content
              v-for="(step, index) in targetForm.form_steps"
              :key="index"
              v-else
            >
              <h3 class="mb-4 text-center">{{ step.title }}</h3>
              <b-row align-h="center">
                <b-col cols="12" md="8">
                  <b-form-group
                    v-for="(item, counter) in formFieldSorted(step.id)"
                    :key="counter"
                    :label="
                      item.roules !== null
                        ? item.form_field_name + ' * '
                        : item.form_field_name
                    "
                    :label-for="item.form_field_name"
                  >
                    <b-row>
                      <b-col class="col-sm-12 col-md-12">
                        <b-form-group
                          v-slot="{ ariaDescribedby }"
                          v-if="item.form_field_type_name === 'boolean'"
                        >
                          <b-form-radio-group
                            :options="requiredOptions"
                            :aria-describedby="ariaDescribedby"
                            id="required"
                          ></b-form-radio-group>
                        </b-form-group>
                        <b-form-input
                          v-else
                          :type="item.form_field_type_name"
                          v-model="item.default_value"
                          :placeholder="`Entrer ${item.form_field_name}`"
                          required
                          @change="
                            handelChange(
                              item.id,
                              item.default_value,
                              item.form_field_name,
                              step.id
                            )
                          "
                          :id="item.form_field_name"
                        >
                        </b-form-input>
                      </b-col>
                    </b-row>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content v-if="formFieldNullStepSorted.length > 0">
              <h3 class="mb-4 text-center">Champs affectés à aucune étape</h3>
              <b-row align-h="center">
                <b-col cols="12" md="8">
                  <b-form-group
                    v-for="(field, counter) in formFieldNullStepSorted"
                    :key="counter"
                    :label="
                      field.roules !== null
                        ? field.form_field_name + ' * '
                        : field.form_field_name
                    "
                    :label-for="field.form_field_name"
                  >
                    <b-row>
                      <b-col class="col-sm-12 col-md-12">
                        <b-form-group
                          v-slot="{ ariaDescribedby }"
                          v-if="field.form_field_type.name === 'boolean'"
                        >
                          <b-form-radio-group
                            :options="requiredOptions"
                            :aria-describedby="ariaDescribedby"
                            id="required"
                          ></b-form-radio-group>
                        </b-form-group>
                        <b-form-input
                          v-else
                          :type="field.form_field_type.name"
                          v-model="field.default_value"
                          :placeholder="`Entrer ${field.form_field_name}`"
                          @change="
                            handelChange(
                                field.id,
                              field.default_value,
                              field.form_field_name,
                              step.id
                            )
                          "
                          :id="field.form_field_name"
                        >
                        </b-form-input>
                      </b-col>
                    </b-row>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col
                  v-for="(step, index) in targetForm.form_steps"
                  :key="index"
                  cols="12"
                  md="6"
                >
                  <h3 class="mb-4">{{ step.title }}</h3>

                  <div v-for="(summary, count) in editionData" :key="count">
                    <ul v-if="step.id === summary.form_step_id">
                      <li>{{ summary.form_field_name }} : {{ summary.default_value }}</li>
                    </ul>
                  </div>
                </b-col>
                <b-col class="col-md-12">
                  <b-alert show variant="warning">
                    <p class="text-center">
                      NB: Une soumission ne peut plus être modifiée après 24
                      heures.
                    </p>
                  </b-alert>
                </b-col>
                <b-form-group class="no-border">
                  <label for="last_update" class="text-dash-color"
                    >Sélectionnez la date</label
                  >
                  <b-form-datepicker
                    v-model="editionData[0].last_update"
                    :max="max"
                    required
                    id="last_update"
                    class="mb-2"
                    :disabled="!!$route.params.update_id"
                  ></b-form-datepicker>
                </b-form-group>
              </b-row>
            </tab-content>
          </form-wizard>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
export default {
  components: {
    FormWizard,
    TabContent
  },
  props: {
    user: {},
    targetForm: {},
    hospitalManagerName: {},
    formSteps: {},
    editionData: {},
    isHospitalSituationLoading: {}
  },
  data () {
    const now = new Date()
    return {
      formData: new Map(),
      formSummary: [],
      formDataFormatted: [],
      form: {
        items: [],
        fields: []
      },
      max: now,
      errors: {},
      isLoading: false
    }
  },
  computed: {
    formFieldNullStepSorted () {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields
          .slice()
          .sort((a, b) => a.order_field - b.order_field)
          .filter(item => item.form_step_id === null)
        : []
    }
  },

  methods: {
    formFieldSorted (id) {
      return this.editionData
        .slice()
        .sort((a, b) => b.order_field - a.order_field)
        ? this.editionData.filter(item => item.form_step_id === id)
        : []
    },

    onComplete () {
      this.$emit('onComplete', { formData: this.formData, lastUpdate: this.$route.params.update_id })
    },

    handelChange (key, value, fieldName, stepId) {
      this.editionData.forEach(item => {
        if (item.id === key) {
          item.default_value = value
          this.formData.set(key, value)
        }
      })
    }
  }
}
</script>
