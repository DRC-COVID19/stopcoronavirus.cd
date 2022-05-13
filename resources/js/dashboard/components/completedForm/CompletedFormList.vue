<template>
  <div>
    <b-row class="mb-4">
      <b-col cols="12" md>
        <b-button
          :to="{ name:'hospital.create', params:{ form_id: 1 }}"
          class="btn-dash-blue"
          v-if="showNewAction"
        >
          + Nouveau
        </b-button>
      </b-col>
      <b-col cols="12" md="auto" class="d-flex">
        <div>
          <label for="input-formulaire" class="small text-muted">Formulaire</label>
          <b-form-select
            v-model="selectedForm"
            :options="formList"
            text-field="title"
            value-field="id"
            class="mr-2"
            id="input-formulaire"
          >
          </b-form-select>
        </div>
      </b-col>
    </b-row>
    <b-row class="mt-4" >
      <b-col>
        <b-table
          :busy="isLoading"
          :fields="fields"
          :items="completedForms.data"
          responsive
          hover
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
          <template v-slot:cell(last_update)="data">
            <span>{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
          </template>
          <template v-slot:cell(form)="data">
            <span v-if="data.item.form">{{ data.item.form.title }}</span>
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
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
import { ADMIN_HOSPITAL } from '../../config/env'

export default {
  props: {
    hospitalId: {
      type: [String, Number],
      default: null
    },
    showNewAction: {
      type: Boolean,
      default: true
    }
  },
  data () {
    return {
      fields: [
        { key: 'last_update', label: 'Date' },
        { key: 'created_manager_name', label: 'Nom' },
        { key: 'created_manager_first_name', label: 'Prénom' },
        { key: 'form', label: 'Formulaire' },
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1,
      completedForms: {},
      isLoading: false,
      selectedForm: null
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      completedForm__selectedForm: (state) => state.completedForm.selectedForm
    }),
    totalRows () {
      if (this.completedForms) {
        return this.completedForms.total
      }
      return null
    },
    perPage () {
      if (this.completedForms) {
        return this.completedForms.per_page
      }
      return 15
    },
    formList() {
      return [
        { id: null, title: 'Tous' },
        ...this.form__publishedForms()
      ]
    }
  },
  async mounted () {
    this.selectedForm = this.completedForm__selectedForm
    this.getForms()
    this.getCompletedForms()
  },
  watch: {
    user () {
      this.getCompletedForms()
    },
    selectedForm(value) {
      this.completedForm__setSelectedForm(value)
      this.getCompletedForms()
    }
  },
  methods: {
    ...mapActions([
      'completedForm__getAllFiltered',
      'getForms',
      'completedForm__setSelectedForm'
    ]),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    ...mapGetters(['form__publishedForms']),
    async getCompletedForms (page = 1) {
      this.isLoading = true
      this.completedForms = await this.completedForm__getAllFiltered({
        page,
        hospital_id: this.hospitalId,
        form_id: this.completedForm__selectedForm
      })
      this.isLoading = false
    },
    onPageChange (page) {
      this.getCompletedForms(page)
    },
    canShowEditButton (completedForm) {
      return this.userHaveRole(ADMIN_HOSPITAL) || completedForm.diff_date * 24 < 24
    }
  }
}
</script>
