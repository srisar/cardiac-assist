<template>

  <div>

    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Total Calcium Score</label>
          <input type="number" class="form-control" v-model.number="visitCoronaryCT.total_calcium_score">
        </div>

        <div class="form-group">
          <label>Origin</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.origin"></textarea>
        </div>

        <div class="form-group">
          <label>Dominance</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.dominance"></textarea>
        </div>

        <div class="form-group">
          <label>Left Main</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.left_main"></textarea>
        </div>

        <div class="form-group">
          <label>LAD</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.lad"></textarea>
        </div>

        <div class="form-group">
          <label>LCX</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.lcx"></textarea>
        </div>

        <div class="form-group">
          <label>Cardiac Valves</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.cardiac_valves"></textarea>
        </div>

        <div class="form-group">
          <label>Pericardium</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.pericardium"></textarea>
        </div>

        <div class="form-group">
          <label>Extra Cardiac Findings</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.extra_cardiac_findings"></textarea>
        </div>

        <div class="form-group">
          <label>Impression</label>
          <textarea rows="5" class="form-control" v-model="visitCoronaryCT.impression"></textarea>
        </div>

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
      exist: false,

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
  },

  computed: {
    visit: function () { return this.$store.getters.getVisit }
  },

  mounted() {

    this._checkIfExist()
        .then(response => {

          console.log(response)

          if ( !this.exist ) {
            this._addNew()
                .then(response => {
                  this.visitCoronaryCT = response.data
                })
          } else {
            this.visitCoronaryCT = response
          }
        })

  },

  methods: {

    /*
    * check if visit-coronary-ct exist
    * */
    _checkIfExist: function () {
      const params = { visit_id: this.visit.id }

      return new Promise((resolve, reject) => {
        $.get(`${getSiteURL()}/api/get/visit-coronary-ct.php`, params)
            .done(response => {
              this.exist = !_.isEmpty(response.data)
              resolve(response.data)
            })
            .fail(error => {
              reject(error)
            })
      })
    }, /* check if coronary ct exist in db*/

    _addNew: function () {

      const params = { visit_id: this.visit.id }

      return new Promise((resolve, reject) => {
        $.post(`${getSiteURL()}/api/save/visit-coronary-ct.php`, params)
            .done(response => {
              this.exist = true;
              resolve(response.data)
            })
            .fail(error => {
              reject(error)
            })
      })
    }, /* add new visit-coronary-ct into db */

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

      $.post(`${getSiteURL()}/api/update/visit-coronary-ct.php`, params)
          .done(r => {
            alert("Coronary CT details updated");
          })
          .fail(e => {
            console.log(e);
            alert("Failed to update coronary CT details");
          });

    },

  },

}
</script>

<style scoped>

</style>
