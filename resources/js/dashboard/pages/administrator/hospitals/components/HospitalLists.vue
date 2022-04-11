<template>
  <b-container fluid>
    <b-row no-gutters class="mb-3">
      <b-col cols="12" md="12 d-flex flex-row-reverse justify-content-between">
        <div class="container-filter">
          <b-form-input
            v-model="filter"
            debounce="1500"
            class="input-dash input-filter"
            type="search"
            placeholder="Filtrer"
          ></b-form-input>
        </div>
        <b-button
          @click="openToogle()"
          v-b-toggle.sidebar-right
          class="btn btn-sm btn-dash-blue d-block"
          >Nouveau</b-button
        >
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="12">
        <b-skeleton-table
          v-if="isLoading"
          :rows="15"
          :columns="5"
          :table-props="{ bordered: false, striped: true, responsive: true }"
        ></b-skeleton-table>
        <b-table
          v-else
          responsive
          striped
          hover
          :fields="fields"
          :items="hospitals.data"
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template #table-busy>
            <div
              class="
                align-items-center
                d-flex
                justify-content-center
                my-2
                text-center text-danger
                loading-height
              "
            >
              <b-spinner class="align-middle"></b-spinner>
              <strong>Loading...</strong>
            </div>
          </template>
          <template v-slot:cell(actions)="data" class="action-btn-group">
            <b-button
              variant="outline-success mb-1"
              class="my-1 btn-dash"
              @click="
                updateHospital(
                  data.item.name,
                  data.item.id,
                  data.item.longitude,
                  data.item.latitude,
                  data.item.township,
                  data.item.agent
                )
              "
              v-b-toggle.sidebar-right
              >Editer</b-button
            >
          </template>
          <template #cell(name)="data">
            <span>{{ data.value.toUpperCase() }}</span>
          </template>
          <template #cell(township)="data">
            <span class="mx-1 my-1">{{ data.value.name }}</span>
          </template>
          <template #cell(agent)="data">
            <span class="mx-1 my-1">{{ data.value.name }}</span>
          </template>
        </b-table>
      </b-col>
    </b-row>
    <b-modal v-model="isDeleteModalShown" centered hide-header>
      <template #modal-header>
        <div class="mx-auto">
          <h5 class="lead text-secondary">
            DESAFFECTATION D'UN AGENT A UN CTCO
          </h5>
        </div>
      </template>
      <div class="col-12">
        <div class="mx-5 my-2">
          Voulez-vous rétirer
          <strong>{{ currentAgent.name.toUpperCase() }}</strong> au CTCO
          <strong>{{ currentHospital.name }}</strong> ?
        </div>
      </div>
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
    hospitals: {
      type: Object,
      default: () => ({}),
      required: false,
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      fields: [
        { key: "name", label: "Nom" },
        { key: "township", label: "Commune" },
        { key: "agent", label: " Agent Attitré" },
        { key: "actions", label: "Action" },
      ],
      filter: "",
      perPage: 15,
      currentPage: 1,
      isDeleteModalShown: false,
      currentHospital: {
        id: -1,
        name: "",
      },
      currentAgent: {
        id: -1,
        name: "",
      },
      editModalShow: false,
    };
  },
  computed: {
    rows() {
      return this.hospitals.length;
    },
  },
  watch: {
    filter() {
      this.search();
    },
  },
  methods: {
    search() {
      this.$emit("onSearch", this.filter.trim());
    },
    deleteHospital(name, HospitalId, agent) {
      this.isDeleteModalShown = true;
      this.currentHospital.id = HospitalId;
      this.currentHospital.name = name;
      this.currentAgent.name = agent.name;
    },
    openToogle() {
      this.$emit("openToogle", false);
    },
    onValidateDelection() {
      this.$emit("onDeleteHospital", this.currentHospital.id);
      this.isDeleteModalShown = false;
    },
    onCancelDelection() {
      this.isDeleteModalShown = false;
    },
    updateHospital(name, id, longitude, latitude, township, agent) {
      this.currentHospital = {
        id,
        name,
        longitude,
        latitude,
        township,
        agent,
      };
      this.$emit("onUpdateHospital", this.currentHospital);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.input-filter {
  background: white;
}
.fa-user-times {
  color: $dash-red;
  font-size: 16px;
}
.loading-height {
  height: 660px;
}
.fa-user-edit {
  color: $fin-8;
  font-size: 16px;
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
