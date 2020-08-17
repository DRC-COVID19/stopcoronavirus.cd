<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <b-row>
        <b-col v-if="user && user.hospital">
          <h3>
            Situations hospitalières
            <b-link :to="{name:'hospital.data'}">
              <span class="fa fa-edit"></span>
            </b-link>
          </h3>
          <b-alert show variant="info">
            <div>{{`Structure: ${user.hospital.name}`}}</div>
            <p v-if="user.hospital.address">{{`Adresse: ${user.hospital.address}`}}</p>
            <p v-if="hospitalManagerName">Connecté en tant que {{hospitalManagerName}}</p>
          </b-alert>
        </b-col>
      </b-row>
      <b-row class="mt-4 mb-4">
        <b-col>
          <b-button :to="{name:'hospital.create'}" class="btn-dash-blue">Nouveau</b-button>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-table
            :busy="ishospitalSituationLoading"
            :fields="fields"
            :items="hospitalSituations.data"
            show-empty
          >
            <template v-slot:empty="scope">
              <h4>{{ scope.emptyText }}</h4>
            </template>
            <template v-slot:table-busy>
              <div class="text-center text-danger my-2">
                <b-spinner class="align-middle" />
                <strong>Loading...</strong>
              </div>
            </template>
            <template v-slot:cell(last_update)="data">
              <span>{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
            </template>
            <template v-slot:cell(actions)="data">
              <b-button
                size="sm"
                class="btn-dash-blue mb-1"
                :to="{
                  name:'hospital.detail',
                  params:{
                      update_id:data.item.id,
                    hospital_id: $route.params.hospital_id || 0
                    }
                    }"
              >Details</b-button>
              <b-button
                class="btn btn-warning mb-1"
                :to="{
                  name: 'hospital.edit',
                  params: {
                    hospital_id: data.item.id
                  }
                }"
              >Edit</b-button>
            </template>
          </b-table>
        </b-col>
      </b-row>
      <b-row align-h="end">
        <b-col lg="6">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            class="my-0 mb-3 justify-content-end"
            @change="onPageChange"
          />
        </b-col>
      </b-row>
    </b-container>
    <ManagerUserName id="nameModal" />
  </div>
</template>

<script>
import Header from "../../components/hospital/Header";
import ManagerUserName from "../../components/hospital/ManagerUserName";
import { mapState, mapMutations } from "vuex";
export default {
  components: {
    Header,
    ManagerUserName,
  },
  data() {
    return {
      fields: [
        { key: "last_update", label: "Date" },
        { key: "confirmed", label: "Confirmés" },
        { key: "actions", label: "Actions" },
      ],
      hospitalSituations: {},
      ishospitalSituationLoading: false,
      currentPage: 1,
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
    }),
    totalRows() {
      if (this.hospitalSituations.meta) {
        return this.hospitalSituations.meta.total;
      }
      return null;
    },
    perPage() {
      if (this.hospitalSituations.meta) {
        return this.hospitalSituations.meta.per_page;
      }
      return 15;
    },
  },
  mounted() {
    this.getHospitalSituations();
    if (!this.hospitalManagerName) {
      this.$bvModal.show("nameModal");
    }
  },
  methods: {
    ...mapMutations(["setDetailHospital", "setHospitalManagerName"]),
    getHospitalSituations(page=1) {
      this.ishospitalSituationLoading = true;
      axios.get("/api/dashboard/hospital-situations",
      {params : {page} }).then(({ data }) => {
        this.hospitalSituations = data;
        this.ishospitalSituationLoading = false;
      });
    },
    onPageChange(page) {
      this.getHospitalSituations(page)
    },
  },
};
</script>

<style>
</style>
