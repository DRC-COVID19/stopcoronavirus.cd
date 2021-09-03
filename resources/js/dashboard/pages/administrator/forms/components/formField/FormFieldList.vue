<template>
  <div>
    <b-card>
    <b-card-header v-b-toggle.collapse-list>
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
          Liste des champs
        </span>
        <i class="fas fa-chevron-down" aria-hidden="true"></i>
      </div>
    </b-card-header>
    <b-collapse id="collapse-list" class="mt-2" visible>
      <b-card-body>
        <b-table :fields="fields" :items="items" show-empty />
      </b-card-body>
    </b-collapse>
  </b-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fields: ['Intitulé', 'Par défaut', 'O'],
      items: []
    }
  }
}
</script>
