<template>
  <div>
    <b-container>
      <b-row class="mt-4">
        <b-col cols="12">
          <h3>Gestion des conflicts</h3>
        </b-col>
      </b-row>
      <b-row>
        <b-col
         cols="12"
         md="auto"
          class="d-md-flex form-filters w-100 justify-content-md-end"
         >
         <div  class="ml-md-2">
          <label for="input-formulaire" class="small text-muted">Filter par formulaire</label>
          <br />
          <v-select
            v-model="form.form_id"
            :options="formList"
            :reduce="(form) => form.id"
            :clearable="false"
            :searchable="false"
            label="title"
            class="mr-md-2"
            id="input-formulaire"
            @input="onFormFilterChange"
          >
          </v-select>
        </div>
          <div class="ml-md-2">
            <label for="input-user" class="small text-muted"
            >Filter par date</label>
            <br/>
      <v-date-picker
        v-model="form.date_conflict"
         @input="onFiltersChange"
      >
        <template v-slot="{ inputEvents, inputValue }">
          <div class="d-flex">
            <input type="hidden" v-model="form.date_conflict">
            <b-form-input
              :value="inputValue ? moment(form.date_conflict).format('YYYY-MM-DD') : 'Sélectionner la date'"
              v-on="inputEvents"
              class="date-picker-input"
              placeholder="Sélectionner la date"
              readonly
            >
            </b-form-input>
            <b-button
              class='button-icon'
              variant="primary"
              :disabled="!form.date_conflict"
              @click="form.date_conflict = null"
            >
              <i class="fa fa-close" aria-hidden="true"></i>
            </b-button>
          </div>
        </template>
      </v-date-picker>
          </div>
        </b-col>
      </b-row>
      <b-row class="mt-4">
        <b-col >
          <b-table
          class="completed-form-table"
          :busy="isLoading"
          :fields="fields"
          :items="completedFormHistorie.data"
          :sort-by="sortBy"
          :sort-desc="sortDesc"
          no-local-sorting
          responsive
          hover
          striped
          show-empty
          @sort-changed="sortingChanged"
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
          <template v-slot:cell(status)="data">
            <b-badge v-if="data.item.conflict" pill variant="danger">Non résolus</b-badge>
            <b-badge v-else pill variant="success">Résolus</b-badge>
          </template>
          <template v-slot:cell(last_update)="data">
            {{moment(data.item.last_update).format('DD/MM/Y')}}
          </template>
          <template v-slot:cell(created_at)="data">
            {{moment(data.item.created_at).format('DD/MM/Y')}}
          </template>
          <template v-slot:cell(actions)="data">
            <b-button
              v-if="data.item.conflict"
              variant="outline-primary"
              class="btn-dash mb-1 mb-lg-0"
              :to="{
                name: 'admin.conflict.form.detail',
                params: {
                  id: data.item.id,
                  form_id:data.item.form_id,
                  hospital_id:data.item.hospital_id,
                  form_title:data.item.form.title,
                  hospital_name:data.item.hospital.name,
                  last_update:data.item.last_update,
                  field_histories:data.item.completed_form_field_histories
                }
              }"
            >
              Details
            </b-button>
          </template>
        </b-table>
        </b-col>
      </b-row>
      <Pagination
      class="mb-4"
      :total-rows="totalRows"
      :per-page="perPage"
      :page="currentPage"
      @pageChanged="onPageChange"
      @perPageChanged="onPerPageChange"
    />
    </b-container>
  </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
import Pagination from '../../components/Pagination'
export default {
  components: { Pagination },
  data () {
    return {
      completedFormHistorie: {},
      isLoading: false,
      allCurrentFilters: {},
      form: {},
      perPage: 15,
      sortBy: 'last_update',
      sortDesc: true
    }
  },
  async mounted () {
    await this.form__index()
    this.getCompletedFormHistories()
  },
  computed: {
    ...mapState({
      completedFormHistories: state => state.completedFormHistory.completedFormHistories,
      formsIndex: state => state.form.formsIndex
    }),
    totalRows () {
      return this.completedFormHistorie?.total || 0
    },
    currentPage () {
      return this.completedFormHistorie?.current_page || 1
    },
    formList () {
      return [{ id: null, title: 'Tous' }, ...this.formsIndex]
    },
    fields () {
      const data = [
        { key: 'status', label: 'Status', sortable: true },
        { key: 'created_manager_name', label: 'Nom', sortable: true },
        { key: 'created_manager_first_name', label: 'Prénom', sortable: true },
        { key: 'form.title', label: 'Formulaire', sortable: true },
        { key: 'last_update', label: 'Récolte du', sortable: true },
        { key: 'created_at', label: 'Enregistrer le ', sortable: true },
        { key: 'actions', label: 'Actions' }
      ]
      return data
    }
  },
  methods: {
    ...mapActions(['completedFormHistoryIndex', 'form__index']),
    async getCompletedFormHistories (page = 1) {
      this.isLoading = true
      try {
        this.allCurrentFilters = {
          page,
          form_id: this.form.form_id,
          per_page: this.perPage,
          date_conflict: this.form.date_conflict,
          sort_by: this.sortBy,
          sort_desc: this.sortDesc ? 1 : 0
        }
        this.completedFormHistorie = await this.completedFormHistoryIndex(this.allCurrentFilters)
        this.isLoading = false
      } catch (error) {
        this.isLoading = false
      }
    },
    onPageChange (page) {
      this.getCompletedFormHistories(page)
    },
    onPerPageChange (perPage) {
      this.perPage = perPage
      this.getCompletedFormHistories()
    },
    async onFormFilterChange () {
      await this.completedFormHistoryIndex({ form_id: this.form.form_id })
      this.getCompletedFormHistories()
    },
    onFiltersChange () {
      this.getCompletedFormHistories(1)
    },
    sortingChanged (ctx) {
      this.sortBy = ctx.sortBy
      this.sortDesc = ctx.sortDesc
      this.getCompletedFormHistories()
    }
  }
}
</script>

<style lang="scss" scoped>
 @import "@~/sass/_variables";

 .completed-form-table {
  &::v-deep {
    thead {
      background-color: $dash-blue;
      color: white;
    }
    tbody {
      tr {
        &:nth-child(2n) {
          background-color: white;
        }
        &:nth-child(2n + 1) {
          background-color: rgba(0, 0, 0, 0.02);
        }
      }
    }
  }
}
.form-filters {
  > div {
    margin-bottom: 10px;
  }
  select,
  input,
  .v-select {
    width: 200px;
    height: 38px;
    background-color: white;
    @media (max-width: $max-width) {
      width: 100%;
    }
  }
  .v-select {
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

  button.button-icon {
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
    background-color: $dash-blue;
  }
  .form-control[readonly] {
    background-color: white;
  }
  .date-picker-input {
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
  }
}

</style>
