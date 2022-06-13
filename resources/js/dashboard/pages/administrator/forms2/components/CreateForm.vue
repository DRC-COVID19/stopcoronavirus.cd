<template>
  <b-card class="border-0">
    <ValidationObserver
      v-slot="{ invalid }"
      ref="form"
      tag="form"
      novalidate
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <b-form
        @submit.prevent="onSubmit"
        @reset.prevent="onReset"
        v-if="show"
        label-class="text-dash-color"
      >
        <label id="input-group-1" for="input-1" class="text-dash-color"
          >Titre du Formulaire <span class="text-danger">*</span></label
        >
        <FormFieldInput
          v-model="form.title"
          type="text"
          id="input-1"
          :placeholder="`Entrer le titre du formulaire`"
          rules="required"
          name="Titre du formulaire"
          mode="aggressive"
        />
        <b-form-text id="title-help-block" class="mb-4"
          ><span class="text-danger"></span
        ></b-form-text>
        <label id="input-group-1" for="input-1" class="text-dash-color"
          >Recurrence du Formulaire <span class="text-danger">*</span></label
        >
        <b-row>
          <b-col md="3" xs="12" class="mt-3">
            <span class="text-recurrence">Chaque</span>
          </b-col>
          <b-col md="3" xs="12">
              <b-form-input
                v-if="isNumber"
                v-model="form.form_recurrence_number"
                type="number"
                class="mt-2 input-recurrence"
                min="0"
                >
              </b-form-input>
          </b-col>
          <b-col md="6" xs="12">
            <FomFieldSelect
              v-model="form.form_recurrence_id"
              :options="formRecurrences"
              label="name"
              :reduce="(item) => item.id"
              :isObligated="false"
              rules="required"
              id="form.form_recurrence_id"
              name="Recurrence du formulaire"
              mode="aggressive"
              class="form-select"
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
              v-model="form.form_recurrence_value"
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
              v-model="form.form_recurrence_value"
              :options="monthsofYear"
              label="label"
              :reduce="(item)=>item.id"
              :searchable="false"
              id="form.form_recurrence_value"
            >
            </v-select>
          </b-col>
        </b-row>
        <b-row class="mt-3">
          <b-col md="12" xs="12">
            <FomFieldSelect
              v-model="form.conflict_resolution_mode_id"
              :options="conflictResolutionModes"
              label="name"
              :reduce="(item) => item.id"
              :isObligated="true"
              rules="required"
              id="form.conflict_resolution_mode_id"
              labelText="Mode résolution de conflit"
              name="Mode résolution de conflit"
              mode="aggressive"
              class="form-select"
            />
          </b-col>
        </b-row>
        <b-row class="px-3 pt-4 d-flex justify-content-start">
          <b-button
            type="submit"
            variant="primary"
            :disabled="invalid ? true : false"
          >
            <span v-if="isLoading"
              ><b-spinner class="align-middle"></b-spinner>
              <span>en cours ...</span>
            </span>
            <div v-else>
              {{ btnTitle }}
            </div>
          </b-button>
          <b-button
            type="reset"
            variant="outline-danger"
            class="ml-4"
            @click="resetForm()"
            >{{ updating ? "Annuler" : "Réinitialiser" }}</b-button
          >
        </b-row>
      </b-form>
    </ValidationObserver>
  </b-card>
</template>

<script>
import FormFieldInput from '../../../../components/forms/FormFieldInput'
import FomFieldSelect from '../../../../components/forms/FomFieldSelect.vue'
import { formRecurrences } from '../../../../plugins/variables'
import { ValidationObserver } from 'vee-validate'
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    FormFieldInput,
    ValidationObserver,
    FomFieldSelect
  },
  props: {
    formAdded: {
      type: Boolean,
      required: false,
      default: false
    },
    formUpdated: {
      type: Boolean,
      required: false,
      default: false
    },
    formToPopulate: {
      type: Object,
      required: false,
      default: () => {
        return {}
      }
    },
    errors: {
      type: Object,
      default: () => ({})
    }
  },
  data () {
    return {
      title: 'Nouveau Formulaire',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-plus-square',
      updating: false,
      isLoading: false,
      validateMailMessage: '',
      published: false,
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
          label: '29'
        },
        {
          id: 30,
          label: '30'
        },
        {
          id: 31,
          label: '31'
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
      ],
      form: {
        title: '',
        form_recurrence_value: null,
        form_recurrence_number: null,
        form_recurrence_id: '',
        conflict_resolution_mode_id: '',
        publish: false
      },
      isNumber: false,
      show: true,
      showColorDim: false,
      showColorLun: false,
      showColorMar: false,
      showColorMer: false,
      showColorJeu: false,
      showColorVen: false,
      showColorSam: false,
      showWarning: false,
      toBeCanceled: true,
      formRecurrenceSelected: null,
      styleGrey: 'week-day-grey',
      styleBlue: 'week-day-blue'
    }
  },
  async mounted () {
    this.resetForm()
    await this.getFormsRecurrences()
    await this.getConflictResolutionModes()
  },
  computed: {
    ...mapState({
      formRecurrences: (state) => state.form.formsRecurrences
    }),
    ...mapState({
      conflictResolutionModes: (state) => state.form.conflictResolutionModes
    }),
    isWeek () {
      return this.form.form_recurrence_id === this.formRecurrences.find((recurrence) => recurrence.id === formRecurrences.WEEK).id
    },
    isMonth () {
      return this.form.form_recurrence_id === this.formRecurrences.find((recurrence) => recurrence.id === formRecurrences.MONTH).id
    },
    isYear () {
      return this.form.form_recurrence_id === this.formRecurrences.find((recurrence) => recurrence.id === formRecurrences.YEAR).id
    }

  },
  watch: {
    formAdded () {
      this.resetForm()
    },
    formUpdated () {
      this.resetForm()
    },
    formToPopulate () {
      this.resetForm()
      this.populateForm()
    }
  },
  methods: {
    ...mapActions(['getFormsRecurrences', 'getConflictResolutionModes']),
    onclickWeek (week) {
      this.form.form_recurrence_value = week
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
    onSubmit () {
      this.isLoading = true
      if (this.btnTitle === 'Enregistrer') {
        this.$emit('onCreate', this.form)
      } else {
        this.$emit('onUpdate', this.form)
      }
    },

    onReset () {
      this.$refs.form.reset()

      this.toToCanceled = true
      this.form = {}
      this.title = 'Nouveau Formulaire'
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    resetForm () {
      this.$refs.form.reset()

      this.updating = false
      this.isLoading = false
      this.form = {
        title: '',
        form_recurrence_value: null,
        form_recurrence_id: '',
        publish: false
      }
      this.btnTitle = 'Enregistrer'
      this.title = 'Nouveau Formulaire'
      this.showColorSam = false
      this.showColorVen = false
      this.showColorJeu = false
      this.showColorMer = false
      this.showColorMar = false
      this.showColorLun = false
      this.showColorDim = false
    },

    populateForm () {
      this.updating = false

      if (Object.keys(this.formToPopulate).length !== 0) {
        this.updating = true
        this.form.id = this.formToPopulate.id
        this.form.title = this.formToPopulate.title
        this.form.form_recurrence_value = this.formToPopulate.form_recurrence_value
        this.form.form_recurrence_id = this.formToPopulate.form_recurrence_id
        this.form.form_recurrence_number = this.formToPopulate.form_recurrence_number
        this.form.publish = this.formToPopulate.publish
        this.title = 'Modification du formulaire'
        this.btnTitle = 'Modifier'
      }
    },

    onFormRecurrenceChange (formRecurrenceId) {
      this.form.form_recurrence_value = null
      this.formRecurrenceSelected = this.formRecurrences.find(
        (formRecurrence) => formRecurrence.id === formRecurrenceId
      )
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
}
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
