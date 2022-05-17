<template>
  <b-row align-v="start" align-h="center">
    <b-col cols="12" lg="auto" class="d-flex align-items-center justify-content-center mb-3">
      <p class="mb-0">Par page: </p>
      <div>
        <b-form-select
          v-model="perPageValue"
          :options="perPages"
          :value="perPage"
          :searchable="false"
          class="ml-3"
          @change="onPerPageChange"
        />
      </div>
      <p  class="mb-0 ml-5 mr-lg-5"> {{ ((page - 1) * perPage) + 1 }} - {{ perPage }} sur  {{ totalRows }}</p>
    </b-col>
    <b-col v-if="perPageValue !== totalRows" cols="12" lg="auto" class="d-flex justify-content-center mb-3">
      <b-pagination
        v-model="currentPage"
        :total-rows="totalRows"
        :per-page="perPage"
        class="my-0 mb-3 justify-content-end"
        @change="onPageChange"
      />
    </b-col>
  </b-row>
</template>

<script>
export default {
  props: {
    totalRows: {
      type: Number,
      default: 0
    },
    perPage: {
      type: Number,
      default: 15
    },
    page: {
      type: Number,
      default: 1
    }
  },
  data() {
    return {
      currentPage: this.page,
      perPageValue: this.perPage
    }
  },
  computed: {
    perPages() {
      return [
        { value: 5, text: 5 },
        { value: 15, text: 15 },
        { value: 30, text: 30 },
        { value: 60, text: 60 },
        { value: 100, text: 100 },
        { value: this.totalRows, text: 'Tous' }
      ]
    }
  },
  watch: {
    page(value) {
      this.currentPage = value
    }
  },
  methods: {
    onPageChange(value) {
      this.$emit('pageChanged', value)
    },
    onPerPageChange(value) {
      this.$emit('perPageChanged', value)
    }
  }
}
</script>
