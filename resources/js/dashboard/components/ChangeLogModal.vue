<template>
  <b-modal size="lg" :id="id" title="Change log">
    <b-container>
      <b-row>
        <b-col
          cols="12"
          class="mb-0"
          v-for="(item, index) in getChangeLogNotRead.slice(0, 5)"
          :key="index"
        >
          <vue-timeline-update
            :date="new Date(item.from)"
            :dateString="moment(item.from).format('DD.MM.yyyy')"
            :title="item.title"
            dateLocale="fr"
            :description="item.description"
            icon="code"
            color="black"
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
import { mapGetters, mapMutations } from 'vuex';
import Timeline from 'timeline-vuejs';

export default {
  components: {
    Timeline,
  },
  props: {
    id: {
      type: String,
      default: 'message-modal-id',
    },
  },
  data() {
    return {
      messageWhenNoItems: 'There are not items',
    };
  },
  computed: {
    ...mapGetters(['getChangeLogNotRead']),
  },
  methods: {
    ...mapMutations(['setActiveMenu']),
    gotoAboutPage() {
      this.setActiveMenu(7);
      this.$bvModal.hide(this.id);
    },
  },
};
</script>

<style></style>
