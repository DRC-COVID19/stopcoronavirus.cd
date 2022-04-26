
<template>
  <b-card class="border-0 pt-0">
    <ValidationObserver
      v-slot="{ invalid }"
      ref="form"
      tag="form"
      novalidate
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <label id="input-group-1" class="text-dash-color" for="input-1">
        Nom du CTCO <span class="text-danger">*</span></label
      >
      <FormFieldInput
        v-model="form.name"
        type="text"
        :placeholder="`Entrer le nom du CTCO`"
        id="input-1"
        rules="required"
        name="Nom ctco"
        mode="aggressive"
        :state="state.name"
      />
      <b-form-group class="mt-3">
          <label for="" class="text-dash-color mb-2" >Ajouter la <strong>latitude</strong> et <strong>longitude</strong> : </label>
          <div id="mapContainer" class="map__container"></div>
      </b-form-group>
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.name ? errors.name[0] : null }}</span
        ></b-form-text
      >
      <label id="input-group-2" class="text-dash-color" for="input-2">
        Latitude <span class="text-danger">*</span></label
      >
      <FormFieldInput
        v-model="form.latitude"
        type="number"
        :placeholder="`Entrer la Latitude`"
        id="input-2"
        rules="required"
        name="Latitude"
        mode="aggressive"
        :state="state.latitude"
        disabled
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.latitude ? errors.latitude[0] : null }}</span
        ></b-form-text
      >
      <label id="input-group-3" class="text-dash-color" for="input-3">
        Longitude <span class="text-danger">*</span></label>
      <FormFieldInput
        v-model="form.longitude"
        type="number"
        :placeholder="`Entrer la longitude`"
        id="input-3"
        rules="required"
        name="Longitude"
        mode="aggressive"
        :state="state.longitude"
        disabled
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.longitude ? errors.longitude[0] : null }}</span
        ></b-form-text
      >
      <FomFieldSelect
        v-model="form.township_id"
        :options="townships"
        label="name"
        :reduce="(item) => item.id"
        id="form.township_id"
        labelText="Communes"
        name="Communes"
        mode="aggressive"
        :isObligated="true"
        rules="required"
      />
      <FomFieldSelect
        v-model="form.agent"
        :options="updating ? usersUpdating : users"
        label="name"
        :reduce="(item) => item.id"
        id="form.agent_id"
        labelText="Agent Attitré"
        name="agent attitré"
        mode="aggressive"
      />
      <b-row class="px-3 pt-4 d-flex justify-content-start">
        <b-button
          type="submit"
          variant="primary"
          :disabled="invalid ? true : false"
        >
          <span v-if="isLoading"
            ><b-spinner class="align-middle"></b-spinner>
            <span>en cours ...</span>
          </span>
          <div v-else>
            {{ btnTitle }}
          </div>
        </b-button>
        <b-button
          type="reset"
          variant="outline-danger"
          class="ml-4"
          @click="resetForm()"
        >
          {{ updating ? "Annuler" : "Réinitialiser" }}</b-button
        >
      </b-row>
    </ValidationObserver>
  </b-card>
</template>
<script>
import { ValidationObserver } from 'vee-validate'
import FormFieldInput from '../../../../components/forms/FormFieldInput'
import FomFieldSelect from '../../../../components/forms/FomFieldSelect.vue'
import {
  MAPBOX_TOKEN,
  MAPBOX_DEFAULT_STYLE,
  PALETTE,
  HOTSPOT_TYPE
} from '../../../../config/env'
import Mapbox from 'mapbox-gl'
import U from 'mapbox-gl-utils'
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder'
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css'

export default {
  components: {
    FormFieldInput,
    ValidationObserver,
    FomFieldSelect
  },
  props: {
    hospitalAdded: {
      type: Boolean,
      required: false,
      default: false
    },
    hospitalUpdated: {
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
    townships: {
      type: Array,
      default: () => {
        return []
      }
    },
    users: {
      type: Array,
      default: () => {
        return []
      }
    },
    errors: {
      type: Object,
      default: () => ({})
    },
    affected: {
      type: Boolean,
      default: null,
      required: false
    }
  },
  data () {
    return {
      title: 'Nouveau CTCO',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-hospital-alt',
      disablePassword: false,
      state: {
        name: null,
        longitude: null,
        latitude: null
      },
      updating: false,
      isLoading: false,
      form: {
        name: '',
        agent: null,
        deAssignedAgent: null,
        affected: this.affected,
        township_id: null,
        longitude: null,
        latitude: null
      },
      usersUpdating: [],
      show: true,
      showWarning: false,
      toBeCanceled: true,
      MAPBOX_TOKEN: 'pk.eyJ1IjoicmtvdGEiLCJhIjoiY2wyNXZoZW84MDRnajNicW55YXY0dTlmOCJ9.-0-CdvcPCqodYnXn0quH0Q',
      MAPBOX_STYLE: 'mapbox://styles/rkota/cl26q1z2g001015my3fnuy8p7',
      // MAPBOX_TOKEN,
      // MAPBOX_STYLE: MAPBOX_DEFAULT_STYLE,
      popupCoordinates: [15.31389, -4.33167],
      countryLayer: {
        paint: {
          'line-color': '#627BC1',
          'line-width': 1
        },
        type: 'line'
      },
      kinLayer: {
        paint: {
          'line-color': '#627BC1',
          'line-width': 1
        },
        type: 'line',
        'source-layer': 'carte-administrative-de-la-vi-csh5cj'
      },
      drcSourceId: 'states',
      kinSourceId: 'statesKin',
      defaultCenterCoordinates: [23.485632, -3.983283],
      defaultKinshasaCoordinates: [15.31389, -4.33167],
      geoJson: {
        type: 'FeatureCollection',
        features: [
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-77.032, 38.913]
            },
            properties: {
              title: 'Mapbox',
              description: 'Washington, D.C.'
            }
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [-122.414, 37.776]
            },
            properties: {
              title: 'Mapbox',
              description: 'San Francisco, California'
            }
          }
        ]
      }
    }
  },
  mounted () {
    this.resetForm()
    this.renderMapBox()
  },
  watch: {
    hospitalAdded () {
      this.resetForm()
    },
    hospitalUpdated () {
      this.resetForm()
    },
    formToPopulate () {
      this.resetForm()
      this.populateForm()
    },
    errors () {
      this.errorForm()
    }
  },
  methods: {
    onSubmit () {
      this.isLoading = true
      if (this.btnTitle === 'Enregistrer') {
        this.$emit('onCreate', this.form)
        this.$refs.form.reset()
      } else {
        if (this.form.agent) {
          this.form.affected = true
        } else {
          this.form.affected = false
        }
        this.form.deAssignedAgent =
          (this.formToPopulate.agent && this.formToPopulate.agent.id) ?? 0
        this.$emit('onUpdate', this.form)
      }
      this.isLoading = false
      this.$refs.form.reset()
    },
    onReset () {
      this.$refs.form.reset()
      this.toToCanceled = true
      this.form = {}
      this.title = 'Nouveau CTCO'
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
      this.renderMapBox()
    },
    resetForm () {
      this.updating = false
      this.isLoading = false
      this.toToCanceled = true
      this.form = {}
      this.btnTitle = 'Enregistrer'
      this.title = 'Nouveau CTCO'
      this.renderMapBox()
    },
    populateForm () {
      this.updating = false
      if (Object.keys(this.formToPopulate).length !== 0) {
        this.updating = true
        this.title = 'Modification du CTCO '
        this.btnTitle = 'Modifier'
        this.form.id = this.formToPopulate.id
        this.form.name = this.formToPopulate.name
        this.form.longitude = this.formToPopulate.longitude
        this.form.latitude = this.formToPopulate.latitude
        this.form.agent = this.formToPopulate.agent
        this.form.township_id =
          this.formToPopulate.township && this.formToPopulate.township.id
            ? this.formToPopulate.township.id
            : 0
        this.usersUpdating = [...this.users]
        this.usersUpdating.push({ ...this.form.agent })
      }
    },
    errorForm () {
      if (this.errors.name) {
        this.state.name = false
      }
      if (this.errors.longitude) {
        this.state.longitude = false
      }
      if (this.errors.latitude) {
        this.state.latitude = false
      }
      if (!this.errors.name && this.form.name) {
        this.state.name = null
      }
      if (!this.errors.longitude && this.form.longitude) {
        this.state.longitude = null
      }
      if (!this.errors.latitude && this.form.latitude) {
        this.state.latitude = null
      }
    },
    handleSelect (value) {
      if (value.length > 1) {
        value.shift()
      }
    },
    async renderMapBox () {
      try {
        // initialisation
        Mapbox.accessToken = this.MAPBOX_TOKEN
        const marker = new Mapbox.Marker()
        const markerHeight = 50
        const markerRadius = 10
        const linearOffset = 25
        const popupOffsets = {
          top: [0, 0],
          'top-left': [0, 0],
          'top-right': [0, 0],
          bottom: [0, -markerHeight],
          'bottom-left': [linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
          'bottom-right': [-linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
          left: [markerRadius, (markerHeight - markerRadius) * -1],
          right: [-markerRadius, (markerHeight - markerRadius) * -1]
        }
        const popup = new Mapbox.Popup({ offset: popupOffsets, className: 'my-class' })

        const map = new Mapbox.Map({
          container: 'mapContainer',
          center: this.defaultCenterCoordinates,
          zoom: 3.5,
          pitch: 10,
          style: this.MAPBOX_STYLE,
          testMode: true
        })

        // add methods of mapbox et load mapbox
        marker.setLngLat(this.defaultCenterCoordinates)
        marker.addTo(map)
        const geocoder = new MapboxGeocoder({
          // Initialize the geocoder
          accessToken: Mapbox.accessToken, // Set the access token
          mapboxgl: Mapbox, // Set the mapbox-gl instance
          marker: false // Do not use the default marker style
        })

        // Add the geocoder to the map
        map.addControl(geocoder)

        map.on('load', () => {
          map.on('click', (e) => {
            e.preventDefault()
            this.form = {
              ...this.form,
              latitude: e.lngLat.lat.toString(),
              longitude: e.lngLat.lng.toString()
            }

            popup.setLngLat(e.lngLat)
              .setHTML(`<p>Latitude : ${e.lngLat.lat.toString()} <br>Longitude : ${e.lngLat.lng.toString()}</p>`)
              .setMaxWidth('250px')
              .addTo(map)
          })
        })
      } catch (error) {
        throw new Error(error)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
  .bg-custom {
    background-color: rgb(165, 167, 180);
  }
  .form-select {
    outline: none !important;
  }
}
.marker {
  background-image: url('@~/public/img/mapbox-icon.png');
  background-size: cover;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  cursor: pointer;
}
.btn-submit[disabled="disabled"] {
  opacity: 0.6;
  cursor: not-allowed !important;
}
.map__container {
  width: 22rem;
  height: 300px;
}
</style>
