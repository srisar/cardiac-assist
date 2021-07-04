<template>

  <div>

    <div class="row">

      <div class="col">

        <div class="card shadow shadow-sm">
          <div class="card-header">Angiography</div><!-- card-header -->

          <div class="card-body">

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="txt-instruments">Instruments</label>
                  <textarea class="form-control" id="txt-instruments" rows="3" v-model.trim="visitAngio.instruments"></textarea>
                </div>

                <!-- dominance -->
                <div>

                  <div class="mb-1">Dominance</div>

                  <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" id="dominance-right" v-model="visitAngio.dominance_right">
                    <label for="dominance-right" class="form-check-label">Right</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" id="dominance-left" v-model="visitAngio.dominance_left">
                    <label for="dominance-left" class="form-check-label">Left</label>
                  </div>

                </div>
                <!-- dominance -->

                <!-- details -->
                <div class="mt-3">

                  <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                      <th>Segment</th>
                      <th>Stenosis</th>
                      <th>Lesion Type</th>
                      <th>TIMI Flow (Abnormal)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                      <td class="align-middle">Prox RCA</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.prox_rca_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.prox_rca_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.prox_rca_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">Mid RCA</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.mid_rca_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.mid_rca_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.mid_rca_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">RPL1 (Small)</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.rpl1_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.rpl1_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.rpl1_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">RPL2 (small)</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.rpl2_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.rpl2_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.rpl2_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">Prox LAD</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.prox_lad_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.prox_lad_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.prox_lad_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">Mid LAD</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.mid_lad_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.mid_lad_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.mid_lad_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">Dist LAD</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.dist_lad_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.dist_lad_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.dist_lad_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">Left Main</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.left_main_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.left_main_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.left_main_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">Left Circumflex</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.left_circumflex_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.left_circumflex_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.left_circumflex_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">OM1</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.om1_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.om1_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.om1_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">OM2</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.om2_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.om2_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.om2_timi_flow">
                      </td>
                    </tr>

                    <tr>
                      <td class="align-middle">PDA</td>
                      <td>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model.number="visitAngio.pda_stenosis">
                          <div class="input-group-append">
                            <span class="input-group-text">%</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control" list="lesion-type-list" v-model="visitAngio.pda_lesion_type">
                      </td>
                      <td>
                        <input type="text" class="form-control" v-model="visitAngio.pda_timi_flow">
                      </td>
                    </tr>


                    </tbody>
                  </table>

                  <datalist id="lesion-type-list">
                    <option>Discrete</option>
                    <option>Diffuse</option>
                    <option>Tubular</option>
                  </datalist>


                  <div class="form-group">
                    <label for="txt-notes">Notes</label>
                    <textarea rows="5" id="txt-notes" class="form-control" v-model.trim="visitAngio.notes"></textarea>
                  </div>

                </div>
                <!-- details -->

                <div class="text-center">
                  <button class="btn btn-success" @click="onUpdate()" :disabled="!loaded">
                    <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
                  </button>
                  <AlertArea :feedback="feedback"/>
                </div>


              </div>
            </div>

          </div><!-- card-body -->

        </div><!-- card -->
      </div><!-- col -->
    </div><!-- row -->

  </div><!--  -->

</template>

<script>

import {TYPE_SUCCESS} from "../../../_common/message_types";
import AlertArea from "../../../_common/components/AlertArea";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "VisitAngiographyView",
  components: { AlertArea },

  data() {
    return {
      visitAngio: {
        instruments: "",
        dominance_right: false,
        dominance_left: false,
        notes: "",

        prox_rca_stenosis: 0,
        prox_rca_lesion_type: "",
        prox_rca_timi_flow: "",

        prox_lad_stenosis: 0,
        prox_lad_lesion_type: "",
        prox_lad_timi_flow: "",

        mid_rca_stenosis: 0,
        mid_rca_lesion_type: "",
        mid_rca_timi_flow: "",

        rpl1_stenosis: 0,
        rpl1_lesion_type: "",
        rpl1_timi_flow: "",

        rpl2_stenosis: 0,
        rpl2_lesion_type: "",
        rpl2_timi_flow: "",

        mid_lad_stenosis: 0,
        mid_lad_lesion_type: "",
        mid_lad_timi_flow: "",

        dist_lad_stenosis: 0,
        dist_lad_lesion_type: "",
        dist_lad_timi_flow: "",

        left_main_stenosis: 0,
        left_main_lesion_type: "",
        left_main_timi_flow: "",

        left_circumflex_stenosis: 0,
        left_circumflex_lesion_type: "",
        left_circumflex_timi_flow: "",

        om1_stenosis: 0,
        om1_lesion_type: "",
        om1_timi_flow: "",

        om2_stenosis: 0,
        om2_lesion_type: "",
        om2_timi_flow: "",

        pda_stenosis: 0,
        pda_lesion_type: "",
        pda_timi_flow: "",

      },

      loaded: false,

      feedback: {
        message: "",
        type: TYPE_SUCCESS
      }

    };
  },

  computed: {
    visitId() {
      return this.$store.getters.getVisitId;
    }
  },

  async mounted() {

    try {

      await this.$store.dispatch( "visitAngio_fetch", this.visitId );
      this.visitAngio = this.$store.getters.getVisitAngio;

      /* set boolean value for dominance based on whats stored */
      this.visitAngio.dominance_right = this.visitAngio.dominance_right === '1';
      this.visitAngio.dominance_left = this.visitAngio.dominance_left === '1';

      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch angiography details" );
    }

  },

  methods: {

    async onUpdate() {

      try {

        await this.$store.dispatch( "visitAngio_update", this.visitAngio );

        successMessageBox( "Angiography details updated" );
      } catch ( e ) {
        errorMessageBox( "Failed to update angiography details" );
      }

    },

  },

}
</script>

<style scoped>

</style>
