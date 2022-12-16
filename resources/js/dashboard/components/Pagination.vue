<template>
  <b-row align-v="start" align-h="center">
    <b-col
      cols="12"
      lg="auto"
      class="d-flex align-items-center justify-content-center mb-3"
    >
      <p class="mb-0">Par page:</p>
      <div class="p-relative perpage__select">
        <v-select
          v-model="perPageValue"
          :options="perPages"
          :value="perPage"
          :searchable="false"
          :reduce="(page) => page.value"
          :clearable="false"
          :calculate-position="calculatePositionOfVueSelect"
          append-to-body
          class="ml-3"
          @input="onPerPageChange"
        />
      </div>
      <p class="mb-0 ml-5 mr-lg-5">
        {{ (page - 1) * perPage + 1 }} - {{ limitIndexCurrentStep }} sur
        {{ totalRows }}
      </p>
    </b-col>
    <b-col
      v-if="perPageValue !== totalRows"
      cols="12"
      lg="auto"
      class="d-flex justify-content-center mb-3"
    >
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
      default: 0,
    },
    perPage: {
      type: Number,
      default: 15,
    },
    page: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      currentPage: this.page,
      perPageValue: this.perPage,
    };
  },
  computed: {
    perPages() {
      return [
        { value: 5, label: 5 },
        { value: 15, label: 15 },
        { value: 30, label: 30 },
        { value: 60, label: 60 },
        { value: 100, label: 100 },
        { value: this.totalRows, label: 'Tous' },
      ];
    },
    limitIndexCurrentStep() {
      const lastIndex = this.page * this.perPage;
      return lastIndex > this.totalRows ? this.totalRows : lastIndex;
    },
  },
  watch: {
    page(value) {
      this.currentPage = value;
    },
  },
  methods: {
    onPageChange(value) {
      this.$emit('pageChanged', value);
    },
    onPerPageChange(value) {
      this.$emit('perPageChanged', value);
    },
    calculatePositionOfVueSelect(
      dropdownList,
      component,
      { width, left, top }
    ) {
      dropdownList.style.width = width;
      dropdownList.style.top =
        parseFloat(top) -
        dropdownList.getBoundingClientRect().height -
        component.$refs.toggle.getBoundingClientRect().height;
      dropdownList.style.left = left;
    },
  },
};
</script>
