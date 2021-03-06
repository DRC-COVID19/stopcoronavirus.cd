<template>
  <b-container>
    <b-row class="my-3" align-h="start">
      <b-col cols="12" md="6">
        <b-form-datepicker
          label-today-button="Aujourd'hui"
          label-reset-button="Effacer"
          reset-button
          today-button
          v-model="filter"
          placeholder="Choisir la date"
          class="mb-2"
        >
        </b-form-datepicker>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <b-skeleton-table
          v-if="isLoading"
          :rows="15"
          :columns="10"
          :table-props="{ bordered: false, striped: true, responsive: true }"
        ></b-skeleton-table>

        <b-table
          v-else
          responsive
          striped
          hover
          :fields="fields"
          :items="situations.data"
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template #table-busy>
            <div
              class="align-items-center d-flex justify-content-center my-2 text-center text-danger loading-height"
            >
              <b-spinner class="align-middle"></b-spinner>
              <strong>Loading...</strong>
            </div>
          </template>
          <template v-slot:cell(actions)="data" class="action-btn-group">
            <i
              @click="
                editSituation(
                  data.item.id,
                  data.item.last_update,
                  data.item.confirmed,
                  data.item.sick,
                  data.item.dead,
                  data.item.healed,
                  data.item.imported,
                  data.item.local,
                  data.item.seriously
                )
              "
              class="mx-2 fas fa-edit"
            ></i>
            <i
              @click="deleteSituation(data.item.id)"
              class="mx-2 fas fa-trash"
            ></i>
          </template>
          <template v-slot:cell(last_update)="data">
            {{ moment(data.item.last_update).format("D MMMM YYYY") }}
          </template>
        </b-table>
      </b-col>
    </b-row>
    <b-modal v-model="isDeleteModalShown">
      Voulez-vous supprimer la mise à jour du
      {{ currentSituation.last_update }} ?
      <template #modal-footer>
        <b-button size="sm" variant="success" @click="onValidateDelection()">
          Accepter
        </b-button>
        <b-button size="sm" variant="danger" @click="onCancelDelection()">
          Annuler
        </b-button>
      </template>
    </b-modal>
  </b-container>
</template>

<script>
export default {
  props: {
    situations: {
      type: Object,
      default: () => ({}),
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      fields: [
        { key: "id", label: "ID" },
        { key: "last_update", label: "Date" },
        { key: "confirmed", label: "Confirme", sortable: true },
        { key: "sick", label: "Actifs", sortable: true },
        { key: "seriously", label: "Grave", sortable: true },
        { key: "healed", label: "Gueris", sortable: true },
        { key: "dead", label: "Deces", sortable: true },
        { key: "imported", label: "Importes", sortable: true },
        { key: "local", label: "Local", sortable: true },
        "actions",
      ],
      filter: "",
      perPage: 15,
      currentPage: 1,
      isDeleteModalShown: false,
      currentSituation: {
        last_update: "",
      },
      editModalShow: false,
    };
  },
  computed: {
    rows() {
      return this.situations.length;
    },
  },
  watch: {
    filter () {
      this.search();
    }
  },
  methods: {
    search () {
      this.$emit('onSearch', this.filter);
    },
    deleteSituation(id) {
      this.isDeleteModalShown = true;
      this.currentSituation.id = id;
    },
    editSituation(
      id,
      last_update,
      confirmed,
      sick,
      dead,
      healed,
      imported,
      local,
      seriously
    ) {
      this.currentSituation = {
        id,
        last_update,
        confirmed,
        sick,
        dead,
        local,
        imported,
        seriously,
        healed,
      };
      this.$emit("onEditSituation", this.currentSituation);
    },
    onValidateDelection() {
      this.$emit("onDeleteSituation", this.currentSituation.last_update);
      this.isDeleteModalShown = false;
    },
    onCancelDelection() {
      this.isDeleteModalShown = false;
    },
  },
};
</script>
<style lang='scss' scoped>
@import "@~/sass/_variables";
.loading-height {
  height: 660px;
}
.fa-edit {
  color: $fin-8;
  font-size: 18px;
}
.fa-trash {
  color: $fin-5;
  font-size: 18px;
}
.btn-remove {
  background-color: $dash-red;
}
.btn-edit {
  background-color: $fin-8;
}
.action-btn-group {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
}
</style>
