<template>
  <div>
    <b-card>
      <b-card-header v-b-toggle.collapse-form-field-list>
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-muted"> Liste des champs </span>
          <i class="fas fa-chevron-down" aria-hidden="true"></i>
        </div>
      </b-card-header>
      <b-collapse id="collapse-form-field-list" class="mt-2" visible>
        <b-card-body>
          <FormStepListAccordion
            :targetForm="targetForm"
            @deleted="onDeleted"
            @updateField="onUpdateFormField"
          />
        </b-card-body>
      </b-collapse>
    </b-card>
  </div>
</template>

<script>
import FormStepListAccordion from './FormStepListAccordion.vue';
export default {
  components: {
    FormStepListAccordion,
  },
  props: {
    targetForm: {
      type: Object,
      required: true,
    },
  },
  computed: {},
  data() {
    return {};
  },
  methods: {
    onDeleted() {
      this.$emit('onDeletedForm');
    },
    onUpdateFormField(value) {
      this.$emit('onUpdateFormField', value);
    },
  },
};
</script>
<style lang="scss" scoped>
@import '@~/sass/_variables';
.fas {
  cursor: pointer;
  padding: 0.5rem;
  transition: all 0.5 ease-out;
  &:hover {
    background: rgb(170, 175, 184);
    border-radius: 5px;
  }
}
</style>
