<template>
  <div>

    <!-- section: Left Atrium -->
    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between">
        <div>Left Atrium</div>
        <div>
          <button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
            <img :src="showHideIcon" class="icon-16" alt="">
          </button>
        </div>
      </div>
      <div class="card-body" v-if="visible">

        <div class="mb-3">
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="chk_is_left_atrium_dilated" v-model="visitEcho.is_left_atrium_dilated">
            <label class="form-check-label" for="chk_is_left_atrium_dilated">Is dilated</label>
          </div>
        </div>

        <div class="form-row" v-if="visitEcho.is_left_atrium_dilated">
          <div class="col-3 mb-2">
            LA Systolic Diameter <br> (mm)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_la_systolic_diameter">
          </div>
          <div class="col-3 mb-2">
            LA Area<br>(mm²)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_la_area">
          </div>
        </div>

        <hr>

        <div class="mb-3">
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="chk_has_asd" v-model="visitEcho.has_asd">
            <label class="form-check-label" for="chk_has_asd">Has ASD</label>
          </div>
        </div>

        <div class="form-row" v-if="visitEcho.has_asd">
          <div class="col-3 mb-2">
            ASD Size (mm)
            <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_asd_size">
          </div>
        </div>


        <!-- add remarks -->
        <div class="alert alert-warning p-1 m-0">

          <div class="font-weight-bold mb-2">Remarks</div>

          <div class="mb-3">
            <div class="input-group input-group-sm">

              <select class="custom-select" v-model="selectedRemarks.LEFT_ATRIUM">
                <option v-for="(item, key) in allEchoRemarks.LEFT_ATRIUM" :value="key">{{ item.value }}</option>
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
            <tr v-for="item in visitEchoRemarks.LEFT_ATRIUM">
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
    <!-- section: Left Atrium -->

  </div>
</template>

<script>
import {sectionMixins} from "./sections_mixins";

export default {
  name: "LeftAtriumSection",
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
