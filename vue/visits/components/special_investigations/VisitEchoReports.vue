<template>

  <div>

    <div id="add-echo-values">
      <div class="alert alert-secondary">

        <div class="form-group">
          <label>Value</label>
          <input type="text" class="form-control" v-model="valueToAdd.value">
        </div>

        <div class="form-group">
          <label>Type</label>
          <select class="form-control" v-model="valueToAdd.type">
            <option v-for="(item, key) in echoValueTypes" :value="key">{{ item }}</option>
          </select>
        </div>

      </div>
    </div>

  </div><!-- template -->

</template>

<script>


export default {
  name: "VisitEchoReports",
  components: {},
  data() {
    return {

      echoValueTypes: {
        'AORTA': 'Aorta',
        'AORTIC_VALVE': 'Aortic Valve',
        'DOPPLER': 'Doppler',
        'LEFT_ATRIUM': 'Left Atrium',
        'MITRAL_VALVE': 'Mitral Valve',
        'PERICARDIUM': 'Pericardium',
        'PULMONIC_VALVE': 'Pulmonic Valve',
        'RIGHT_ATRIUM': 'Right Atrium',
        'RIGHT_VENTRICLE': 'Right Ventricle',
        'TRICUSPID': 'Tricuspid',
      },

      valueToAdd: {
        value: "",
        type: "AORTA"
      }

    }
  },

  computed: {
    //
  },

  mounted() {
    //
  },

  methods: {
    //
  },
}
</script>

<style>

.report-section {

}

.report-section__title {
  font-size: 1em;
  font-weight: bold;
}

</style>
