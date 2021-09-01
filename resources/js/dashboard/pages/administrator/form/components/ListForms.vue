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
          <template v-slot:cell(actions)="data" class="action-btn-group">
            <i
              @click="deleteForm(data.item.id)"
              class="mx-2 my-1 fas fa-trash prim color-red"
              aria-hidden="true"
            ></i>
            <i
              class="mx-2 my-1 fas fa-pencil-alt color-green"
              aria-hidden="true"
              @click="
                updateForm(
                  data.item.id,
                  data.item.title,
                  data.item.form_recurrence_value,
                  data.item.form_recurrence_id
                )
              "
            ></i>
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
import { format } from 'date-fns'
export default {
  props: {
    forms: {
      type: Array,
      default: () => [],
    },
    isLoading: {
      type: Boolean,
      default: false,
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
  data() {
    return {
      fields: [
        { key: "index", label: "#" },
        { key: "title", label: "Titre" },
        { key: "form_recurrence.name", label: "Recurrence" },
        { key: "publish", label: "Publier" },
        { key: "created_at", label: "Date création" },
        "actions",
      ], 
      filter: "",
      isDeleteModalShown: false,
      currentForm: {
        id: -1,
        title: "",
      },
      editModalShow: false,
    };
  },

  computed: {
    rows() {
      return this.forms.length;
    },
  },
  watch: {
    filter () {
      this.search();
    }
  },
  methods: {
    search () {
      this.$emit('onSearch', this.filter.trim());
    },
    deleteForm(formId) {
      this.isDeleteModalShown = true;
      this.currentForm.id = formId;
    },
    onValidateDelection() {
      this.$emit("onDeleteForm", this.currentForm.id);
      this.isDeleteModalShown = false;
    },
    onCancelDelection() {
      this.isDeleteModalShown = false;
    },
    updateForm(id, title, form_recurrence_value,form_recurrence_id) {
      this.currentForm = {
        id,
        title,
        form_recurrence_value,
        form_recurrence_id
      };
      this.$emit("onUpdateForm", this.currentForm);
    },
    formatDateFns (datefn) {
      return format(new Date(datefn), 'dd/MM/yyyy à HH:mm:ss')
    },
  },
};
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
