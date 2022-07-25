<template>
  <b-col class="mx-0 w-100" lg="12">
    <label for class="text-dash-color"><b-badge class="px-2"> {{ step}} </b-badge> : {{ title }}</label>
      <div class="input-search d-flex justify-content-around mb-2">
      <input
        v-model="formFieldTitle"
        type="text"
        class="input-lg"
        :placeholder="placeholder"
      />
      <img src="/img/codicon_search.svg" class="img-search ml-4 ml-md-0" />
    </div>
    <b-row>
      <b-col class="w-100 mx-1 py-1 container-axe" lg="11">
         <div class="mt-4">
          <b-form-group label="" v-slot="{ ariaDescribedby }">
            <b-form-checkbox-group
              id="checkbox-group-1"
              v-model="datesSelected"
              :aria-describedby="ariaDescribedby"
              name="name"
              @change="emitSelectedItems()"
            >
              <b-form-checkbox :value="{ name: 'Date', type:'date' }" checked="1" v-show="showDate && isDataSourceSelected">
                Date
              </b-form-checkbox>
            </b-form-checkbox-group>
             <b-form-checkbox-group
              id="checkbox-group-2"
              v-model="townshipsSelected"
              :aria-describedby="ariaDescribedby"
              name="name"
              @change="emitSelectedItems()"
            >
              <b-form-checkbox :value="{ name: 'Commune', type:'township' }" v-show="showTownship && isDataSourceSelected">
                Commune
              </b-form-checkbox>
            </b-form-checkbox-group>
            <b-form-checkbox-group
              id="checkbox-group-2"
              v-model="hospitalsSelected"
              :aria-describedby="ariaDescribedby"
              name="name"
              @change="emitSelectedItems()"
            >
              <b-form-checkbox :value="{ name: 'Hopital', type:'hospital' }" v-show="showHospital && isDataSourceSelected"
                >Hôpital
              </b-form-checkbox>
            </b-form-checkbox-group>
          </b-form-group>
        </div>
        <hr v-show="showHospital && isDataSourceSelected"/>

          <b-form-group label="" v-slot="{ ariaDescribedby }">
             <label for class="text-dash-color text-primary">{{ !isDataSourceSelected ?'Veuillez selectionner une source de données':'Questions:'}}</label>
            <b-form-checkbox-group
              id="checkbox-group-2"
              v-model="formFieldsSelected"
              :aria-describedby="ariaDescribedby"
              name="name"
              @change="emitSelectedItems()"
            >
              <b-form-checkbox
                v-for="(field, index) in formFieldsFiltered"
                :key="index"
                :value="{ id: field.id, name: field.name, type:'form_field' }"
                >{{ field.name }}</b-form-checkbox
              >
            </b-form-checkbox-group>
          </b-form-group>

      </b-col>
    </b-row>
  </b-col>
</template>
<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
  props: {
    title: {
      type: String,
      default: () => ''
    },
    type: {
      type: String,
      default: () => ''
    },
    step: {
      type: String,
      default: () => ''
    },
    cloneOptionQuestions: {
      type: Array,
      default: () => []
    },
    except: {
      type: Array,
      default: () => []
    },
    placeholder: {
      type: String,
      default: () => ''
    },
    isDataSourceSelected: {
      type: Boolean,
      default: () => false,
      required: true
    }
  },
  data () {
    return {
      datesSelected: [],
      formFieldsSelected: [],
      hospitalsSelected: [],
      townshipsSelected: [],
      formFieldTitle: ''
    }
  },
  computed: {
    ...mapState({
      hospitals: (state) => state.hospital.allHospitals,
      townships: (state) => state.township.townships,
      linesSelected: (state) => state.reporting.linesSelected,
      columnsSelected: (state) => state.reporting.columnsSelected
    }),
    showTownship () {
      return this.except.filter(
        (item) => item.type === 'township'
      ).length === 0
    },
    showHospital () {
      return this.except.filter(
        (item) => item.type === 'hospital'
      ).length === 0
    },
    showDate () {
      return this.except.filter(
        (item) => item.type === 'date'
      ).length === 0
    },
    formFieldsFiltered () {
      const exceptFormFields = this.except.filter(
        (item) => item.type === 'form_field'
      )
      return this.cloneOptionQuestions.filter((formField) => {
        return (
          !exceptFormFields.find((item) => item.id === formField.id) &&
          formField.name.match(this.formFieldTitle)
        )
      })
    }
  },
  watch: {
    linesSelected () {
      if (this.type.match('line')) {
        this.datesSelected = this.linesSelected.filter(
          (item) => item.type === 'date'
        )
        this.hospitalsSelected = this.linesSelected.filter(
          (item) => item.type === 'hospital'
        )
        this.townshipsSelected = this.linesSelected.filter(
          (item) => item.type === 'township'
        )
        this.formFieldsSelected = this.linesSelected.filter(
          (item) => item.type === 'form_field'
        )
      }
    },
    columnsSelected () {
      if (this.type.match('column')) {
        this.datesSelected = this.columnsSelected.filter(
          (item) => item.type === 'date'
        )
        this.hospitalsSelected = this.columnsSelected.filter(
          (item) => item.type === 'hospital'
        )
        this.townshipsSelected = this.columnsSelected.filter(
          (item) => item.type === 'township'
        )
        this.formFieldsSelected = this.columnsSelected.filter(
          (item) => item.type === 'form_field'
        )
      }
    }
  },
  methods: {
    ...mapActions(['reporting__editLines', 'reporting__editColumns']),
    emitSelectedItems () {
      const selectedItems = []
      selectedItems.push(
        ...this.formFieldsSelected.map((formField) => ({
          id: formField.id,
          name: formField.name,
          type: 'form_field'
        }))
      )
      selectedItems.push(
        ...this.hospitalsSelected.map((hospital) => ({
          name: hospital.name,
          type: 'hospital'
        }))
      )

      selectedItems.push(
        ...this.townshipsSelected.map((township) => ({
          name: township.name,
          type: 'township'
        }))
      )
      selectedItems.push(
        ...this.datesSelected.map((date) => ({
          name: date.name,
          type: 'date'
        })))
      if (this.type.match('line')) {
        this.reporting__editLines(selectedItems)
      } else {
        this.reporting__editColumns(selectedItems)
      }
    },
    resetForm () {
      this.datesSelected = []
      this.formFieldsSelected = []
      this.townshipsSelected = []
      this.hospitalsSelected = []
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.input-search {
  width: 100%;
  height: 40px;
  border-radius: 5px;
  border: 1px solid #bfcbd9;
  background-color: #fff;
  border: solid 1px #cfcdcd;
  input {
    border: 0;
    outline: none;
    background-color: #fff;
    width: 70%;
    &::placeholder {
      color: #535356;
      padding: 10px;
      font-size: 16px;
    }
  }
}
.border-dash {
  border: solid 1px #cfcdcd;
}
.img-search {
  width: 20px !important;
}
.border-dash {
  border: solid 1px #cfcdcd;
}
.img-search {
  width: 20px !important;
}
.container-axe {
  height: 200px;
  border: 1px solid #bfcbd9;
  overflow-y: scroll;
  overflow-x: hidden;
  border-radius: 5px 5px 0px 0px;
  &::-webkit-scrollbar {
    width: 0;
    background: transparent;
  }
  .container-axe-child {
    display: inline-block;
    width: auto;
  }
}

.close-icon-list {
  font-size: 18px;
  color: white;
  position: relative;
  top: 4px;
  left: 4px;
  cursor: pointer;
}
.text-question {
  max-width: calc(100% - 18px);
  text-overflow: ellipsis;
  display: inline-block;
  overflow: hidden;
}
</style>
