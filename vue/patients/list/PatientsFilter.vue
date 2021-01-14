<template>

  <div class="card">
    <div class="card-header">Filters</div>
    <div class="card-body">

      <div class="form-row">
        <div class="col-auto">

          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <div class="input-group-text">Gender</div>
            </div>
            <select class="form-control" v-model="filters.gender">
              <option value="ALL">ALL</option>
              <option v-for="(item, index) in GENDERS" :value="index">{{ item }}</option>
            </select>
          </div><!-- input-group -->

        </div><!-- col -->

        <div class="col-auto">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <div class="input-group-text">Age</div>
            </div>
            <input type="number" class="form-control field-age" min="1" v-model="filters.age_start">
            <input type="number" class="form-control field-age" min="1" v-model="filters.age_end">
          </div><!-- input-group -->
        </div>

        <div class="col-auto">
          <button class="btn btn-success btn-sm" @click="onClickFilter">Filter</button>
        </div>

      </div><!-- row -->

    </div>
  </div><!-- card -->

</template>

<script>

import * as values from '../values'

export default {
  name: "PatientsFilter",

  data() {
    return {

      filters: {
        gender: "ALL",
        age_start: 1,
        age_end: 100,
      },

      GENDERS: values.GENDERS,
    }
  },

  computed: {
    //
  },

  mounted() {
    //
  },

  methods: {
    //

    onClickFilter: function () {

      this.$emit('update', this.filters);

    },

  },

}
</script>

<style scoped>

</style>
