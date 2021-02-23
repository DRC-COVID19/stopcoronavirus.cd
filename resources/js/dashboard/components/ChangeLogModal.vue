<template>
  <b-modal :id="id" title="Change log">
    <b-container>
      <b-row>
        <b-col cols="12" md="12">
          <Timeline
            :timeline-items="getChangeLogNotRead"
            :message-when-no-items="messageWhenNoItems"
            dateLocale="fr-fr"
            class="timeline"
          />
        </b-col>
      </b-row>
    </b-container>
    <template #modal-footer="{ hide }">
      <b-link @click.prevent="gotoAboutPage" class="mr-3">Voir plus</b-link>
      <b-button size="sm" variant="success" @click="hide(id)">
        Fermer
      </b-button>
    </template>
  </b-modal>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import Timeline from "timeline-vuejs";
export default {
  components: {
    Timeline,
  },
  props: {
    id: {
      type: String,
      default: "message-modal-id",
    },
  },
  data() {
    return {
      messageWhenNoItems: "There are not items",
    };
  },
  computed: {
    ...mapGetters(["getChangeLogNotRead"]),
  },
  methods: {
    ...mapMutations(["setActiveMenu"]),
    gotoAboutPage() {
      this.setActiveMenu(7);
      this.$bvModal.hide(this.id);
    },
  },
};
</script>

<style>
</style>
