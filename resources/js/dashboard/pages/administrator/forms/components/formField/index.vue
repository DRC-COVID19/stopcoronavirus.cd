<template>
  <div>
    <b-card>
      <b-card-body class="py-0">
        <div class="d-flex justify-content-between align-items-center">
          <strong class="mb-0">
            CHAMPS
          </strong>
        </div>
      </b-card-body>
    </b-card>
    <b-card class="mt-4">
      <b-card-body>
        <Form />
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import Form from './Form'
export default {
  components: {
    Form
  }
}
</script>
