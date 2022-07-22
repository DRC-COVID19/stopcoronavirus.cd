<template>
  <b-container fluid class="px-0 mx-0 containerReporting h-100">
    <b-row class="d-flex mx-0">
     <b-button
          v-b-toggle.sidebar-header-reporting
          class="btn-dash-blue btn-sidebar"
          ><i class="fas fa-chart-line"></i>
        </b-button>
      <b-col lg="12" class="mx-0 px-0">
        <HeaderReporting
          :forms="forms"
          class="w-100 h-100"
        />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import HeaderReporting from './components/HeaderReporting'

import Pivottable from './components/Pivottable'

export default {
  name: 'Reporting',
  components: {
    HeaderReporting,
    Pivottable
  },

  data () {
    return {
      linesSelected: [],
      columnsSelected: [],
      arrayAxeValue: [],
      value: { linesSelected: [] }
    }
  },
  mounted () {
    this.getForms()
  },
  computed: {
    ...mapState({
      forms: (state) => state.form.forms
    })
  },
  methods: {
    ...mapActions(['getForms']),
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.sm-display{
  display: none;
}
.containerReporting {
  background-color: #f4f6fc;
  height: 100vh;
  overflow-y: scroll;
}
.bookmark {
  background-color: #f4f6fc;
  height: 540px;
}
.container-action {
  border-radius: 7px;
}
.btn-sidebar {
  display: none;
}
.btn-title[disabled="disabled"] {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  opacity: 0.3;
}
.header-responsive {
  display: flex;
}
@media (max-width: $max-width) {
  .btn-sidebar {
    display: block;
    top: 90%;
    left: 90%;
    position: fixed;
    z-index: 100;
  }
  .header-responsive {
    display: none;
  }
  .sm-display{
    display: block;
  }
}
</style>
