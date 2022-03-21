<template>
  <b-container fluid>
    <b-row no-gutters class="mb-3">
      <b-col cols="12" md="6">
        <b-form-input
          v-model="filter"
          debounce="1500"
          class="input-dash input-filter"
          type="search"
          placeholder="Filtrer"
        ></b-form-input>
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
          :items="forms"
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
          <template v-slot:cell(actions)="data">
             <b-button
                class="btn-dash-blue btn-dash"
                :to="{
                    name:'administrator.forms.show',
                    params:{
                      form_id:data.item.id,
                    }
                  }"
              >Details</b-button>
               <b-button
               variant="outline-success mb-1"
               class="btn-dash"
               @click="
                updateForm(
                  data.item.id,
                  data.item.title,
                  data.item.form_recurrence_value,
                  data.item.form_recurrence_id,
                  data.item.publish
                )
              "
              >Editer</b-button>
              <b-button 
              variant="outline-danger mb-1"
              class="btn-dash"
              @click="deleteForm(data.item.id)">
             Supprimer
            </b-button>

          </template>
          <template v-slot:cell(index)="data">
            {{ ((currentPage - 1) * perPage) + data.index + 1 }}
          </template>
          <template v-slot:cell(publish)="data">
            <p>{{data.item.publish===true?'Oui':'Non'}}</p>
          </template>
          <template v-slot:cell(created_at)="data">
            <p>{{formatDateFns(data.item.created_at)}}</p>
          </template>
        </b-table>
      </b-col>
    </b-row>
    <b-modal v-model="isDeleteModalShown">
      Voulez-vous vraiment supprimer ce formulaire {{ currentForm.title }} ?
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
    forms: {
      type: Array,
      default: () => []
    },
    isLoading: {
      type: Boolean,
      default: false
    },
    currentPage: {
      type: Number,
      default: 1
    },
    perPage: {
      type: Number,
      default: 15
    }
  },
  data () {
    return {
      fields: [
        { key: 'title', label: 'Titre' },
        { key: 'created_at', label: 'Date création' },
        'actions'
      ],
      filter: '',
      isDeleteModalShown: false,
      currentForm: {
        id: -1,
        title: ''
      },
      editModalShow: false
    }
  },

  computed: {
    rows () {
      return this.forms.length
    }
  },
  watch: {
    filter () {
      this.search()
    }
  },
  methods: {
    search () {
      this.$emit('onSearch', this.filter.trim())
    },
    deleteForm (formId) {
      this.isDeleteModalShown = true
      this.currentForm.id = formId
    },
    onValidateDelection () {
      this.$emit('onDeleteForm', this.currentForm.id)
      this.isDeleteModalShown = false
    },
    onCancelDelection () {
      this.isDeleteModalShown = false
    },
    updateForm (id, title, form_recurrence_value, form_recurrence_id,publish) {
      this.currentForm = {
        id,
        title,
        form_recurrence_value,
        form_recurrence_id,
        publish
      }
      this.$emit('onUpdateForm', this.currentForm)
    }
  }
}
</script>
<style lang='scss' scoped>
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
