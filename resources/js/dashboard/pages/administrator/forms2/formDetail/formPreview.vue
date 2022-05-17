<template>
  <b-container class="mx-0 px-0 d-flex justify-content-center" fluid>
    <b-row class="w-100 h-100 mx-0 px-0">
      <b-col lg="12" class="w-100 mx-0 px-0">
        <FormView
          back-route-name="administrator.forms.show.creation"
          preview
        />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormView from '../../../../components/forms/FormView.vue'
export default {
  components: {
    FormView
  }
}
</script>

<style lang="scss" scoped>
