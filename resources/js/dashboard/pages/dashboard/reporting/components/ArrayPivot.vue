<template>
  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th></th>
        <th
          v-for="question in cloneOptionQuestions"
          :key="'header-question-' + question.id"
        >
          {{question.name}}
        </th>
      </tr>
    </thead>
    <tbody>
        <tr v-for="axe in cloneOptionsAxes" :key="'axe-' + axe.id">
            <td>{{axe.name}}</td>
            <td
              v-for="question in cloneOptionQuestions"
              :key="'question-' + axe.id + '-axe-' + question.id"
            >
              {{getCompletedFormField(axe.id, question.id)}}
            </td>
        </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  props: {
    cloneOptionsAxes: {
      type: Array,
      default: () => []
    },
    cloneOptionQuestions: {
      type: Array,
      default: () => []
    },
    completedFormFields: {
      type: Array,
      default: () => []
    }
  },

  data () {
    return {
      completeForm: this.completedFormFields || {}
    }
  },

  watch: {
    cloneOptionsAxes () {
      this.completeForm = {}
    },
    cloneOptionQuestions () {
      this.completeForm = {}
    },
    completedFormFields () {
      this.completeForm = this.completedFormFields || {}
    }

  },
  methods: {
    getCompletedFormField (hospitalId, questionId) {
      const hospitals = this.completeForm.find((hospital) => hospital.id === hospitalId)
      if (hospitals) {
        const completedFormField = hospitals.aggregated.find((question) => question.form_field.id === questionId)
        return completedFormField?.value || '-'
      } else {
        return '-'
      }
    }

  }
}
</script>
