<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header"> Coronary CT</div>

      <div class="card-body">

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
              <button class="btn btn-success" @click="onUpdate">
                <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
              </button>
            </div>

          </div>
        </div><!-- form-row -->

        <div class="my-2 d-flex justify-content-center" v-if="updated">
          <span class="alert alert-success mb-0">✅ Successfully updated.</span>
        </div>


      </div>
    </div><!-- card -->

  </div><!-- template -->

</template>

<script>

import {errorMessageBox} from '../../../_common/bootbox_dialogs';

export default {
  name: 'VisitCoronaryCTView',

  data() {
    return {
      visitCoronaryCT: {
        id: null,
        visit_id: null,
        total_calcium_score: null,
        origin: null,
        dominance: null,
        left_main: null,
        lad: null,
        lcx: null,
        cardiac_valves: null,
        pericardium: null,
        extra_cardiac_findings: null,
        impression: null,
      },

      updated: false,

    };
  },

  computed: {
    visitId: function () {
      return this.$store.getters.getVisitId;
    },
  },

  async mounted() {
    try {

      const params = {
        visit_id: this.visitId,
      };

      const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-coronary-ct.php`, params );
      this.visitCoronaryCT = response.data;

    } catch ( e ) {
      errorMessageBox( 'Failed to fetch coronary ct details' );
    }
  },

  methods: {

    async onUpdate() {

      try {

        const params = {
          id: this.visitCoronaryCT.id,
          total_calcium_score: this.visitCoronaryCT.total_calcium_score,
          origin: this.visitCoronaryCT.origin,
          dominance: this.visitCoronaryCT.dominance,
          left_main: this.visitCoronaryCT.left_main,
          lad: this.visitCoronaryCT.lad,
          lcx: this.visitCoronaryCT.lcx,
          cardiac_valves: this.visitCoronaryCT.cardiac_valves,
          pericardium: this.visitCoronaryCT.pericardium,
          extra_cardiac_findings: this.visitCoronaryCT.extra_cardiac_findings,
          impression: this.visitCoronaryCT.impression,
        };

        await $.post( `${ getSiteURL() }/api/update/visit/visit-coronary-ct.php`, params );

        this.setAsUpdated();

      } catch ( e ) {
        errorMessageBox( 'Failed to update coronary CT details' );
      }

    },

    setAsUpdated() {
      this.updated = true;

      setTimeout( () => {
        this.updated = false;
      }, 3500 );
    },

  },

};
</script>

<style scoped>

</style>
