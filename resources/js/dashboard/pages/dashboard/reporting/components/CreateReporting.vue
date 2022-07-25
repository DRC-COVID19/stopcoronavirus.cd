<template>
  <b-tabs class="mx-0">
        <b-tab title="paramétrage" :active="title==='paramétrage'">
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
              <b-col class="mt-1 d-flex justify-content-around" lg="12">
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
        <b-tab title="Bookmark">
          <b-row>
            <b-col class="mx-0 w-100 mt-4" lg="12">
                <label for class="text-dash-color">Sélectionner le bookmark :</label>
                <b-list-group v-for="(bookmark) in bookmarks" :key="bookmark.id" class="rounded-0 w-100">
                    <b-list-group-item :active="bookmark.id === activeItem" @click="selectedBookmark(bookmark)" style="cursor: pointer;">{{bookmark.name}}</b-list-group-item>
                </b-list-group>
              </b-col>
          </b-row>
        </b-tab>
      </b-tabs>
</template>

<script>
import { mapState } from 'vuex'
import Questions from './Questions'
export default {
  components: {
    Questions
  },
  props: {
    activeItem: {
      type: Boolean,
      default: () => false
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
      columnsSelected: (state) => state.reporting.columnsSelected,
    })
  },
  data () {
    return {
      report: this.reporting,
      title: ''
    }
  },
  watch: {
    reporting (value) {
      this.report = value
    }
  },
  methods: {
    selectedForm () {
      this.$emit('selectedForm')
    },
    resetForm () {
      this.$refs.QuestionsOne.resetForm()
      this.$refs.QuestionsTwo.resetForm()
      this.report = {}
      this.$emit('resetForm')
    },
    selectedBookmark (bookmark) {
      this.$emit('selectedBookmark', bookmark)
    },
    savedBookmark () {
      this.$emit('savedBookmark')
    }
  }

}
</script>

<style>

</style>
