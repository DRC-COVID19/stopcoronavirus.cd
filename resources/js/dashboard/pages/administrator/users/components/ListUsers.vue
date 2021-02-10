<template>
  <div>
    <b-row>
      <b-col md="3" class="d-flex justify-content-end">
        <b-form-input
          class="my-3"
          v-model="filter"
          type="search"
          placeholder='Recherche'
        ></b-form-input>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table striped hover :items="users" :filter="filter"></b-table>
      </b-col>
    </b-row>
  </div>
</template>

<script>
  export default {
    props: {
      users: {
        type: Array,
        required: true
      }
    },
    data () {
      return {
        filter: ''
      }
    }
  }
</script>