<template>
  <b-modal centered id="my-modal-bookmark" v-model="showModalAxe" hide-header hide-footer>
    <b-row>
      <ValidationObserver
        v-slot="{ invalid }"
        ref="form"
        tag="form"
        novalidate
        @submit.prevent="onSubmit"
      >
        <b-form
          @submit.prevent="onSubmit"
        >
        <b-form-group>
        <label for="titleId"
          >Saisir le nom du Bookmark <span class="text-danger">*</span></label>
          <FormFieldInput
            v-model="form.title"
            type="text"
            id="input-1"
            rules="required"
            name="Titre du Bookmark"
            mode="aggressive"
            style="width:435px"
          />
          <b-form-text id="title-help-block" class="mb-1"
            ><span class="text-danger"></span
          ></b-form-text>
        </b-form-group>
          <b-row>
            <b-button
            type="submit"
            variant="primary"
            :disabled="invalid ? true : false"
            >
              <small>Enregistrer</small>
            </b-button>
          </b-row>
        </b-form>
      </ValidationObserver>
    </b-row>
  </b-modal>
</template>
<script>
import { mapActions } from 'vuex'
import { ValidationObserver } from 'vee-validate'
import FormFieldInput from '../../../../components/forms/FormFieldInput.vue'
export default {
  components: {
    ValidationObserver,
    FormFieldInput
  },
  props: {
    dataBookmark: {
      type: Object,
      default: () => {
        return {}
      }
    },
    modalShow: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      form: {
        title: ''
      },
      showModalAxe: this.modalShow
    }
  },
  watch: {
    modalShow () {
      this.showModalAxe = this.modalShow
    }
  },
  methods: {
    ...mapActions([
      'createBookmark'
    ]),
    onSubmit () {
      this.createBookmark({
        ...this.dataBookmark,
        name: this.form.title
      })
        .then(() => {
          this.$notify({
            group: 'alert',
            title: 'Bookmark',
            text: 'Bookmark ajouter avec succès',
            type: 'success'
          })
          this.$bvModal.hide('my-modal-bookmark')
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
          console.log(response)
        })
    }
  }
}
</script>
