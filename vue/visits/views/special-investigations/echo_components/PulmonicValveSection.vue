<template>

  <!-- section: Pulmonic Valve -->
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
      <div>Pulmonic Valve</div>
      <div>
        <button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
          <img :src="showHideIcon" class="icon-16" alt="">
        </button>
      </div>
    </div>
    <div class="card-body" v-if="visible">

      <div class="mb-3">
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="chk_has_ps" v-model="visitEcho.has_ps">
          <label class="form-check-label" for="chk_has_ps">PS</label>
        </div>
      </div>

      <div class="form-row" v-if="visitEcho.has_ps">
        <div class="col-3 mb-2">
          PS (mmHg)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pv_pg">
        </div>
        <div class="col-3 mb-2">
          PV Annulus (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pv_annulus">
        </div>
      </div>


      <!-- add remarks -->
      <div class="alert alert-warning p-1 m-0">

        <div class="font-weight-bold mb-2">Remarks</div>


        <AutoCompleteTextBox
            search-dispatch-name="echo_searchPulmonicValveRemarks"
            add-dispatch-name="echo_addPulmonicValveRemark"
            field-name="value"
            v-model="remarkToAdd"
            @input="onAdd"
        />


        <div class="mb-2">
          <button class="btn btn-tiny btn-dark" @click="onAddDefaultRemarks()">Add Defaults</button>
        </div>


        <table class="table table-bordered table-sm table-hover m-0">
          <tbody>
          <tr v-for="item in visitEchoRemarks.PULMONIC_VALVE">
            <td style="white-space: pre-line">{{ item.value }}</td>
            <td style="width: 30px">
              <button class="btn btn-tiny btn-outline-danger" @click="$emit('delete-remark',item)">
                <img src="/assets/images/actions/remove.svg" class="icon-16" alt="">
              </button>
            </td>
          </tr>
          </tbody>
        </table>

      </div>
      <!-- add remarks -->

    </div>
  </div>
  <!-- section: Pulmonic Valve -->

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import {sectionMixins} from './sections_mixins';
import _ from 'lodash';

export default {
  name: 'PulmonicValveSection',
  components: {AutoCompleteTextBox},
  mixins: [sectionMixins],
  props: [
    'visitId',
    'visitEcho',
    'visitEchoRemarks',
    'allEchoRemarks',
    'selectedRemarks',
    'isDisableAddRemarks',
  ],

  data() {
    return {
      remarkToAdd: null,
    };
  },

  computed: {

    fillableRemarks() {
      return _.filter(this.allEchoRemarks['PULMONIC_VALVE'], {'fillable': 'Y'});
    }

  },

  methods: {

    async onAdd() {
      try {

        const id = this.remarkToAdd['id'];

        const params = {
          visit_id: this.visitId,
          echo_value_id: id,
        };

        await this.$store.dispatch('echo_addVisitRemark', params);

      } catch (e) {
        errorMessageBox('Failed to insert the remark');
      }

      /* fetch all visit echo remarks again */
      try {
        await this.$store.dispatch('echo_fetchAllVisitRemarks', this.visitId);
      } catch (e) {
        errorMessageBox('Failed to fetch remarks');
      }
    },

    async onAddDefaultRemarks() {

      try {

        for (const item of this.fillableRemarks) {

          const params = {
            visit_id: this.visitId,
            echo_value_id: item['id'],
          };

          await this.$store.dispatch('echo_addVisitRemark', params);
        }

      } catch (e) {

      } finally {
        /* fetch all visit echo remarks again */
        try {
          await this.$store.dispatch('echo_fetchAllVisitRemarks', this.visitId);
        } catch (e) {
          errorMessageBox('Failed to fetch remarks');
        }
      }

    }, /* onAddDefaultRemarks */


  },


};
</script>

<style scoped>

</style>
