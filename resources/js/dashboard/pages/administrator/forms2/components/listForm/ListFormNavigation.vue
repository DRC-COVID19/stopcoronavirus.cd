<template>
  <div class="form__navigation-container mb-4">

                <div class="form__nav">
                   <Transition name="fade">
                    <a
                    :class="{ selected: filter === 'publish' }"
                    @click.prevent="getfilter('publish')"
                    @mouseenter="filter='publish'"
                    class="filterLink"
                >
                    Publiés
                </a>
                   </Transition>
                 <Transition name="fade">
                <a
                    :class="{ selected: filter === 'unpublish' }"
                    @click.prevent="getfilter('unpublish')"
                     @mouseenter="filter='unpublish'"
                    class="filterLink"
                >
                    Non publiés
                </a>
                </Transition>
                <Transition name="fade">
                <a
                    :class="{ selected: filter === 'all' }"
                    @click.prevent="getfilter('all')"
                    class="filterLink"
                     @mouseenter="filter='all'"
                >
                    Tous
                </a>
                 </Transition>
                </div>
                 <div class="d-flex">
                    <div class="input-search d-flex justify-content-around">
                    <v-date-picker
                      v-model="form.last_update"
                      opens="center"
                      :max-date="max"
                      class="d-flex style-picker"
                      @input="getFormsByDate()"
                      show-weeknumbers
                    >
                      <template v-slot="{ inputEvents, inputValue }">
                        <div
                          class="
                            d-flex
                            flex-col
                            sm:flex-row
                            justify-content-center
                            text-center
                            item-center
                            btn-container-calendar
                          "
                        >
                          <input
                            id="last_update"
                            class="p-1 w-full"
                            :value="
                              inputValue
                                ? moment(form.last_update).format('DD.MM.YYYY')
                                : ''
                            "
                            placeholder="Filtrer par Date"
                            v-on="inputEvents"
                          />
                         <i class="fas fa-calendar-alt pt-2"></i>
                        </div>
                      </template>
                    </v-date-picker>
                    </div>
                    <div>
                        <v-select
                        v-model="form.form_recurrence_id"
                        placeholder="Filtrer par Reccurence"
                        :options="formRecurrences"
                        label="name"
                        :reduce="(item)=>item.id"
                        id="id"
                        class="border-0 input-select ml-4"
                        :searchable="false"
                        @input="selectRecurrence()"
                     />
                    </div>

                    <div class="input-search d-flex justify-content-around">
                        <input
                        v-model="title"
                        type="text"
                        class="input-lg"
                        placeholder="Rechercher par Nom" />
                         <img src="/img/codicon_search.svg" class="img-search ml-4 ml-md-0"/>
                    </div>
                 </div>
                  
             </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
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
      filter: 'all',
      max: new Date(),
      updating: false,
      isLoading: false,
      validateMailMessage: '',
      published: false,
      title: '',
      form: {
        form_recurrence_value: null,
        form_recurrence_id: null,
        publish: false,
        unpublish: false,
        last_update: null
      },
      show: true,
      showWarning: false,
      toBeCanceled: true,
      formRecurrenceSelected: null
    }
  },
  async mounted () {
    this.resetForm()
    await this.getFormsRecurrences()
  },
  computed: {
    ...mapState({
      formRecurrences: (state) => state.form.formsRecurrences
    })
  },
  watch: {
    title () {
      this.search()
    }
  },
  methods: {
    ...mapActions(['getFormsRecurrences']),
    getfilter (value) {
      if (value === 'publish') {
        this.form.publish = true
        delete (this.form.unpublish)
      } else if (value === 'unpublish') {
        this.form.unpublish = true
        delete (this.form.publish)
      } else if (value === 'all') {
        delete (this.form.publish)
        delete (this.form.unpublish)
        delete (this.form.last_update)
        delete (this.form.form_recurrence_id)
      }
      this.setFormAndEmmit()
    },
    getFormsByDate () {
      this.setFormAndEmmit()
    },
    selectRecurrence () {
      this.setFormAndEmmit()
    },
    search () {
      this.$emit('onSearch', this.title.trim())
    },
    setFormAndEmmit () {
      const form = {
        form_date: this.form.last_update ?? null,
        published_form: this.form.publish ?? null,
        unpublished_form: this.form.unpublish ?? null,
        recurrence_form: this.form.form_recurrence_id ?? null
      }
      this.$emit('filterForms', form)
    }
  }
}
</script>

<style lang="scss">
@import "@~/sass/_variables";

.form__navigation-container{
  display: flex;
  justify-content: space-between;

 @media (max-width: $max-width) {
  & {
    z-index: 5;
    height: 10vh;
    width: 100%;
    border-right: 0;
    overflow-x: scroll !important;
    white-space: nowrap;
  }
}      /* color of the tracking area */
}
.input-select{
    width: 220px;
    background-color: #F1F3F4;
    border-radius: 5px;
    margin-right: 2rem;

  .vs__dropdown-toggle{
    box-shadow: none;
    border: 0;
    padding: .2rem 0;
    /* font-style: italic; */
}
.vs__dropdown-toggle::placeholder{
          color:#535356 !important;
          font-style: italic !important;
          font-size: 14px;
    }
}
.input-search{
    width: 220px;
     height: 35px;
      /* border: solid 1px #cfcdcd; */
    background-color: #F1F3F4;
    border-radius: 5px;
        input {
            border: 0;
            background-color: #F1F3F4;
            outline: none;
            &::placeholder{
            color:#535356;
            padding: 10px;
            font-style: italic;
            font-size: 14px;
        }
    }
}
.img-search{
    width: 20px !important;
}
.form__nav{
    display: flex;
    justify-content: space-around;
    .filterLink{
	  display: block;
	  color: #14244F;
		cursor: pointer;
		padding: 0.5rem 1rem;
		border:0;
		background-color:transparent;
		text-align: center;
		transition: background-color .3s ease-in;
		font-weight: 700;
   }
    .selected{
		transition: all .2s ease-in;
		color:#3767FA;
        &::after{
            content: "";
            display: block;
            border: 1px solid #3767FA;
        }
	}

	.fade-enter-active,.fade-leave-active{
		transition: opacity 5s transform 5s;
	}
	.fade-enter, .fade-leave-active{
		opacity: 0;
		transform: translateX(20px);
	}


}

</style>
