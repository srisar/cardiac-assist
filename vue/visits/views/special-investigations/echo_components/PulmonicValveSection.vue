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

        <div class="mb-3">
          <div class="input-group input-group-sm">

            <select class="custom-select" v-model="selectedRemarks.PULMONIC_VALVE">
              <option v-for="(item, key) in allEchoRemarks.PULMONIC_VALVE" :value="key">{{ item.value }}</option>
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
import {sectionMixins} from "./sections_mixins";

export default {
  name: "PulmonicValveSection",
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
