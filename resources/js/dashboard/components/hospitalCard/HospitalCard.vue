<template>
  <b-container class="mx-0 px-0 container-preview" fluid>
    <b-row>
      <b-col lg="7" class="d-flex container-preview-back w-100 mb-3">
        <b-link><i class="fas fa-arrow-left"></i> Retour</b-link>
      </b-col></b-row
    >
    <b-row>
      <b-col
        lg="7"
        class="
          d-flex
          justify-content-center
          container-preview-title-form
          w-100
          mb-3
        "
      >
        <h3 class="text-white text-center">Titre</h3>
      </b-col>
    </b-row>
    <b-row>
      <b-col lg="17">
        <form-wizard
          subtitle
          shape="tab"
          color="#2e5bff"
          nextButtonText="Suivant"
          backButtonText="Précédent"
          @on-complete="onComplete"
        >
          <tab-content>
            <b-row align-h="center" class="mx-0 px-0">
              <b-col>
                <b-form-group>
                  <b-row class="w-100">
                    <b-col
                      lg="7"
                      class="
                        d-flex
                        justify-content-center
                        container-preview-field-form
                        w-100
                        mb-3
                      "
                    >
                      <form-field-input />
                    </b-col>
                  </b-row>
                </b-form-group>
              </b-col>
              <b-col cols="12" md="8"> </b-col>
            </b-row>
          </tab-content>
        </form-wizard>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormFieldInput from "../forms/FormFieldInput.vue";
export default {
  components: { FormFieldInput },
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.container-preview {
  padding-top: 3%;
  background: #f4f6fc;
  min-height: 100vh;
}
.container-preview-back {
  i {
    color: $dash-blue;
    font-size: 20px;
  }
}
.container-preview-title-form {
  background-color: $dash-blue;
  height: 150px;
  align-items: center;
  align-content: center;
}
.container-preview-field-form {
  background-color: white;
  height: 150px;
  border: 1px solid rgba(0, 0, 0, 0.26);
  border-radius: 5px;
  align-items: center;
  align-content: center;
}
</style>
