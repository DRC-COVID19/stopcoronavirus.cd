<template>
  <b-card>
    <b-form-checkbox
      v-if="!orientationChecked"
      v-model="orientationChecked"
      @change="medicalOrientationToggle"
      class="styled-checkbox"
      name="medical_orientation"
    >
      Cas probables (issus du formulaire d'orientation médicale)
    </b-form-checkbox>

    <b-row v-if="orientationChecked">
      <b-col cols="12" md="12">
        <v-select
          name="orientation_result"
          v-model="orientationSelected"
          :disable="orientationChecked"
          :options="OrientationLIst"
          label="name"
          :reduce="(item) => item.id"
          @input="orientationChange"
        />
      </b-col>
    </b-row>
  </b-card>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      OrientationLIst: [
        {
          id: 'ALL',
          name: 'Tout',
        },
        {
          id: 'FIN',
          name: 'Probable',
        },
        {
          id: 'FIN8',
          name: 'Peu probable',
        },
        {
          id: 'FIN5',
          name: 'Très probable',
        },
      ],
      orientationChecked: false,
      orientationSelected: 'ALL',
    };
  },
  methods: {
    medicalOrientationToggle(checked) {
      if (checked) {
        this.orientationSelected = 'ALL';
      }
      this.$emit('medicalOrientationChecked', checked);
    },
    orientationChange(item) {
      this.$emit('medicalOrientationChanged', item);
    },
  },
};
</script>

<style></style>
