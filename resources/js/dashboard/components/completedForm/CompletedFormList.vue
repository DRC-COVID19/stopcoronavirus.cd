<template>
  <div>
    <b-row class="mb-4">
      <b-col cols="12" md></b-col>
      <b-col cols="12" md="auto" class="d-flex form-filters flex-wrap justify-content-center">
        <div v-if="showUserFilter">
          <label for="input-user" class="small text-muted">Filter par utilisateur</label> <br>
          <b-form-select
            v-model="form.admin_user_id"
            :options="usersList"
            text-field="name"
            value-field="id"
            class="mr-2"
            id="input-user"
            @change="onFiltersChange"
          >
          </b-form-select>
        </div>
        <div v-if="showFormFilter">
          <label for="input-formulaire" class="small text-muted">Filter par formulaire</label> <br>
          <b-form-select
            v-model="form.form_id"
            :options="formList"
            text-field="title"
            value-field="id"
            class="mr-2"
            id="input-formulaire"
            @change="onFormFilterChange"
          >
          </b-form-select>
        </div>
        <div v-if="showHospitalFilter">
          <label for="input-ctco" class="small text-muted">Filter par CTCO</label> <br>
          <b-form-select
            v-model="form.hospital_id"
            :options="hospitalList"
            text-field="name"
            value-field="id"
            class="mr-2"
            id="input-ctco"
            @change="onFiltersChange"
          >
          </b-form-select>
        </div>
        <div v-if="showDateFilter">
          <label for="input-user" class="small text-muted">Filter par plage de date</label> <br>
          <v-date-picker
            v-model="form.dateRange"
            is-range
            @input="onFiltersChange"
          >
            <template v-slot="{ inputValue, inputEvents }">
              <div class="d-flex">
                <b-form-input
                  :value="(inputValue.end || '') + ' - ' + (inputValue.start || '')"
                  v-on="inputEvents.end"
                  placeholder="Sélectionner une plage de date"
                  readonly
                >
                </b-form-input>
                <b-button
                  class='button-icon'
                  variant="primary"
                  :disabled="!form.dateRange"
                  @click="form.dateRange = null"
                >
                  <i class="fa fa-close" aria-hidden="true"></i>
                </b-button>
              </div>
            </template>
          </v-date-picker>
        </div>
      </b-col>
    </b-row>
    <b-row class="mt-4" >
      <b-col>
        <b-table
          class="completed-form-table"
          :busy="isLoading"
          :fields="fields"
          :items="completedForms.data"
          responsive
          hover
          striped
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
          <template v-slot:cell(numero)="data">
            <span> {{ data.index + 1 + (perPage * (currentPage - 1)) }} </span>
          </template>
          <template v-slot:cell(last_update)="data">
            <span>{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
          </template>
          <template v-slot:cell(form)="data">
            <span v-if="data.item.form">{{ data.item.form.title }}</span>
            <span v-else>-</span>
          </template>
          <template v-slot:cell(hospital)="data">
            <span v-if="data.item.hospital">{{ data.item.hospital.name }}</span>
            <span v-else>-</span>
          </template>
          <template v-slot:cell(actions)="data">
            <b-button
              variant="outline-primary"
              class="btn-dash "
              :to="{
                name:'hospital.detail',
                params: {
                  hospital_id: data.item.hospital_id || 0,
                  completed_form_id: data.item.id
                }
              }"
            >
              Details
            </b-button>
            <b-button
              v-if="canShowEditButton(data.item)"
              variant="outline-success btn-dash"
              class="btn-dash"
              :to="{
                name: 'hospital.edit',
                params: {
                  completed_form_id: data.item.id,
                  hospital_id: data.item.hospital_id,
                  form_id: 1
                }
              }"
            >
              Éditer
            </b-button>
            <b-button
              v-if="userIsAdminHospital"
              variant="outline-danger btn-dash"
              class="btn-dash"
              @click="showDeleteCompletedFormModal(data.item.id)"
            >
              Supprimer
            </b-button>
          </template>
        </b-table>
      </b-col>
    </b-row>

    <Pagination
      class="mb-4"
      :total-rows="totalRows"
      :per-page="perPage"
      @pageChanged="onPageChange"
      @perPageChanged="onPerPageChange"
    />

    <b-modal v-model="deleteModalVisible" centered>
      Voulez-vous vraiment supprimer cette soumission
      <template #modal-footer>
        <b-row class="px-3 pt-4 d-flex justify-content-center">
          <b-button
            size="sm"
            variant="success"
            class="btn-dash-blue mx-2"
            @click="onValidateDeletion()"
          >
            Accepter
          </b-button>
          <b-button
            size="sm"
            variant="danger"
            class="mx-2"
            @click="onCancelDeletion()"
          >
            Annuler
          </b-button>
        </b-row>
      </template>
    </b-modal>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
import { ADMIN_HOSPITAL } from '../../config/env'
import Pagination from '../Pagination.vue'

export default {
  props: {
    hospitalId: {
      type: [String, Number],
      default: null
    },
    formId: {
      type: [String, Number],
      default: null
    },
    showNewAction: {
      type: Boolean,
      default: true
    },
    showHospitalFilter: {
      type: Boolean,
      default: true
    },
    showFormFilter: {
      type: Boolean,
      default: true
    },
    showUserFilter: {
      type: Boolean,
      default: true
    },
    showDateFilter: {
      type: Boolean,
      default: true
    },
    showFormColumn: {
      type: Boolean,
      default: true
    },
    showHospitalColumn: {
      type: Boolean,
      default: true
    }
  },
  components: { Pagination },
  data () {
    return {
      completedForms: {},
      isLoading: false,
      form: {
        hospital_id: null,
        admin_user_id: null
      },
      perPage: 15,
      agentsHospitals: [],
      allCurrentFilters: {},
      deleteModalVisible: false,
      completedFormIdToDelete: null
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      completedForm__selectedForm: (state) => state.completedForm.selectedForm,
      hospital__hospitals: (state) => state.hospital.hospitals
    }),
    userIsAdminHospital () {
      return this.userHaveRole(ADMIN_HOSPITAL)
    },
    totalRows () {
      return this.completedForms?.total || 0
    },
    currentPage () {
      return this.completedForms?.current_page || 1
    },
    formList () {
      return [
        { id: null, title: 'Tous' },
        ...this.form__publishedForms()
      ]
    },
    hospitalList () {
      return [
        { id: null, name: 'Tous' },
        ...this.hospital__hospitals
      ]
    },
    usersList () {
      return [
        { id: null, name: 'Tous' },
        ...this.agentsHospitals
      ]
    },
    fields () {
      const data = [
        { key: 'numero', label: '#' },
        { key: 'last_update', label: 'Date' },
        { key: 'created_manager_name', label: 'Nom' },
        { key: 'created_manager_first_name', label: 'Prénom' }
      ]
      if (this.showFormColumn) {
        data.push({ key: 'form', label: 'Formulaire' })
      }
      if (this.showHospitalColumn) {
        data.push({ key: 'hospital', label: 'CTCO' })
      }
      data.push({ key: 'actions', label: 'Actions' })
      return data
    }
  },
  async mounted () {
    this.$set(this.form, 'form_id', this.completedForm__selectedForm)
    this.getForms()
    this.getHospitals()
    this.getCompletedForms()
    this.agentsHospitals = await this.adminUser__getAgentHospitals()
  },
  watch: {
    user () {
      this.getCompletedForms()
    },
    totalRows (value) {
      this.$emit('totalChanged', value)
    }
  },
  methods: {
    ...mapActions([
      'completedForm__getAllFiltered',
      'getForms',
      'completedForm__setSelectedForm',
      'getHospitals',
      'adminUser__getAgentHospitals',
      'completedForm__delete'
    ]),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    ...mapGetters(['form__publishedForms']),
    async getCompletedForms (page = 1) {
      this.isLoading = true
      this.allCurrentFilters = {
        page,
        ...this.form,
        hospital_id: this.hospitalId || this.form.hospital_id,
        form_id: this.formId || this.form.form_id,
        per_page: this.perPage,
        date_range_start: this.form?.dateRange?.start || null,
        date_range_end: this.form?.dateRange?.end || null
      }
      this.completedForms = await this.completedForm__getAllFiltered(this.allCurrentFilters)
      this.isLoading = false
    },
    onPageChange (page) {
      this.getCompletedForms(page)
    },
    onPerPageChange (perPage) {
      this.perPage = perPage
      this.getCompletedForms()
    },
    canShowEditButton (completedForm) {
      return this.userHaveRole(ADMIN_HOSPITAL) || completedForm.diff_date * 24 < 24
    },
    onFormFilterChange () {
      this.completedForm__setSelectedForm(this.form.form_id)
      this.getCompletedForms()
    },
    onFiltersChange () {
      this.getCompletedForms(1)
    },
    showDeleteCompletedFormModal (id) {
      this.deleteModalVisible = true
      this.completedFormIdToDelete = id
    },
    onCancelDeletion () {
      this.deleteModalVisible = false
      this.completedFormIdToDelete = null
    },
    onValidateDeletion () {
      this.$bvModal.show('confirmation-box')
      this.completedForm__delete(this.completedFormIdToDelete)
        .then(() => {
          this.$notify({
            group: 'alert',
            title: 'Suppression...',
            text: 'Soumission supprimer avec succès',
            type: 'success'
          })
          this.deleteModalVisible = false
          this.getCompletedForms()
        })
        .catch(() => {
          this.$notify({
            group: 'alert',
            title: 'Suppression...',
            text: 'Une erreur est survenu',
            type: 'error'
          })
        })
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";

.completed-form-table {
  &::v-deep{
    thead {
      background-color: $dash-blue;
      color: white;
    }
    tbody {
      tr {
        &:nth-child(2n) {
          background-color: white;
        }
        &:nth-child(2n+1) {
          background-color: rgba(0, 0, 0, 0.02);
        }
      }
    }
  }
}
.form-filters {
  > div {
    margin-left: 20px;
    margin-bottom: 10px;
  }
  select, input {
    width: 200px;
  }

  button.button-icon {
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
    background-color: $dash-blue;
  }
  .form-control[readonly]{
    background-color: white;
  }
}
</style>
