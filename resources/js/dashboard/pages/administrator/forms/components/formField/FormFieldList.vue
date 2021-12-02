<template>
  <div>
    <b-card>
      <b-card-header v-b-toggle.collapse-form-field-list>
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-muted">
            Liste des champs
          </span>
          <i class="fas fa-chevron-down" aria-hidden="true"></i>
        </div>
      </b-card-header>
      <b-collapse id="collapse-form-field-list" class="mt-2" visible>
        <b-card-body>
            <FormStepListAccordion :targetForm="targetForm"/>
        </b-card-body>
      </b-collapse>
    </b-card>
  </div>
</template>

<script>
import FormStepListAccordion from './FormStepListAccordion.vue'

export default {
  components: {
    FormStepListAccordion
  },
  props: {
    targetForm: {
      type: Object,
      required: true
    }
  }
}
</script>
