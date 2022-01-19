<template>

  <div class="">

    <!-- section: Left Ventricle -->
    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between">
        <div>Left Ventricle</div>
        <div>
          <button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
            <img :src="showHideIcon" class="icon-16" alt="">
          </button>
        </div>
      </div>

      <div class="card-body" v-if="visible">

        <div class="form-row">

          <div class="col-3 mb-2">
            IVS Diastolic Thickness <br> (mm)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_ivs_diastolic_thickness">
          </div>
          <div class="col-3 mb-2">
            LVID Diastole <br> (mm)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvid_diastole">
          </div>
          <div class="col-3 mb-2">
            PW Diastolic Thickness <br> (mm)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pw_diastolic_thickness">
          </div>

          <div class="col-3 mb-2">
            LVEF <br> (%)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvef">
          </div>

          <div class="col-3 mb-2">
            Fractional Shortening
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_fractional_shortening">
          </div>
          <div class="col-3 mb-2">
            LVID Systole (mm)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvid_systole">
          </div>
        </div>

        <hr>
        <div class="mb-3">
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="chk_diastolic_dysfunction" v-model="visitEcho.has_diastolic_dysfunction">
            <label class="form-check-label" for="chk_diastolic_dysfunction">Diastolic Dysfunction</label>
          </div>
        </div>

        <div class="form-row" v-if="visitEcho.has_diastolic_dysfunction">
          <div class="col-2 mb-2">
            A
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_a">
          </div>
          <div class="col-2 mb-2">
            E
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_e">
          </div>
          <div class="col-2 mb-2">
            E'
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_e_bar">
          </div>

          <div class="col-2 mb-2">
            E/A
            <input type="number" class="form-control form-control-sm" :value="eOverA">
          </div>
          <div class="col-2 mb-2">
            E/E'
            <input type="number" class="form-control form-control-sm" :value="eOverEBar">
          </div>

        </div>

        <hr>

        <div class="mb-3">
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="chk_show_advanced" v-model="visitEcho.show_advanced">
            <label class="form-check-label" for="chk_show_advanced">Advanced</label>
          </div>
        </div>

        <div class="form-row" v-if="visitEcho.show_advanced">

          <div class="col-3 mb-2">
            Stroke Volume (ml)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_stroke_volume">
          </div>
          <div class="col-3 mb-2">
            Cardiac Output (l/min)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_cardiac_output">
          </div>
          <div class="col-3 mb-2">
            HR (beat/min)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_hr">
          </div>
          <div class="col-3 mb-2">
            BP (mmHg)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_bp">
          </div>

          <div class="col-3 mb-2">
            Cardiac Index (l/min/m²)
            <input type="number" class="form-control form-control-sm" :value="cardiacIndex">
          </div>
        </div>
        <div class="mb-3" v-if="bsaWarning">
          <span class="badge badge-danger">{{ bsaWarning }}</span>
        </div>


        <!-- add remarks -->
        <div class="alert alert-warning p-1 m-0">

          <div class="font-weight-bold mb-2">Remarks</div>

          <AutoCompleteTextBox
              search-dispatch-name="echo_searchLeftVentricleRemarks"
              add-dispatch-name="echo_addLeftVentricleRemark"
              field-name="value"
              v-model="remarkToAdd"
              @input="onAdd"
          />

          <div class="mb-2">
            <button class="btn btn-tiny btn-dark" @click="onAddDefaultRemarks()">Add Defaults</button>
          </div>


          <table class="table table-bordered table-sm table-hover m-0">
            <tbody>
            <tr v-for="item in visitEchoRemarks.LEFT_VENTRICLE">
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
    <!-- section: Left Ventricle -->

  </div>

</template>

<script>

import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import {sectionMixins} from './sections_mixins';

const _ = require('lodash');

export default {
  name: 'LeftVentricleSection',
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


  computed: {

    eOverA() {
      if (this.visitEcho.param_dd_a === 0) return 0;
      return (this.visitEcho.param_dd_e / this.visitEcho.param_dd_a).toFixed(2);
    },

    eOverEBar() {
      if (this.visitEcho.param_dd_e_bar === 0) return 0;
      return (this.visitEcho.param_dd_e / this.visitEcho.param_dd_e_bar).toFixed(2);
    },

    cardiacIndex() {
      if (this.visitEcho.param_cardiac_output === 0) return 0;
      return (this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa).toFixed(2);
    },

    bsaWarning() {
      if (this.visitEcho !== undefined && this.visitEcho.visit.bsa === 0) {
        return 'Invalid BSA value given. Update BSA on edit visit page.';
      }
      return null;
    },

    fillableRemarks() {
      return _.filter(this.allEchoRemarks['LEFT_VENTRICLE'], {'fillable': 'Y'});
    }

  },

  data() {
    return {
      remarkToAdd: null,
    };
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
    }, /* onAdd */


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
