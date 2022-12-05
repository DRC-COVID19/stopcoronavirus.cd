<template>
  <div class="card__Scroll">
    <div v-if="isLoading">
      <b-spinner :show="true" variant="danger" class="mr-5"
        >Chargement des fomulaires Récents...</b-spinner
      >
    </div>
    <div v-else v-for="(form, index) in recentForms" :key="index" class="px-2">
      <card-form-recent :route="getRoute(form)" :form="form" />
    </div>
  </div>
</template>

<script>
import CardFormRecent from '../../../../components/forms/CardForm.vue';
export default {
  components: {
    CardFormRecent,
  },
  props: {
    recentForms: {
      CardFormRecenttype: Array,
      default: () => [],
    },
    isLoading: {
      type: Boolean,
      default: () => false,
      required: false,
    },
  },
  methods: {
    getRoute(form) {
      return {
        name: 'administrator.forms.show.creation',
        params: {
          form_id: form.id,
        },
      };
    },
  },
};
</script>

<style lang="scss"></style>
