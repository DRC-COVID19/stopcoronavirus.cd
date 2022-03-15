<template>
  <b-container>
    <b-row class="my-3" align-h="start">
      <b-col cols="12" md="6">
        <v-date-picker
          v-model="filter"
          opens="center"
          :max-date="new Date()"
          @input="onRangeDateObservation"
          class="d-flex style-picker mb-2"
          show-weeknumbers
          ref="datepicker"
          :attributes="attrs"
        >
          <template v-slot="{ inputEvents }">
            <div class="d-flex btn-container-calendar">
              <i for="filter" class="fas fa-light fa-calendar p-2"></i>
              <input
                id="filter"
                class="p-1 w-full"
                style="font-size: 16px"
                :value="
                  filter
                    ? moment(filter).format('DD.MM.YYYY')
                    : 'Choisir la date'
                "
                v-on="inputEvents"
                readonly
              />
            </div>
          </template>
          <div
            slot="footer"
            slot-scope=""
            class="d-flex justify-content-between ml-2 mr-2 mb-2 mt-n2"
            style="width: 330px"
          >
            <span class="btn-date-picker today" style="" @click="btnToday"
              >Aujourd'hui
            </span>
            <span class="btn-date-picker reset" @click="btnReset">
              Annuler</span
            >
          </div>
        </v-date-picker>

        <!-- <b-form-datepicker
          label-today-button="Aujourd'hui"
          label-reset-button="Effacer"
          reset-button
          today-button
          v-model="filter"
          placeholder="Choisir la date"
          class="mb-2"
        >
        </b-form-datepicker> -->
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
            <i
              class="mx-2 fas fa-pencil-alt color-green"
              aria-hidden="true"
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
            ></i>
            <i
              class="mx-2 fas fa-trash prim color-red"
              aria-hidden="true"
              @click="deleteSituation(data.item.id)"
            ></i>
          </template>
          <template v-slot:cell(last_update)="data">
            {{ moment(data.item.last_update).format("DD.MM.YYYY") }}
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
      default: () => ({})
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      fields: [
        { key: 'id', label: 'ID' },
        { key: 'last_update', label: 'Date' },
        { key: 'confirmed', label: 'Confirme', sortable: true },
        { key: 'sick', label: 'Actifs', sortable: true },
        { key: 'seriously', label: 'Grave', sortable: true },
        { key: 'healed', label: 'Gueris', sortable: true },
        { key: 'dead', label: 'Deces', sortable: true },
        { key: 'imported', label: 'Importes', sortable: true },
        { key: 'local', label: 'Local', sortable: true },
        'actions'
      ],
      filter: "",
      perPage: 15,
      currentPage: 1,
      isDeleteModalShown: false,
      currentSituation: {
        last_update: ''
      },
      editModalShow: false,
      attrs: []

    }
  },
  computed: {
    rows () {
      return this.situations.length
    }
  },
  watch: {
    filter () {
      this.search()
    }
  },
  methods: {
    search () {
      this.$emit('onSearch', this.filter)
    },
    deleteSituation (id) {
      this.isDeleteModalShown = true
      this.currentSituation.id = id
    },
    editSituation (
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
        healed
      }
      this.$emit('onEditSituation', this.currentSituation)
    },
    onValidateDelection () {
      this.$emit('onDeleteSituation', this.currentSituation.last_update)
      this.isDeleteModalShown = false
    },
    onCancelDelection () {
      this.isDeleteModalShown = false
    },
    onRangeDateObservation (inputValueDate) {
      // this.filter = inputValueDate
      this.attrs = []
    },
    btnReset () {
      this.attrs = []
      this.filter = null
      this.$emit('onGetSituations')
    },
    btnToday () {
      this.filter = new Date()
      this.attrs.push({
        key: 'today',
        dates: new Date(),
        highlight: true
      })
    }
  }
}
</script>
<style lang="scss" scoped>
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
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;

  input {
    border: none !important;
    width: 100%;
    height: 100%;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
}
.style-picker {
  padding: 5px;
  width: 100%;
}
.btn-date-picker {
  cursor: pointer;
  border: 1px solid #c3c8ced2;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 16px;
}

</style>
