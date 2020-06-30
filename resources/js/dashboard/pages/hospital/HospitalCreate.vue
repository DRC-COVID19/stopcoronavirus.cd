<template>
  <b-container>
    <b-row>
      <b-col>
        <form-wizard shape="tab" color="#2e5bff">
          <tab-content title="Informationes  générales">
            <b-row>
              <b-col>
                  <b-form-group>
                      <label for="">Cas confirmé</label>
                      <b-form-input type="text"/>
                  </b-form-group>
              </b-col>
            </b-row>
          </tab-content>
          <tab-content title="Additional Info">My second tab content</tab-content>
          <tab-content title="Last step">Yuhuuu! This seems pretty damn simple</tab-content>
        </form-wizard>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
export default {
  components: {
    FormWizard,
    TabContent
  }
};
</script>

<style>
</style>