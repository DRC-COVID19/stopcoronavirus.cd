<template>
  <div>
    <b-table striped hover :items="users"></b-table>
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
  }
</script>