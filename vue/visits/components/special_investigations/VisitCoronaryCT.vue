<template>

  <div>

    <div class="form-row">
      <div class="col">

        <table class="table table-bordered table-sm">
          <tr>
            <td>
              <div class="font-weight-bold">Total Calcium Score</div>
              <input type="number" class="form-control" v-model.number="visitCoronaryCT.total_calcium_score">
            </td>
            <td></td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">Origin</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.origin"></textarea>
            </td>
            <td>
              <div class="font-weight-bold">Dominance</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.dominance"></textarea>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">Left Main</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.left_main"></textarea>
            </td>
            <td>
              <div class="font-weight-bold">LAD</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.lad"></textarea>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">LCX</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.lcx"></textarea>
            </td>
            <td>
              <div class="font-weight-bold">Cardiac Valves</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.cardiac_valves"></textarea>
            </td>
          </tr>

          <tr>
            <td>
              <div class="font-weight-bold">Pericardium</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.pericardium"></textarea>
            </td>
            <td>
              <div class="font-weight-bold">Extra Cardiac Findings</div>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.extra_cardiac_findings"></textarea>
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <label class="font-weight-bold">Impression</label>
              <textarea rows="2" class="form-control" v-model="visitCoronaryCT.impression"></textarea>
            </td>
          </tr>

        </table>


        <div class="d-flex justify-content-center">
          <button class="btn btn-success" @click="onUpdate">Update</button>
        </div>

      </div>
    </div><!-- form-row -->

  </div><!-- template -->

</template>

<script>
export default {
  name: "VisitCoronaryCT",

  data() {
    return {
      visitCoronaryCT: {
        id                    : undefined,
        visit_id              : undefined,
        total_calcium_score   : undefined,
        origin                : undefined,
        dominance             : undefined,
        left_main             : undefined,
        lad                   : undefined,
        lcx                   : undefined,
        cardiac_valves        : undefined,
        pericardium           : undefined,
        extra_cardiac_findings: undefined,
        impression            : undefined,
      },
    }
  }, /* data */

  /*
  * === COMPUTED ===
  * */
  computed: {
    visit: function () { return this.$store.getters.getVisit }
  },

  /*
  * === MOUNTED ===
  * */
  mounted() {
    this._fetch()
  },

  methods: {

    /*
    * check if visit-coronary-ct exist
    * */
    _fetch: function () {
      const params = { visit_id: this.visit.id }

      $.get(`${getSiteURL()}/api/get/visit/visit-coronary-ct.php`, params)
          .done(response => {
            this.visitCoronaryCT = response.data
          })
          .fail(error => {
            console.log(error)
          })
    }, /* check if coronary ct exist in db*/


    onUpdate: function () {
      const params = {
        id                    : this.visitCoronaryCT.id,
        total_calcium_score   : this.visitCoronaryCT.total_calcium_score,
        origin                : this.visitCoronaryCT.origin,
        dominance             : this.visitCoronaryCT.dominance,
        left_main             : this.visitCoronaryCT.left_main,
        lad                   : this.visitCoronaryCT.lad,
        lcx                   : this.visitCoronaryCT.lcx,
        cardiac_valves        : this.visitCoronaryCT.cardiac_valves,
        pericardium           : this.visitCoronaryCT.pericardium,
        extra_cardiac_findings: this.visitCoronaryCT.extra_cardiac_findings,
        impression            : this.visitCoronaryCT.impression,
      }

      $.post(`${getSiteURL()}/api/update/visit/visit-coronary-ct.php`, params)
          .done(() => {
            bootbox.alert("Coronary CT details updated");
          })
          .fail(e => {
            console.log(e);
            bootbox.alert("Failed to update coronary CT details");
          });

    },

  },

}
</script>

<style scoped>

</style>
