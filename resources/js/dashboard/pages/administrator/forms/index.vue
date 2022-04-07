<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse" no-gutters>
      <b-col cols="12" md="4" class="mt-3">
        <b-sidebar
          id="sidebar-right"
          right
          bg-variant="white"
          width="25rem"
          backdrop
          :no-close-on-route-change="true"
          shadow
          backdrop-variant="transparent"
        >
          <Create
            @onUpdate="updateForm"
            @onCreate="createForm"
            @onCancelUpdate="cancelUpdate"
            :formAdded="formAdded"
            :formUpdated="formUpdated"
            :formToPopulate="formToPopulate"
            :formRecurrences="formRecurrences"
            :errors="errors"
          />
        </b-sidebar>
      </b-col>
      <b-col cols="12" md="12">
        <div class="ml-2">
          <Header :title="title" :iconClass="iconClass" />
        </div>
        <div class="hide-waiting" v-if="updating"></div>
        <ListForms
          :forms="forms"
          :isLoading="isLoading"
          :updating="updating"
          :current-page="currentPage"
          :per-page="formMeta.perPage"
          @onSearch="search"
          @onDeleteForm="deleteForm"
          @onUpdateForm="populateForm"
        />
        <b-col cols="12" class="d-flex justify-content-end">
          <b-pagination
            v-model="currentPage"
            :per-page="formMeta.perPage"
            :total-rows="formMeta.total"
            :disabled="updating"
            page-class="text-blue-dash"
            @change="getFormList"
          ></b-pagination>
        </b-col>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Header from "../components/Header";
import ListForms from "./components/ListForms";
import Create from "./components/Create";
export default {
  components: {
    Header,
    Create,
    ListForms,
  },
  data() {
    return {
      title: "Formulaires",
      iconClass: "fa fa-address-card",
      isLoading: false,
      forms: [],
      formUpdated: false,
      formAdded: false,
      showSuccess: false,
      isFormDeleted: false,
      timeOut: 3,
      formToPopulate: {},
      updating: false,
      errors: {},
      currentPage: 1,
      formRecurrences: [],
    };
  },
  mounted() {
    this.getFormList();
    this.getFormRecurrence();
  },
  computed: {
    formMeta() {
      return {
        currentPage: 1,
        perPage: 3,
        total: this.forms.length,
      };
    },
  },
  methods: {
    search(filter) {
      this.isLoading = true;
      if (filter !== "") {
        axios
          .get("api/dashboard/forms/filter?key_words=" + filter)
          .then(({ data }) => {
            this.forms = data;
            this.isLoading = false;
          })
          .catch(({ response }) => {
            this.$gtag.exception(response);
            this.isLoading = false;
          });
      } else {
        this.getFormList();
        this.isLoading = false;
      }
    },
    deleteForm(currentFormId) {
      axios
        .delete("/api/dashboard/forms/" + currentFormId)
        .then(() => {
          this.getFormList();
          this.isFormDeleted = true;
          this.$notify({
            group: "alert",
            title: "Supprimer formulaire",
            text: "Supprimer avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
          this.$notify({
            group: "alert",
            title: "Supprimer formulaire",
            text: "Une erreur est surveni",
            type: "error",
          });
        });
    },
    populateForm(currentForm) {
      this.updating = true;
      this.formToPopulate = currentForm;
    },
    cancelUpdate() {
      this.updating = false;
    },
    updateForm(currentForm) {
      this.isLoading = true;
      this.formUpdated = false;
      const form = {
        title: currentForm.title,
        form_recurrence_value: currentForm.form_recurrence_value,
        form_recurrence_id: currentForm.form_recurrence_id,
        publish: currentForm.publish,
      };

      axios
        .put("/api/dashboard/forms/" + currentForm.id, form)
        .then(() => {
          this.formUpdated = true;
          this.showSuccess = true;
          this.isLoading = false;
          this.updating = false;
          this.getFormList(1);
          this.$notify({
            group: "alert",
            title: "Modification du  Formulaire",
            text: "Modifier avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
          this.$notify({
            group: "alert",
            title: "Modification du  Formulaire",
            text: "Une erreur est survenus",
            type: "error",
          });
        });
    },

    createForm(form) {
      this.formAdded = false;
      this.isLoading = true;
      this.errors = {};
      axios
        .post("/api/dashboard/forms", {
          title: form.title,
          form_recurrence_value: form.form_recurrence_value,
          form_recurrence_id: form.form_recurrence_id,
          publish: form.publish,
        })
        .then(() => {
          this.formAdded = true;
          this.showSuccess = true;
          this.isLoading = false;
          this.getFormList(1);
          this.$notify({
            group: "alert",
            title: "Nouveau Formulaire",
            text: "Ajouter avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
          this.isLoading = false;
          this.errors = response.data.errors;
          this.$notify({
            group: "alert",
            title: "Nouveau Formulaire",
            text: "Une erreur est survenus",
            type: "error",
          });
        });
    },

    getFormList(page = 1) {
      this.isLoading = true;
      axios
        .get("api/dashboard/forms", {
          params: { page },
        })
        .then(({ data }) => {
          this.forms = data;
          this.isLoading = false;
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });
    },

    getFormRecurrence() {
      axios
        .get("/api/dashboard/form-recurrences")
        .then(({ data }) => {
          this.formRecurrences = data;
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });
    },

    switchPage(page) {
      this.getFormList(page);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.fa-plus {
  color: white;
  font-size: 14px;
}
.mask {
  position: absolute;
  z-index: 100;
  background-color: $dash-background;
  opacity: 0.5;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.alert {
  position: absolute;
  z-index: 100;
  opacity: 0.6;
  top: 0;
  right: 0;
  width: 100%;
}
</style>
