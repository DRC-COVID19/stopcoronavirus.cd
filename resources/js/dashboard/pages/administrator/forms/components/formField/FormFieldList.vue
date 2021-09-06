<template>
  <div>
    <b-card>
    <b-card-header v-b-toggle.collapse-form-field-list>
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
          Liste des champs
        </span>
        <i class="fas fa-chevron-down" aria-hidden="true"></i>
      </div>
    </b-card-header>
    <b-collapse id="collapse-form-field-list" class="mt-2" visible>
      <b-card-body>
         <b-form-group
            v-for="(item, index) in formFieldSorted"
            :key="index"
            :label="item.name"
            :label-for="item.name"
          >
            <b-form-input
              :type="item.form_field_type.name"
              :placeholder="`Entrer ${item.name}`"
            ></b-form-input>
          </b-form-group>
      </b-card-body>
    </b-collapse>
  </b-card>
  </div>
</template>

<script>
export default {
  props: {
    targetForm: {
      type: Object,
      required: true
    }
  },
  computed:{
  formFieldSorted (){
      return this.targetForm.form_fields.sort((a, b) => a.order_field - b.order_field)
    }
  },
  data () {
    return {
    }
  }
}
</script>
