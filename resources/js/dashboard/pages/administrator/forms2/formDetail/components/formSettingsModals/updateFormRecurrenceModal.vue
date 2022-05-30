<template>
  <b-modal id="updateFormRecurrenceModal" centered hide-footer hide-header>
    <b-container>
      <div class="mb-4 p-2">
        <h3 class="lead text-center text-bold">
          Changer la récurrence du formulaire
        </h3>
        <ValidationObserver
          v-slot="{ invalid }"
          ref="form"
          tag="form"
          novalidate
          @submit.prevent="onUpdateFormRecurrence"
          @reset.prevent="onReset"
          label-class="text-dash-color"
        >
          <b-form @submit.prevent="onUpdateFormRecurrence">
            <b-row class="mt-4">
              <b-col md="6" xs="12">
                <span class="text-recurrence">Chaque</span>
              </b-col>
              <b-col md="6" xs="12">
                <FomFieldSelect
                  v-model="targetForm.form_recurrence_id"
                  :options="formRecurrences"
                  label="name"
                  :reduce="(item) => item.id"
                  :isObligated="false"
                  value="name"
                  rules="required"
                  id="form.form_recurrence_id"
                  name="Recurrence du formulaire"
                  mode="aggressive"
                />
              </b-col>
            </b-row>
            <b-row class="mb-2" v-if="isWeek">
              <b-col>Répété sur</b-col>
            </b-row>
            <div class="row-week-day" v-if="isWeek">
              <div>
                <span :class="showColorDim?styleBlue:styleGrey" disabled="true" @click="onclickWeek('0')">D</span>
              </div>
              <div>
                <span :class="showColorLun?styleBlue:styleGrey"  class="left-cell" @click="onclickWeek('1')">L</span>
              </div>
              <div>
                <span :class="showColorMar?styleBlue:styleGrey"  class="left-cell" @click="onclickWeek('2')">M</span>
              </div>
              <div>
                <span :class="showColorMer?styleBlue:styleGrey"  class="left-cell" @click="onclickWeek('3')">M</span>
              </div>
              <div>
                <span :class="showColorJeu?styleBlue:styleGrey"  class="left-cell" @click="onclickWeek('4')">J</span>
              </div>
              <div>
                <span :class="showColorVen?styleBlue:styleGrey"  class="left-cell"  @click="onclickWeek('5')">V</span>
              </div>
              <div>
                <span :class="showColorSam?styleBlue:styleGrey"  class="left-cell" @click="onclickWeek('6')">S</span>
              </div>
            </div>
            <b-row v-if="isMonth" class="mt-3">
              <b-col md="8">
                <span>Le jour</span>
              </b-col>
              <b-col>
                <v-select
                  v-model="targetForm.form_recurrence_value"
                  :options="dayofMonth"
                  label="label"
                  :reduce="(item)=>item.label"
                  :searchable="false"
                  id="form.form_recurrence_value"
                >
                </v-select>
              </b-col>
          </b-row>
          <b-row v-if="isYear" class="mt-3">
            <b-col>
              <span>Le mois de </span>
            </b-col>
            <b-col>
              <v-select
                v-model="targetForm.form_recurrence_value"
                :options="monthsofYear"
                label="label"
                :reduce="(item)=>item.id"
                :searchable="false"
                id="form.form_recurrence_value"
              >
              </v-select>
            </b-col>
          </b-row>
          <div class="mt-4 text-center">
            <b-button
            @click.prevent="onCancelRecurrenceForm()"
            type="submit"
            variant="outline-danger"
            class="mr-3"
            >Annuler</b-button>
            <b-button
            @click.prevent="onUpdateFormRecurrence()"
            type="submit"
            variant="primary"
            >Modifier</b-button>
          </div>
          </b-form>
        </ValidationObserver>
      </div>
    </b-container>
  </b-modal>
</template>

<script>
import FomFieldSelect from '../../../../../../components/forms/FomFieldSelect'
import { formRecurrences } from '../../../../../../plugins/variables'
import { ValidationObserver } from 'vee-validate'
import { mapActions, mapState } from 'vuex'
export default {
  components: {
    FomFieldSelect,
    ValidationObserver
  },
  props: {
    formToPopulate: {
      type: Object,
      default: () => {}
    },
    isUpdatingFormTile: {
      type: Boolean,
      default: () => false
    }
  },
  data () {
    return {
      targetForm: {
        form_recurrence_id: null,
        form_recurrence_value: null
      },
      isUpdating: this.isUpdatingFormTile,
      showColorDim: false,
      showColorLun: false,
      showColorMar: false,
      showColorMer: false,
      showColorJeu: false,
      showColorVen: false,
      showColorSam: false,
      styleGrey: 'week-day-grey',
      styleBlue: 'week-day-blue',
      dayofMonth: [
        {
          id: 1,
          label: '1'
        },
        {
          id: 2,
          label: '2'
        },
        {
          id: 3,
          label: '3'
        },
        {
          id: 4,
          label: '4'
        },
        {
          id: 5,
          label: '5'
        },
        {
          id: 6,
          label: '6'
        },
        {
          id: 7,
          label: '7'
        },
        {
          id: 8,
          label: '8'
        },
        {
          id: 9,
          label: '9'
        },
        {
          id: 10,
          label: '10'
        },
        {
          id: 11,
          label: '11'
        },
        {
          id: 12,
          label: '12'
        },
        {
          id: 13,
          label: '13'
        },
        {
          id: 14,
          label: '14'
        },
        {
          id: 15,
          label: '15'
        },
        {
          id: 16,
          label: '16'
        },
        {
          id: 17,
          label: '17'
        },
        {
          id: 18,
          label: '18'
        },
        {
          id: 19,
          label: '19'
        },
        {
          id: 20,
          label: '20'
        },
        {
          id: 21,
          label: '21'
        },
        {
          id: 22,
          label: '22'
        },
        {
          id: 23,
          label: '23'
        },
        {
          id: 24,
          label: '24'
        },
        {
          id: 25,
          label: '25'
        },
        {
          id: 26,
          label: '26'
        },
        {
          id: 27,
          label: '27'
        },
        {
          id: 28,
          label: '28'
        },
        {
          id: 29,
          label: 'last'
        }
      ],
      monthsofYear: [
        {
          id: '1',
          label: 'Janvier'
        },
        {
          id: '2',
          label: 'Février'
        },
        {
          id: '3',
          label: 'Mars'
        },
        {
          id: '4',
          label: 'Avril'
        },
        {
          id: '5',
          label: 'Mai'
        },
        {
          id: '6',
          label: 'Juin'
        },
        {
          id: '7',
          label: 'Juillet'
        },
        {
          id: '8',
          label: 'Août'
        },
        {
          id: '9',
          label: 'Septembre'
        },
        {
          id: '10',
          label: 'Octobre'
        },
        {
          id: '11',
          label: 'Novembre'
        },
        {
          id: '12',
          label: 'Décembre'
        }
      ]
    }
  },
  async mounted () {
    await this.getFormsRecurrences()
  },
  computed: {
    ...mapState({
      formRecurrences: (state) => state.form.formsRecurrences
    }),
    isWeek () {
      return this.targetForm.form_recurrence_id === this.formRecurrences.find((recurrence) => recurrence.id === formRecurrences.WEEK).id
    },
    isMonth () {
      return this.targetForm.form_recurrence_id === this.formRecurrences.find((recurrence) => recurrence.id === formRecurrences.MONTH).id
    },
    isYear () {
      return this.targetForm.form_recurrence_id === this.formRecurrences.find((recurrence) => recurrence.id === formRecurrences.YEAR).id
    }
  },
  watch: {
    formToPopulate () {
      this.populateRecurrenceForm()
    }
  },
  methods: {
    ...mapActions(['getFormsRecurrences']),
    onReset () {
      this.targetForm = {}
    },
    hideModal () {
      this.$bvModal.hide('updateFormRecurrenceModal')
    },
    onCancelRecurrenceForm () {
      this.hideModal()
    },
    populateRecurrenceForm () {
      this.targetForm.form_recurrence_id = this.formToPopulate.form_recurrence
    },
    onUpdateFormRecurrence () {
      this.$emit('onUpdateFormRecurrence', {
        ...this.targetForm,
        formFieldmodalMessage:
          'La recurrence du formulaire a été modifiée avec succès'
      })
      this.hideModal()
    },
    onclickWeek (week) {
      this.targetForm.form_recurrence_value = week
      if (week === '0') {
        this.showColorDim = true
      }
      if (week === '1') {
        this.showColorLun = true
        this.showColorDim = false
      }
      if (week === '2') {
        this.showColorMar = true
        this.showColorLun = false
        this.showColorDim = false
      }
      if (week === '3') {
        this.showColorMer = true
        this.showColorMar = false
        this.showColorLun = false
        this.showColorDim = false
      }
      if (week === '4') {
        this.showColorJeu = true
        this.showColorMer = false
        this.showColorMar = false
        this.showColorLun = false
        this.showColorDim = false
      }
      if (week === '5') {
        this.showColorVen = true
        this.showColorJeu = false
        this.showColorMer = false
        this.showColorMar = false
        this.showColorLun = false
        this.showColorDim = false
      }
      if (week === '6') {
        this.showColorSam = true
        this.showColorVen = false
        this.showColorJeu = false
        this.showColorMer = false
        this.showColorMar = false
        this.showColorLun = false
        this.showColorDim = false
      }
    },
  }
}
</script>

<style lang="scss" scoped>
  .row-week-day{
    display: flex;
    .week-day-blue{
      padding: 3px 9px;
      border-radius: 50%;
      cursor: pointer;
      background-color:#1a73e8;
      pointer-events: none;
    }
    .week-day-grey{
      padding: 3px 9px;
      border-radius: 50%;
      cursor: pointer;
      background-color:#ced4da;
    }
    .left-cell{
      margin-left:5px;
    }
  }
</style>
