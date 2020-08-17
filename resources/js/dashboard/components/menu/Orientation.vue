<template>
  <b-card>
    <b-form-checkbox
      v-model="orientationChecked"
      @change="medicalOrientationToggle"
      class="styled-checkbox"
      name="medical_orientation"
    >
      Cas probables (issus du formulaire d'orientation médicale)
      <b-badge v-if="orientationCount">{{orientationCount}}</b-badge>
    </b-form-checkbox>
    <b-collapse id="orientation_result_collapse">
      <hr />
      <v-select
        name="orientation_result"
        v-model="orientationSelected"
        :disable="orientationChecked"
        :options="OrientationLIst"
        label="name"
        :reduce="item=>item.id"
        @input="orientationChange"
      />
      <h4>Legende</h4>
      <div class="legende">
        <div>
          <span class="fin-8 legende-color"></span>
          <span>Peu probale</span>
          <b-badge v-if="fin8Count">{{fin8Count}}</b-badge>
        </div>
        <div>
          <span class="fin legende-color"></span>
          <span>Probable</span>
          <b-badge v-if="finCount">{{finCount}}</b-badge>
        </div>
        <div>
          <span class="fin-5 legende-color"></span>
          <span>Très probable</span>
          <b-badge v-if="fin5Count">{{fin5Count}}</b-badge>
        </div>
        <div class="d-block text-right">
          <a href="#" target="_blank">Voir formulaire</a>
        </div>
      </div>
    </b-collapse>
  </b-card>
</template>

<script>
export default {
  props: {
    orientationCount: {
      type: Number,
      default: null
    },
    finCount: {
      type: Number,
      default: null
    },
    fin8Count: {
      type: Number,
      default: null
    },
    fin5Count: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      OrientationLIst: [
        {
          id: "ALL",
          name: "Tout"
        },
        {
          id: "FIN",
          name: "Probable"
        },
        {
          id: "FIN8",
          name: "Peu probable"
        },
        {
          id: "FIN5",
          name: "Très probable"
        }
      ],
      orientationChecked: false,
      orientationSelected: "ALL"
    };
  },
  methods: {
    medicalOrientationToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "orientation_result_collapse");
      if (checked) {
        this.orientationSelected = "ALL";
      }
      this.$emit("medicalOrientationChecked", checked);
    },
    orientationChange(item) {
      this.$emit("medicalOrientationChanged", item);
    }
  }
};
</script>

<style>
</style>