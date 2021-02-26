<template>

</template>

<script>
export default {
  props: {
    id:{
      type:String,

    },
    message: {
      type: String,
      required: true,
    },
  },

  methods:{
    onValidate(){
      this.$emit('onValidate')
    },
    onCancel(){
      this.$emit('onCancel');
    }
  }
};
</script>

<style>
</style>
