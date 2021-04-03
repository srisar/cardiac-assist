<template>

  <div>

    <div id="add-echo-values">
      <div class="alert alert-secondary">

        <div class="row">
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label>Type</label>
              <select class="form-control" v-model="valueToAdd.type">
                <option v-for="(item, key) in echoValueTypes" :value="key">{{ item }}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Values</label>
          <select class="form-control" v-model="valueToAdd.echoValue">
            <option selected disabled :value="null">Choose a value</option>
            <option v-for="(item, key) in selectedEchoValues" :value="item">{{ item.value }}</option>
          </select>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAdd" :disabled="!validated">Add</button>
        </div>

      </div>
    </div>


    <div class="card mb-3" v-for="(items, key) in visitEchoValues">
      <div class="card-header">{{ echoValueTypes[key] }}</div>
      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th>Value</th>
            <th style="width: 100px" class="text-center">Options</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in items">
            <td>{{ item.echoValue.value }}</td>
            <td class="text-center">
              <button type="button" class="btn btn-danger btn-tiny" @click="onDelete(item)">
                <i class="bi bi-trash-fill"></i>
              </button>
            </td>
          </tr>
          </tbody>
        </table>

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
        echoValue: null,
        type: "AORTA"
      }

    }
  },

  computed: {

    allEchoValues: function () {
      return this.$store.getters.getEchoValues
    },

    visitEchoValues: function () {
      return this.$store.getters.getVisitEchoValues
    },

    selectedEchoValues: function () {
      return this.allEchoValues[this.valueToAdd.type]
    },

    visitId: function () {
      return this.$store.getters.getVisitId
    },

    validated: function () {
      return this.valueToAdd.echoValue !== null;
    }

  },

  watch: {
    selectedEchoValues(newValue, oldValue) {
      this.valueToAdd.echoValue = null
    }
  },

  mounted() {

    this.$store.dispatch('FETCH_ALL_ECHO_VALUES')
        .then()

    this.$store.dispatch('FETCH_VISIT_ECHO_VALUES', this.visitId)
        .then()

  },

  methods: {

    onAdd: function () {

      let item = {
        visit_id: this.visitId,
        echo_value_id: this.valueToAdd.echoValue.id,
        type: this.valueToAdd.type,
      }

      this.$store.dispatch('ADD_VISIT_ECHO_VALUE', item)
          .then(() => {

            this.$store.dispatch('FETCH_VISIT_ECHO_VALUES', this.visitId)
                .then()
          })
    },


    onDelete: function (item) {

      this.$store.dispatch('DELETE_VISIT_ECHO_VALUE', item.id)
          .then(() => {

            this.$store.dispatch('FETCH_VISIT_ECHO_VALUES', this.visitId)
                .then()
          })

    }


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
