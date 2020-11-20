<template>
  <b-container class="p-0 flux-chart">
    <b-row class="mb-2">
      <b-col cols="12">
        <h3 class="d-flex align-items-center mb-0">
          <span class="ml-2 mr-2">{{ targetZone ? targetZone[0] : null }}</span>
          <toggle-button :labels="mobilityTypes" v-model="selectedMobilityType">
          </toggle-button>
        </h3>
      </b-col>
    </b-row>
    <b-row  v-if="selectedMobilityType == 1" no-gutters>
      <b-col cols="12" md="4" class="pr-1 pl-0">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 1 }"
            @click="selectFluxType(1)"
          >
            <h5 class="percent-title">
              Number of subscribers moving IN expressed
            </h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
      <b-col cols="12" md="4" class="pr-1 pl-1">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 2 }"
            @click="selectFluxType(2)"
          >
            <h5 class="percent-title">
              Number of subscribers moving OUT expressed
            </h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
      <b-col cols="12" md="4" class="pr-0 pl-1">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 3 }"
            @click="selectFluxType(3)"
          >
            <h5 class="percent-title">Number of subscribers moving IN + OUT</h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
    </b-row>
    <b-row v-if="selectedMobilityType == 2" no-gutters>
      <b-col cols="12" md="4" class="pr-1 pl-0">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 1 }"
            @click="selectFluxType(1)"
          >
            <h5 class="percent-title">
              Number of subscribers moving IN expressed
            </h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
      <b-col cols="12" md="4" class="pr-1 pl-1">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 2 }"
            @click="selectFluxType(2)"
          >
            <h5 class="percent-title">
              Number of subscribers moving OUT expressed
            </h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
      <b-col cols="12" md="4" class="pr-0 pl-1">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 3 }"
            @click="selectFluxType(3)"
          >
            <h5 class="percent-title">Number of subscribers moving IN + OUT</h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
    </b-row>
    <b-row v-if="selectedMobilityType == 3" no-gutters>
      <b-col cols="12" md="4" class="pr-1 pl-0">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 1 }"
            @click="selectFluxType(1)"
          >
            <h5 class="percent-title">
              Number of subscribers moving IN expressed
            </h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
      <b-col cols="12" md="4" class="pr-1 pl-1">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 2 }"
            @click="selectFluxType(2)"
          >
            <h5 class="percent-title">
              Number of subscribers moving OUT expressed
            </h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
      <b-col cols="12" md="4" class="pr-0 pl-1">
        <b-skeleton-wrapper :loading="isLoading">
          <template #loading>
            <b-card class="mb-3 flux-mobility">
              <b-skeleton width="90%" height="20"></b-skeleton>
              <b-skeleton width="30%" height="60"></b-skeleton>
              <b-skeleton width="100%" height="50"></b-skeleton>
            </b-card>
          </template>

          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: afriFluxType == 3 }"
            @click="selectFluxType(3)"
          >
            <h5 class="percent-title">Number of subscribers moving IN + OUT</h5>

            <div class="percent flux-in-color">{{ 12 }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ 23 }} personnes de
              <span v-if="23 > 0">plus</span>
              <span v-else>moins</span>
              sont entrées dans la zone
              <br />
              <span style="opacity: 0">-</span>
            </p>
          </b-card>
        </b-skeleton-wrapper>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapMutations, mapState } from "vuex";
import ToggleButton from "../ToggleButton.vue";
export default {
  components: { ToggleButton },
  props: {
    isLoading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      // targetZone: null,
      mobilityTypes: [
        {
          lbl: "Inter zone",
          val: 1,
        },
        {
          lbl: "Hors zone",
          val: 2,
        },
        {
          lbl: "Général",
          val: 3,
        },
      ],
      selectedMobilityType: 1,
    };
  },
  computed: {
    ...mapState({
      afriFluxType: (state) => state.flux.afriFluxType,
      targetZone: (state) => state.flux.fluxGeoOptions,
    }),
  },
  methods: {
    ...mapMutations(["setAfriFluxType"]),
    selectFluxType(value) {
      this.setAfriFluxType(value);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
@import "@~/sass/_mixins";
</style>
