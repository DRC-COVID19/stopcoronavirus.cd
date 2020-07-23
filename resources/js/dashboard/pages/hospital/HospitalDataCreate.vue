<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center">
        <b-col cols="12" v-if="errors && errors.last_update">
          <b-alert variant="danger" dismissible show>{{errors.last_update[0]}}</b-alert>
        </b-col>
        <b-col cols="12">
          <b-link :to="{
            name:'hospital.home'
          }">
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Header from "../../components/hospital/Header";
import Loading from "../../components/Loading";
export default {
  components: {
    Header,
    Loading,
  },
};
</script>

<style>
</style>