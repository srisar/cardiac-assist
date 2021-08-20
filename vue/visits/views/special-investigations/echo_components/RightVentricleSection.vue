<template>

  <!-- section: Right Ventricle / Pulmonary Artery -->
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
      <div>Right Ventricle / Pulmonary Artery</div>
      <div>
        <button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
          <img :src="showHideIcon" class="icon-16" alt="">
        </button>
      </div>
    </div>
    <div class="card-body" v-if="visible">

      <div class="mb-3">
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="chk_has_right_ventricle" v-model="visitEcho.has_right_ventricle">
          <label class="form-check-label" for="chk_has_right_ventricle">Has values</label>
        </div>
      </div>

      <div class="form-row" v-if="visitEcho.has_right_ventricle">

        <div class="col-3 mb-2">
          TAPSE <br> (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_tapse">
        </div>

        <div class="col-3 mb-2">
          Peak Tricuspid Velocity (cm/s)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_tricuspid_velocity">
        </div>

        <div class="col-3 mb-2">
          Est. RVSP <br> (mmHg)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_rvsp">
        </div>

        <div class="col-3 mb-2">
          Est. PASP <br> (mmHg)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_pasp">
        </div>

        <div class="col-3 mb-2">
          Est. CVP (mmHg)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_cvp">
        </div>

        <div class="col-3 mb-2">
          MPA (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mpa">
        </div>

        <div class="col-3 mb-2">
          RVOT1 (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvot1">
        </div>

        <div class="col-3 mb-2">
          RVOT2 (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvot2">
        </div>

        <div class="col-3 mb-2">
          RVOTAT (ms)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvotat">
        </div>

        <div class="col-3 mb-2">
          RVID (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvid">
        </div>

      </div>

      <hr>

      <div class="mb-3">
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="chk_has_vsd" v-model="visitEcho.has_vsd">
          <label class="form-check-label" for="chk_has_vsd">VSD</label>
        </div>
      </div>

      <div class="form-row" v-if="visitEcho.has_vsd">
        <div class="col-3 mb-2">
          Size (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rv_size">
        </div>
        <div class="col-3 mb-2">
          IVG (mm)
          <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rv_ivg">
        </div>
      </div>


      <!-- add remarks -->
      <div class="alert alert-warning p-1 m-0">

        <div class="font-weight-bold mb-2">Remarks</div>

        <div class="mb-3">
          <div class="input-group input-group-sm">

            <select class="custom-select" v-model="selectedRemarks.RIGHT_VENTRICLE">
              <option v-for="(item, key) in allEchoRemarks.RIGHT_VENTRICLE" :value="key">{{ item.value }}</option>
            </select>

            <div class="input-group-append">
              <button class="btn btn-outline-primary" @click="$emit('insert-remark')" :disabled="isDisableAddRemarks">
                <img src="/assets/images/actions/done.svg" class="icon-16" alt=""> Insert
              </button>
              <button class="btn btn-outline-success" @click="$emit('open-modal')">
                <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
              </button>
            </div>

          </div>
        </div>


        <table class="table table-bordered table-sm table-hover m-0">
          <tbody>
          <tr v-for="item in visitEchoRemarks.RIGHT_VENTRICLE">
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
  <!-- section: Right Ventricle / Pulmonary Artery -->

</template>

<script>
import {sectionMixins} from "./sections_mixins";

export default {
  name: "RightVentricleSection",
  mixins: [sectionMixins],
  props: [
    "visitEcho",
    "visitEchoRemarks",
    "allEchoRemarks",
    "selectedRemarks",
    "isDisableAddRemarks",
  ],
}
</script>

<style scoped>

</style>
