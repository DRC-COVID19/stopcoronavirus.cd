<template>
  <div class="px-5">
    <b-container fluid class="px-3">
      <b-row class="mt-4">
        <b-col cols="12" md>
          <h3>Résumé mise à jour CTCOS</h3>
        </b-col>
        <b-col cols="12" md="auto" class="d-flex">
          <v-select
            v-model="selectedForm"
            :options="formList"
            :reduce="form => form.id"
            :clearable="false"
            :searchable="false"
            label="title"
            class="mr-2"
          >
          </v-select>
          <b-button class="btn-dash-blue btn-dash" @click.prevent="refreshData()">
            <i class="fa fa-sync" aria-hidden="true"></i>
          </b-button>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" class="mt-4">
          <b-table
            :busy="isLoading"
            :fields="fields"
            responsive
            hover
            :items="completedFormsSorted"
            show-empty
          >
            <template v-slot:empty="scope">
              <h4>{{ scope.emptyText }}</h4>
            </template>
            <template v-slot:table-busy>
              <div class="text-center text-danger my-2">
                <b-spinner class="align-middle" />
                <strong>Chargement des données...</strong>
              </div>
            </template>

            <template v-slot:cell(statut)="data">
             <div v-if="data.item.diff_date < 2 && data.item.diff_date >= 0" class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#8BC34A'">

                </span>
                <span class="ml-4">À jour</span>
             </div>
             <div v-else-if="data.item.diff_date >=2 && data.item.diff_date <= 3" class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#f08c2e'">

                </span>
                <span class="ml-4">Retard de {{ data.item.diff_date }} jours</span>
             </div>
             <div v-else-if="data.item.diff_date > 3" class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#F44336'">

                </span>
                <span class="ml-4">Retard de {{ data.item.diff_date }} jours </span>
             </div>
             <div v-else class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#888888'">

                </span>
                <span class="ml-4">Jamais mis à jour </span>
             </div>
            </template>
            <template v-slot:cell(created_manager)="data">
              <span v-if="data.item.completed_forms[0]">{{ data.item.created_manager_name }} {{ data.item.created_manager_first_name }}</span>
              <span v-else> - </span>
            </template>
            <template v-slot:cell(last_update)="data">
              <span v-if="data.item.last_update">{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
              <span v-else>-</span>
            </template>
            <template v-slot:cell(form)="data">
              <span v-if="data.item.completed_forms[0]">{{ data.item.completed_forms[0].form.title }}</span>
              <span v-else>-</span>
            </template>
            <template v-slot:cell(actions)="data">
              <b-button
               variant="outline-primary"
                class="mb-1 btn-dash"
                :to="{
                  name:'hospital.admin.data',
                  params:{
                    hospital_id: data.item.id
                  }
                }"
                v-if="data.item.last_update"
                >Details</b-button>
            </template>
          </b-table>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex'

export default {
  components: {},
  data () {
    return {
      fields: [
        { key: 'statut', label: 'Statut' },
        { key: 'last_update', label: 'Date' },
        { key: 'name', label: 'Nom CTCO' },
        { key: 'created_manager', label: 'Soumis par' },
        { key: 'form', label: 'Formulaire' },
        { key: 'actions', label: 'Action' }
      ],
      completedForms: [],
      isLoading: false,
      selectedForm: null
    }
  },
  computed: {
    ...mapState({
      completedForm__selectedForm: (state) => state.completedForm.selectedForm
    }),
    completedFormsSorted () {
      return this.completedForms.slice().sort((a, b) => {
        const hospitalNameA = a.name.toLowerCase()
        const hospitalNameB = b.name.toLowerCase()
        if (hospitalNameA < hospitalNameB) return -1
        if (hospitalNameA > hospitalNameB) return 1
        return 0
      }).sort((a, b) => new Date(b.last_update) - new Date(a.last_update))
    },
    formList () {
      return [
        { id: null, title: 'Tous' },
        ...this.form__publishedForms()
      ]
    }
  },
  mounted () {
    this.selectedForm = this.completedForm__selectedForm
    this.getForms()
    this.refreshData()
  },
  watch: {
    selectedForm (value) {
      this.completedForm__setSelectedForm(value)
      this.refreshData()
    }
  },
  methods: {
    ...mapActions([
      'completedForm__getAllByLastUpdate',
      'completedForm__setSelectedForm',
      'getForms'
    ]),
    ...mapGetters(['form__publishedForms']),
    async refreshData () {
      this.isLoading = true
      this.completedForms = await this.completedForm__getAllByLastUpdate({
        form_id: this.completedForm__selectedForm
      })
      if (this.completedForms.length > 0) {
        this.isLoading = false
      }
    }

  }
}
</script>

<style>

</style>
<style lang="scss" scoped>
  .badge-statut{
    content: "";
    display: block !important;
    width: 20px;
    height: 20px;
    width: 30px;
    height: 30px;
    box-shadow: 0px 0px 10px rgba(0,0,0,.2);
  }
  .v-select {
    width: 200px;
    height: 38px;
    background-color: white;
    &::v-deep {
        .vs__dropdown-toggle {
        height: 100%;
      }
       .vs__selected {
        white-space: nowrap;
        width: 165px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
      }
    }

  }
</style>
