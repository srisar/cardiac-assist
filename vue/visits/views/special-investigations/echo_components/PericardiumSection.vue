<template>
  <!-- section: Pericardium -->
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
      <div>Pericardium</div>
      <div>
        <button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
          <img :src="showHideIcon" class="icon-16" alt="">
        </button>
      </div>
    </div>
    <div class="card-body" v-if="visible">

      <!-- add remarks -->
      <div class="alert alert-warning p-1 m-0">

        <div class="font-weight-bold mb-2">Remarks</div>

        <div class="mb-3">
          <div class="input-group input-group-sm">

            <select class="custom-select" v-model="selectedRemarks.PERICARDIUM">
              <option v-for="(item, key) in allEchoRemarks.PERICARDIUM" :value="key">{{ item.value }}</option>
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
          <tr v-for="item in visitEchoRemarks.PERICARDIUM">
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
  <!-- section: Pericardium -->
</template>

<script>
import {sectionMixins} from "./sections_mixins";

export default {
  name: "PericardiumSection",
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
