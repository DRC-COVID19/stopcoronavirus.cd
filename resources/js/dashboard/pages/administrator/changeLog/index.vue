<template>
  <b-container fluid>
    <b-row>
      <b-col cols="12" md="9">
        <div class="hide-waiting" v-if="isCreating || isEditingMode"></div>
        <b-skeleton-table
          v-if="isLoading"
          :rows="15"
          :columns="5"
          :table-props="{ bordered: false, striped: true, responsive: true }"
        ></b-skeleton-table>

        <b-table
          v-else
          hover
          striped
          responsive
          :items="changeLogsData"
          :fields="fields"
        >
          <template #cell(number)="data">
            {{ data.index + 1 }}
          </template>
          <template #cell(from)="data">
            {{ moment(data.item.from).format("DD.MM.YYYY") }}
          </template>
          <template #cell(action)="data">
            <i
              class="mx-2 fas fa-edit btn-action text-warning"
              @click="toEdit(data.item)"
            ></i>
            <i class="mx-2 fas fa-trash btn-action text-danger"></i>
          </template>
        </b-table>
        <b-row>
          <b-col class="d-flex justify-content-end">
            <b-pagination
              v-model="changeLogsMeta.current_page"
              :total-rows="changeLogsMeta.total"
              :per-page="changeLogsMeta.per_page"
              @change="switchPage"
              :disabled="isCreating"
            ></b-pagination>
          </b-col>
        </b-row>
      </b-col>
      <b-col cols="12" md="3">
        <h3>Nouveau log</h3>
        <b-form @submit.prevent="submit_form">
          <b-form-group
            label="Date"
            label-class="text-dash-color"
            :invalid-feedback="
              errors.publish_date ? errors.publish_date[0] : null
            "
            :state="errors.publish_date ? false : null"
            :disabled="isCreating"
          >
            <b-form-datepicker
              v-model="form.publish_date"
              :state="errors.publish_date ? false : null"
              class="input-dash"
              :max="new Date()"
              required
            />
          </b-form-group>
          <b-form-group
            :invalid-feedback="errors.title ? errors.title[0] : null"
            :state="errors.title ? false : null"
            label="Titre"
            label-class="text-dash-color"
            :disabled="isCreating"
          >
            <b-form-input
              v-model="form.title"
              :state="errors.title ? false : null"
              class="input-dash"
              required
            />
          </b-form-group>
          <b-form-group
            :invalid-feedback="
              errors.description ? errors.description[0] : null
            "
            :state="errors.description ? false : null"
            label="Déscription"
            label-class="text-dash-color"
            :disabled="isCreating"
          >
            <b-form-textarea
              rows="10"
              v-model="form.description"
              :state="errors.description ? false : null"
              class="input-dash"
            />
          </b-form-group>
          <b-button
            type="submit"
            class="btn-dash-sucess"
            :disabled="isCreating"
          >
            <span v-if="isCreating"
              ><b-spinner class="align-middle"></b-spinner>
              <span>en cours ...</span>
            </span>
            <div v-else>
              <span v-if="isEditingMode">Modifier</span>
              <span v-else>Enregistrer</span>
            </div>
          </b-button>
          <b-button
            :disabled="isCreating"
            v-if="isEditingMode"
            class="btn-dash-danger"
            @click="cancelEditMode"
            >Annuler</b-button
          >
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
  data() {
    return {
      fields: [
        {
          key: "number",
          label: "#",
        },
        {
          key: "from",
          label: "Date",
        },
        {
          key: "title",
          lablel: "Titre",
        },
        {
          key: "owner",
          lablel: "Par",
        },
        {
          key: "action",
          label: "Action",
        },
      ],
      form: {},
      errors: {},
      isEditingMode: false,
    };
  },
  mounted() {
    this.getListChangedLogs();
  },
  computed: {
    ...mapState({
      listChangeLogs: (state) => state.changeLog.listChangeLogs,
      isCreating: (state) => state.changeLog.isCreating,
      isLoading: (state) => state.changeLog.isLoading,
    }),
    changeLogsData() {
      return this.listChangeLogs.data;
    },

    changeLogsMeta() {
      return this.listChangeLogs.meta
        ? this.listChangeLogs.meta
        : {
            current_page: 1,
            from: 1,
            last_page: 1,
            path: "#",
            per_page: 1,
            to: 1,
            total: 1,
          };
    },
  },
  methods: {
    ...mapActions(["createChangeLog"]),
    ...mapActions(["getListChangedLogs", "updateChangeLog"]),
    submit_form() {
      if (this.isEditingMode) {
        this.submitUpdatingChangeLog();
      } else {
        this.submitcreateChangeLog();
      }
    },
    submitcreateChangeLog() {
      this.errors = {};
      this.createChangeLog(this.form)
        .then(() => {
          this.form = {};
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Nouveau log",
            text: "Ajouter avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$notify({
            group: "alert",
            title: "Nouveau log",
            text: "Une erreur est surveni",
            type: "error",
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },
    submitUpdatingChangeLog() {
      this.errors = {};
      this.updateChangeLog(this.form)
        .then(() => {
          this.form = {};
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Modifer log",
            text: "Modifier avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$notify({
            group: "alert",
            title: "Modifer log",
            text: "Une erreur est surveni",
            type: "error",
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },
    switchPage(page) {
      this.getListChangedLogs({ page }).then(() => {
        window.scrollTo(0, 0);
      });
    },
    toEdit(item) {
      this.isEditingMode = true;
      this.form = item;
      this.form.publish_date = item.from;
    },
    cancelEditMode() {
      this.isEditingMode = false;
      this.form = {};
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.btn-action-success {
}
.btn-action {
  cursor: pointer;
}
.hide-waiting {
  position: absolute;
  background: $waiting_background;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 20;
}
</style>
