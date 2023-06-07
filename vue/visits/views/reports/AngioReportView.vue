<template>

  <div class="">

    <div class="paper">

      <div class="ems-header mb-3" v-if="isEmsHeaderVisible">
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <img src="/assets/images/ems-logo.png" style="width: 100px" alt="">
          </div>

          <div>
            <div class="font-weight-bold">No.121, New Kalmunai Road</div>
            <div class="font-weight-bold">Kallady, Batticaloa</div>
            <div class="">Phone: 065 222 8812, 065 222 8800</div>
            <div>Email: ems.hospital.batticaloa@gmail.com</div>
          </div>

        </div>
      </div>

      <h3 class="text-center">Angiography Report</h3>

      <PatientBasicDetails/>
			
			<div class="d-flex justify-content-end font-weight-bold" style="gap: 10px">
				<span>Performed by:</span>
				<span>{{ visit.performed_by }}</span>
			</div>

      <div class="section" v-if="loaded">

        <div class="border mb-3 p-2" v-if="hasInstruments">
          <div class="font-weight-bold text-uppercase">Instruments</div>
          <div style="white-space: pre-line">{{ visitAngio.instruments }}</div>
        </div>

        <div class="border mb-3 p-2" v-if="hasDominanceSection">
          <div class="font-weight-bold text-uppercase">Dominance</div>
          <span class="col" v-if="visitAngio.dominance_left === '1'">Left</span>
          <span class="col" v-if="visitAngio.dominance_right === '1'">Right</span>
        </div>

        <table class="table table-bordered table-sm">
          <thead>
          <tr>
            <th class="text-uppercase">Segment</th>
            <th class="text-uppercase">Stenosis</th>
            <th class="text-uppercase">Lesion Type</th>
            <th class="text-uppercase">TIMI Flow (Abnormal)</th>
          </tr>
          </thead>
          <tbody>

          <tr>
            <td class="align-middle">Prox RCA</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.prox_rca_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.prox_rca_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.prox_rca_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">Mid RCA</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.mid_rca_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.mid_rca_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.mid_rca_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">RPL1 (Small)</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.rpl1_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.rpl1_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.rpl1_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">RPL2 (small)</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.rpl2_stenosis }}%</div>

            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.rpl2_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.rpl2_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">Prox LAD</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.prox_lad_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.prox_lad_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.prox_lad_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">Mid LAD</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.mid_lad_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.mid_lad_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.mid_lad_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">Dist LAD</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.dist_lad_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.dist_lad_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.dist_lad_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">Left Main</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.left_main_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.left_main_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.left_main_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">Left Circumflex</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.left_circumflex_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.left_circumflex_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.left_circumflex_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">OM1</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.om1_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.om1_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.om1_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">OM2</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.om2_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.om2_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.om2_timi_flow }}</div>
            </td>
          </tr>

          <tr>
            <td class="align-middle">PDA</td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.pda_stenosis }}%</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.pda_lesion_type }}</div>
            </td>
            <td>
              <div class="font-weight-bold text-right">{{ visitAngio.pda_timi_flow }}</div>
            </td>
          </tr>


          </tbody>
        </table>

        <div class="mt-3 section p-2 border" v-if="hasNotes">
          <div class="font-weight-bold text-uppercase">Notes</div>
          <div style="white-space: pre-line">{{ visitAngio.notes }}</div>
        </div>

      </div>

      <div v-else>
        <TheLoading/>
      </div>

    </div>

    <div class="d-print-none text-center">

      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="chk_ems_header" v-model="isEmsHeaderVisible">
          <label class="form-check-label" for="chk_ems_header">
            Show EMS Hospital Header
          </label>
        </div>
      </div>

      <button class="btn btn-success" @click="openPrintDialog()">
        <img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print
      </button>
      <router-link class="btn btn-secondary" to="/reports">
        <img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
      </router-link>
    </div>

  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from '../../../_common/bootbox_dialogs';
import PatientBasicDetails from './basic_report_sections/PatientBasicDetails';
import TheLoading from '../../../_common/components/TheLoading';

export default {
  name: 'AngioReportView',
  components: { TheLoading, PatientBasicDetails },
  data() {
    return {
      loaded: false,
      isEmsHeaderVisible: false,
    };
  },


  computed: {

    visitId() {
      return this.$store.getters.getVisitId;
    },
		
		visit() {
			return this.$store.getters.getVisit;
		},

    visitAngio() {
      return this.$store.getters.getVisitAngio;
    },

    hasDominanceSection() {
      return this.visitAngio.dominance_left === '1' || this.visitAngio.dominance_right === '1';
    },

    hasNotes() {
      return this.visitAngio.notes !== '';
    },

    hasInstruments() {
      return this.visitAngio.instruments !== '';
    },

  },

  async mounted() {
    try {

      await this.$store.dispatch( 'visitAngio_fetch', this.visitId );
      this.loaded = true;

    } catch ( e ) {
      errorMessageBox( 'Failed to fetch angiography details' );
    }


  },

  methods: {
    openPrintDialog() {


      window.print();

    },
  },
};
</script>

<style scoped lang="scss">


</style>
