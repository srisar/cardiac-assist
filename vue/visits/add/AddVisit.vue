<template>

  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-6 col-12">

          <div class="card">
            <div class="card-header">Add a visit for {{ patientName }}</div>
            <div class="card-body">

              <input type="hidden" id="field_patient_id" value="<?= $patient->id ?>">

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label v-model="visitDate">Visit date</label>
                    <DateField v-model="visitDate"></DateField>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label for="field_remarks">Remarks</label>
                <textarea id="field_remarks" rows="10" class="form-control" v-model="rawRemarks"></textarea>
              </div>

              <div class="text-right">
                <button class="btn btn-success" @click="addVisit">Add</button>
                <a href="<?= App::url('/patients/edit', ['id' => $patient->id]) ?>" class="btn btn-secondary">Cancel</a>
              </div>

            </div>
          </div><!--.card-->

        </div>
      </div>
    </div>
  </div>

</template>

<script>

import DateField from "../../_common/DateField";
import voca from 'voca';

export default {
  name: "AddVisit",
  components: {DateField},

  data: function () {
    return {
      patientName: "",
      patientId: null,
      visitDate: moment().format('YYYY-MM-DD'),
      rawRemarks: ""
    };
  },

  computed: {

    visitRemarks() {
      return voca.capitalize(this.rawRemarks);
    }

  },

  mounted: function () {

    this.initPhpValues();

  },

  methods: {

    /**
     * Init values from PHP variables
     */
    initPhpValues: function () {
      this.patientName = $("#patient_name").val();
      this.patientId = parseInt($("#patient_id").val());
    },

    /**
     * Add a new visit
     */
    addVisit: function () {

      axios.post(`${getSiteUrl()}/api/visit/add`, {
        patient_id: this.patientId,
        visit_date: this.visitDate,
        remarks: this.visitRemarks
      }).then(response => {

        console.log(response.data);

        const visitId = response.data.visit.id;

        redirect(`${getSiteUrl()}/visits/edit?id=${visitId}`);

      }).catch(error => {
        showErrorToast('Error adding new visit.');
      });

    },

  }
}
</script>

<style scoped>

</style>