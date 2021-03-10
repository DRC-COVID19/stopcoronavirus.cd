<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse">
      <b-col md="4">
        <b-card class="mt-3">
          <h3>Ajouter</h3>
          <b-form @submit.prevent="submit_form">
            <b-row>
              <b-form-group
                label="Date"
                label-class="text-dash-color"
                :invalid-feedback="errors.publish_date ? errors.publish_date[0] : null"
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
            </b-row>
            <b-row class="d-flex justify-content-start">
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-2"
                  label="Confirmes "
                  label-for="input-2"
                >
                  <b-form-input
                    id="input-two"
                    class="input-dash"
                    v-model="form.confirmed"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-3"
                  label="Actifs "
                  label-for="input-3"
                >
                  <b-form-input
                    id="input-three"
                    class="input-dash"
                    v-model="form.sick"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-4"
                  label="Grave"
                  label-for="input-4"
                >
                  <b-form-input
                    id="input-four"
                    class="input-dash"
                    v-model="form.seriously"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-5"
                  label="Gueris"
                  label-for="input-5"
                >
                  <b-form-input
                    id="input-five"
                    class="input-dash"
                    v-model="form.healed"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-col md="4">
                <b-form-group
                  label-class="text-dash-color"
                  id="input-group-6"
                  label="Deces"
                  label-for="input-6"
                >
                  <b-form-input
                    id="input-six"
                    class="input-dash"
                    v-model="form.dead"
                    v-int
                    placeholder=""
                  ></b-form-input>
                </b-form-group>
              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-col>
      <b-col md="8">
        <b-table>
          
        </b-table>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  import Header from '../components/Header';
  export default {
    components: {
      Header
    },
    data () {
      return {
        errors: {},
        form: {},
        isUpdating: false,
        currentItem: {},
        isCreating: false,
        isLoading: false
      }
    }
  }
</script>

<style lang="scss" scoped>
  
</style>