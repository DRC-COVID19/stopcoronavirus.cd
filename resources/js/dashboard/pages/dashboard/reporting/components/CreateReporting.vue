<template>
  <b-tabs class="mx-0">
        <b-tab title="Paramètrage" :active="title==='Paramètrage'" @click="showBookMarks('settings')">
            <b-row class="mx-0 h-100 w-100" lg="12">
              <b-col class="mx-0 w-100 mt-4" lg="12">
                <h3>Générateur de graphique</h3>
              </b-col>
               <b-col class="mx-0 w-100 mt-4" lg="12">
              <label for class="text-dash-color"><b-badge class="px-2">Étape 1</b-badge> : Source des données </label>
              <v-select
                v-model="report.formId"
                :options="getForms"
                :reduce="(item) => item.id"
                label="title"
                placeholder="Sélectionner une source des données"
                class="style-chooser"
                @input="selectedForm"
              />
             </b-col>
              <b-col class="border-dash rounded pb-4" lg="12">
                <b-row>
                  <div class="mx-0 w-100" lg="12">  <hr /> </div>
                   <div class="col-md-12 px-0">
                   <Questions
                    v-model="linesSelected"
                    title="Lignes"
                    type="line"
                    step="Étape 2"
                    :cloneOptionQuestions="cloneOptionQuestions"
                    :except="columnsSelected"
                    :isDataSourceSelected='isDataSourceSelected'
                    placeholder="Recherche"
                    @selectedForm="selectedForm"
                    ref="QuestionsOne"
                  />
                   <hr />
                 </div>
                 <div class="col-md-12 px-0">
                   <Questions
                    v-model="columnsSelected"
                    title="Colonnes"
                    type="column"
                    step="Étape 3"
                    :cloneOptionQuestions="cloneOptionQuestions"
                    :except="linesSelected"
                    :isDataSourceSelected='isDataSourceSelected'
                     placeholder="Recherche"
                    @selectedForm="selectedForm"
                    ref="QuestionsTwo"
                  />
                 </div>
                </b-row>
              </b-col>
              <b-col class="mt-1 d-flex justify-content-around actions-container" lg="12">
              <div>
              <b-button
                  type="reset"
                  variant="outline-danger"
                  size="lg"
                  @click="resetForm()"
                 >
                  <small>Réinitialiser</small>
                </b-button></div>
               <div>
                <b-button type="submit" variant="primary" size="lg" class="btn-saved" @click="savedBookmark()">
                  <small>Sauvegarder</small>
                </b-button>
                </div>
              </b-col>
            </b-row>
        </b-tab>
        <b-tab title="Bookmark" @click="showBookMarks('bookmark')">
          <b-row>
            <b-col class="mx-0 w-100 mt-4 bookmark__overflow" lg="12">
                <label for class="text-dash-color">Sélectionner le bookmark :</label>
                <b-list-group v-for="(bookmark) in bookmarks" :key="bookmark.id" class="rounded-0 w-100">
                    <b-list-group-item :active="bookmark.id === activeItem && visibleBookmark" style="cursor: pointer;" class="d-flex justify-content-between" @click.prevent="selectedBookmark(bookmark)">{{bookmark.name.charAt(0).toUpperCase()+ bookmark.name.slice(1)}}  <!--<b-button :variant="bookmark.id === activeItem?'danger':'outline-danger'" size="sm" @click="deleteBookmark(bookmark)">supprimer</b-button>--></b-list-group-item>
                </b-list-group>
              </b-col>
          </b-row>
        </b-tab>
      </b-tabs>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import Questions from './Questions'
export default {
  components: {
    Questions
  },
  props: {
    activeItem: {
      type: Number,
      default: null
    },
    bookmarks: {
      type: Array,
      default: () => ([])
    },
    cloneOptionQuestions: {
      type: Array,
      default: () => ([])
    },
    isDataSourceSelected: {
      type: Boolean,
      default: () => false
    },
    getForms: {
      type: Array,
      default: () => ([])
    },
    reporting: {
      type: Object,
      default: () => ({})
    }
  },
  computed: {
    ...mapState({
      linesSelected: (state) => state.reporting.linesSelected,
      columnsSelected: (state) => state.reporting.columnsSelected
    })
  },
  data () {
    return {
      report: this.reporting,
      title: '',
      bookmark: {},
      visibleBookmark: true
    }
  },
  watch: {
    reporting (value) {
      this.report = value
    }
  },
  methods: {
    ...mapActions(['bookmark__delete']),
    selectedForm () {
      if (this.report.formId !== null) {
        this.$emit('selectedForm', this.report.formId)
      }
    },
    resetForm () {
      this.$refs.QuestionsOne.resetForm()
      this.$refs.QuestionsTwo.resetForm()
      this.report = {}
    },
    selectedBookmark (bookmark) {
      this.visibleBookmark = true
      this.bookmark = { ...bookmark }
      this.$emit('selectedBookmark', this.bookmark)
    },
    savedBookmark () {
      this.$emit('savedBookmark')
    },
    deleteBookmark (bookmark) {
      const title = 'Suppression'
      const message = 'Voulez-vous vraiment supprimer ?'
      const response = this.$bvModal.msgBoxConfirm(message, {
        titleHtml: title,
        noFade: true
      })
      if (!response) {
        this.bookmark__delete(bookmark)
          .then(() => {
            this.$notify({
              group: 'alert',
              title: 'Bookmark',
              text: 'Bookmark supprimé avec succès',
              type: 'success'
            })
            this.$emit('onSubmitBookmark')
          })
          .catch(({ response }) => {
            this.$notify({
              group: 'alert',
              title: 'Bookmark',
              text: 'Une erreur est survenus',
              type: 'error'
            })
            this.$bvModal.hide('my-modal-bookmark')
          })
      }
    },
    showBookMarks (value) {
      // document.querySelectorAll('table').forEach((tableItem) => {
      //   tableItem.textContent = ''
      // })
      this.visibleBookmark = false
      this.$emit('changePivotTable', value)
    }
  }

}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";

@media (width: 1024px) {
.actions-container{
    flex-direction: column-reverse;
    padding-bottom: 100rem;
    align-items: center;
    & div:nth-child(1){
     padding: 1rem 0;
    }
}
.bookmark__overflow{
overflow-y: scroll !important;
}
 .v-select {
    &::v-deep {
      .vs__dropdown-toggle {
        height: 50px;
      }
      .vs__selected {
        overflow: hidden;
        text-overflow: ellipsis;
      }
    }
  }
}
</style>
