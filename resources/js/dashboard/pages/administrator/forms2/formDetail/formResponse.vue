<template>
  <b-container class="form-response">
    <b-row>
      <b-col cols="12">
        <b-card class="infos-card default-card">
          <div class="d-flex flex-wrap position-relative">
            <b-col cols="12" lg="6" class="response-text text-center text-lg-left">
              <h3> {{ totalCompletedForm }} réponse(s) </h3>
            </b-col>
            <b-col cols="12" class="text-center recurrence-text">
              <h3> Récurrence: <strong> {{ form.form_recurrence.name }} </strong> </h3>
            </b-col>
          </div>
        </b-card>
      </b-col>
    </b-row>

    <b-row>
      <b-col cols="12">
        <CompletedFormList
          :formId="$route.params.form_id"
          :showNewAction="false"
          :showFormColumn="false"
          :showFormFilter="false"
          @totalChanged="updateTotalCompletedForm"
        />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import CompletedFormList from '../../../../components/completedForm/CompletedFormList'
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      form: {},
      totalCompletedForm: 0
    }
  },
  components: {
    CompletedFormList
  },
  async mounted () {
    this.form = await this.formShow({ id: this.$route.params.form_id })
  },
  methods: {
    ...mapActions(['formShow']),
    updateTotalCompletedForm(value) {
      this.totalCompletedForm = value
    }
  }
}
</script>

<style lang="scss" scoped>
  @import "@~/sass/_variables";
  .form-response {
    padding-top: 60px;
    .infos-card {
      padding: 50px 20px;
      margin-bottom: 40px;
      .response-text {
        @media (min-width: 992px) {
          position: absolute;
        }
      }
      .recurrence-text {
        strong {
          color: $dash-red;
        }
      }
    }
  }
</style>@m
