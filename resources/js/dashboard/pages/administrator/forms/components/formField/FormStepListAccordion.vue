<template>
<div>
<div >
  <b-card v-for="(step,index) in formListSteps" :key="index"  class="mb-1"  role="tab">
  <b-card-header b-card-header v-b-toggle='"collapse-form-list-step"+step.id' @click="formStepFilter(step.id)">
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
           {{ step.form_step_id == 'null' ? 'Bonjour': step.title }}
          </span>
          <i  class="fas fa-chevron-down "  @click="formStepFilter(step.id)" aria-hidden="true"></i>
      </div>
  </b-card-header>
      <b-collapse :id='"collapse-form-list-step"+step.id' class="mt-2" accordion="my-accordion" role="tabpanel">
        <b-card-body >
           <b-form-group
              v-for="(item, index) in formFieldSorted"
              :key="index"
              :label="item.name"
              :label-for="item.name"
            >
            <b-form-group  v-slot="{ ariaDescribedby }" v-if="item.form_field_type.name === 'boolean'">
              <b-form-radio-group
                :options="requiredOptions"
                :aria-describedby="ariaDescribedby"
                id="required"
              ></b-form-radio-group>
            </b-form-group>
              <b-form-input
                v-else
                :type="item.form_field_type.name"
                :placeholder="`Entrer ${item.name}`"
              ></b-form-input>
           </b-form-group>
        </b-card-body>
      </b-collapse>
</b-card>
</div>

<div>
  <b-card  class="mb-1"  role="tab">
  <b-card-header b-card-header v-b-toggle.collapse-form-list-step-null>
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
           {{  'Pas d\'étape '}}
          </span>
          <i  class="fas fa-chevron-down " aria-hidden="true"></i>
      </div>
  </b-card-header>
      <b-collapse id="collapse-form-list-step-null" class="mt-2" accordion="my-accordion" role="tabpanel">
        <b-card-body >
           <b-form-group
              v-for="(item, index) in formFieldNoSteps"
              :key="index"
              :label="item.name"
              :label-for="item.name"
            >
            <b-form-group  v-slot="{ ariaDescribedby }" v-if="item.form_field_type.name === 'boolean'">
              <b-form-radio-group
                :options="requiredOptions"
                :aria-describedby="ariaDescribedby"
                id="required"
              ></b-form-radio-group>
            </b-form-group>
              <b-form-input
                v-else
                :type="item.form_field_type.name"
                :placeholder="`Entrer ${item.name}`"
              ></b-form-input>
           </b-form-group>
        </b-card-body>
      </b-collapse>
</b-card>
</div>
</div>
</template>
<script>
import { mapState } from 'vuex'

export default {
  name: 'FormStepListAccordion',
  props: {
    targetForm: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      formFieldFilter: [],
      requiredOptions: [
        { text: 'Oui', value: 1 },
        { text: 'Non', value: 0 }
      ]
    }
  },
  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps

    }),
    formListSteps () {
      return this.formSteps
    },
    formFieldSorted () {
      return this.formFieldFilter ? this.formFieldFilter.slice().sort((a, b) => a.order_field - b.order_field) : []
    },
    formFieldNoSteps () {
      // eslint-disable-next-line camelcase
      return this.targetForm.form_fields.filter(({ form_step_id }) => {
        // eslint-disable-next-line camelcase
        return form_step_id == null
      })
    }
  },
  mounted () {
  },
  methods: {
    formStepFilter (id) {
      // eslint-disable-next-line camelcase
      this.formFieldFilter = this.targetForm.form_fields.filter(({ form_step_id }) => {
        // eslint-disable-next-line camelcase
        return form_step_id === id
      })
    }
  }
}
</script>
