<template>
  <b-card>
    <b-card-header v-b-toggle.collapse-form-step-list>
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
          Liste des étapes
        </span>
        <i class="fas fa-chevron-down" aria-hidden="true"></i>
      </div>
    </b-card-header>
    <b-collapse id="collapse-form-step-list" class="mt-2" visible>
      <b-card-body>
        <b-row no-gutters class="mb-3">
          <b-col cols="12">
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
              small
              responsive="sm"
              striped
              hover
              :fields="fields"
              :items="formStepsSorted"
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
                  @click="deleteStep(data.item)"
                  class="mx-2 my-1 fas fa-trash prim color-red"
                  aria-hidden="true"
                ></i>
                <i
                  class="mx-2 my-1 fas fa-pencil-alt color-green"
                  aria-hidden="true"
                  @click="
                    updateStep(
                      data.item
                    )
                  "
                ></i>
              </template>
              <template v-slot:cell(index)="data">
                {{ ((currentPage - 1) * perPage) + data.index + 1 }}
              </template>
            </b-table>
          </b-col>
        </b-row>

        <b-pagination
          v-model="currentPage"
          :per-page="perPage"
          :total-rows="totalRows"
          :disabled="isCreating"
          page-class="text-blue-dash"
          class="justify-content-end"
          @change="getFormSteps"
        />

        <b-modal v-model="isDeleteModalShown">
          Voulez-vous vraiment supprimer cette ligne
          <template #modal-footer>
            <b-button size="sm" variant="success" @click="onValidateDelection()">
              Accepter
            </b-button>
            <b-button size="sm" variant="danger" @click="onCancelDelection()">
              Annuler
            </b-button>
          </template>
        </b-modal>
      </b-card-body>
    </b-collapse>
  </b-card>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
  props: {
    formId: {
      type: Number,
      required: true
    },
    isLoading: {
      type: Boolean,
      default: false
    },
    perPage: {
      type: Number,
      default: 15
    },
    totalRows: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      fields: [
        { key: 'step', label: 'Etape' },
        { key: 'title', label: 'Titre' },
        'actions'
      ],
      filter: '',
      isDeleteModalShown: false,
      currentForm: {
        id: -1,
        title: ''
      },
      formStepId: null,
      editModalShow: false,
      currentPage: 1
    }
  },

  mounted () {
    this.getFormSteps({ id: this.formId })
  },
  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps
    }),
    formStepsSorted () {
      return this.formSteps.slice().sort((a, b) => a.step - b.step)
    },
    rows () {
      return this.formSteps.length
    }
  },
  watch: {
    filter () {
      this.search()
    }
  },
  methods: {
    ...mapActions([
      'getFormSteps',
      'removeFormStep',
      'searchFormStep'
    ]),
    search () {
      this.searchFormStep(this.filter.trim())
        .catch((error) => {
          console.log(error)
        })
    },
    deleteStep (formId) {
      this.isDeleteModalShown = true
      this.formStepId = formId.id
    },
    onValidateDelection () {
      this.$bvModal.show('confirmation-box')
      this.removeFormStep(this.formStepId)
        .then(() => {
          this.$notify({
            group: 'alert',
            title: "Supprimer l'étape",
            text: 'Supprimer avec succès',
            type: 'success'
          })
          this.isDeleteModalShown = false
          this.getFormSteps({ id: this.formId })
        })
        .catch(() => {
          this.$notify({
            group: 'alert',
            title: "Supprimer  l'étape",
            text: 'Une erreur est survenus',
            type: 'error'
          })
        })
    },
    onCancelDelection () {
      this.isDeleteModalShown = false
    },
    updateStep (form) {
      this.$emit('onUpdateStep', form)
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
