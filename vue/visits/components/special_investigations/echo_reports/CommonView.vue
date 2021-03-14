<template>

  <div>

    <div class="report-section__title text-uppercase mb-2 d-flex justify-content-between">

      <div>{{ label }}</div>

      <div>
        <div class="btn-group dropleft" v-if="allValues.length > 0">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            Remarks
          </button>
          <div class="dropdown-menu" style="width: 800px">
            <button style="white-space: initial;" class="dropdown-item" type="button" v-for="item in allValues" @click="$emit('add', {'item': item})">{{ item.value }}</button>
          </div>
        </div>

        <button class="btn btn-primary btn-sm" type="button" @click="$emit('new')"><i class="bi bi-plus-circle"></i></button>

      </div>

    </div>


    <table class="table table-sm table-bordered">
      <tr v-for="item in visitValues">
        <td>{{ item.value }}</td>
        <td class="text-center" style="width: 50px">
          <button class="btn btn-tiny btn-danger" @click="$emit('remove', {'item': item})">Remove</button>
        </td>
      </tr>
    </table>

  </div>


</template>

<script>
export default {
  name: "CommonView",

  /* *** PROPS *** */
  props: {
    label      : String,
    allValues  : Array,
    visitValues: Array,
  },
  /* *** PROPS *** */


}
</script>

<style scoped>

</style>
