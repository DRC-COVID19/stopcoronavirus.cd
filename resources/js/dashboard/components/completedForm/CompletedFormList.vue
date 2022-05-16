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
        <div v-if="showFormFilter">
          <label for="input-formulaire" class="small text-muted">Formulaire</label>
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
          <label for="input-ctco" class="small text-muted">CTCO</label>
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
        hospital_id: null
      },
      perPage: 15
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      completedForm__selectedForm: (state) => state.completedForm.selectedForm,
      hospital__hospitals: (state) => state.hospital.hospitals
    }),
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
  },
  watch: {
    user () {
      this.getCompletedForms()
    },
    totalRows(value) {
      this.$emit('totalChanged', value);
    }
  },
  methods: {
    ...mapActions([
      'completedForm__getAllFiltered',
      'getForms',
      'completedForm__setSelectedForm',
      'getHospitals'
    ]),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    ...mapGetters(['form__publishedForms']),
    async getCompletedForms (page = 1) {
      this.isLoading = true
      this.completedForms = await this.completedForm__getAllFiltered({
        page,
        ...this.Form,
        hospital_id: this.hospitalId || this.form.hospital_id,
        form_id: this.formId || this.form.form_id,
        per_page: this.perPage
      })
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
      &:nth-child(2n) {
        background-color: white;
      }
    }
  }
}
</style>
