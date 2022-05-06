<template>
  <div class="d-flex justify-content-between mb-4">

                <div class="form__nav">
                    <a
                    :class="{ selected: filter === 'published' }"
                    @click.prevent="filter = 'published'"
                    class="filterLink"
                >
                    Publiés
                </a>
                <a
                    :class="{ selected: filter === 'unPublished' }"
                    @click.prevent="filter = 'unPublished'"
                    class="filterLink"
                >
                    Non publiés
                </a>
                <a
                    :class="{ selected: filter === 'all' }"
                    @click.prevent="filter = 'all'"
                    class="filterLink"
                >
                    Tous
                </a>
                </div>
                 <div class="d-flex">
                     <div class="input-search d-flex justify-content-around">
                        <input type="text" class="input-lg" placeholder="Rechercher par Nom" />
                         <img src="/img/codicon_search.svg" class="img-search ml-4 ml-md-0"/>
                    </div>
                    <div>
                        <v-select
                        v-model="form.recurrences_id"
                        :options="recurrences"
                        label="name"
                        :reduce="(item)=>item.id"
                        id="id"
                        class="border-0 input-select ml-4"
                        :searchable="false"
                />
                    </div>

                    <div class="input-search d-flex justify-content-around">
                        <input type="text" class="input-lg" placeholder="Rechercher par Nom" />
                         <img src="/img/codicon_search.svg" class="img-search ml-4 ml-md-0"/>
                    </div>
                 </div>

             </div>
</template>

<script>
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
    formRecurrences: {
      type: Array,
      default: () => {
        return []
      }
    },
    errors: {
      type: Object,
      default: () => ({})
    }
  },
  data () {
    return {
      filter: '',
      updating: false,
      isLoading: false,
      validateMailMessage: '',
      published: false,
      form: {
        title: '',
        form_recurrence_value: null,
        form_recurrence_id: '',
        publish: false
      },
      show: true,
      showWarning: false,
      toBeCanceled: true,
      formRecurrenceSelected: null
    }
  }

}
</script>

<style lang="scss">
.input-select{
    width: 220px;
    border: solid 1px #E4E4E4;
    background-color: #F1F3F4;
    border-radius: 5px;
    margin-right: 2rem;
}
.input-search{
    width: 220px;
     height: 35px;
      border: solid 1px #cfcdcd;
    background-color: #F1F3F4;
    border-radius: 5px;
        input {
            border: 0;
            background-color: #F1F3F4;
            outline: none;
            &::placeholder{
            color:#535356;
            padding: 10px;
            font-style: initial;
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
