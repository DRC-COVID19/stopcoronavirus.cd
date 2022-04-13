<template>
  <b-row
    align-h="center"
    align-v="center"
    class="wrap"
  >
    <b-col
      cols="12"
      class="loading-row"
    >
      <div class="lds-dual-ring" />
      <span class="text">{{ message }}</span>
    </b-col>
  </b-row>
</template>
<script>
export default {
  props: {
    message: {
      type: String,
      default: 'Loading...'
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.loading-row{
  height: 100%;
  align-items: center;
  justify-content: center;
  display: flex;
  .spinner{
      width: 3rem;
      height: 3rem;
  }
  .text{
      font-size: 1.5rem;

  }
}

.lds-dual-ring {
  display: inline-block;
  width: 64px;
  height: 64px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 1px;
  border-radius: 50%;
  border: 5px solid $dash-blue;
  border-color: $dash-blue transparent $dash-blue transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@media screen and($small){
    .text{
      font-size: 2rem;

  }
  }

</style>
