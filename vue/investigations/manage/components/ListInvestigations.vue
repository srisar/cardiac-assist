<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div>Investigations</div>
        <div>
          <router-link class="btn btn-tiny btn-success" to="/add">Add</router-link>
        </div>
      </div>

      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-striped">
          <tbody>
          <tr v-for="item in investigationsList" :key="item.id">
            <td>
              <router-link :to="'/edit/' + item.id">{{ item.investigation_name }}</router-link>
            </td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>


import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "ListInvestigations",


  data() {
    return {};
  },

  computed: {

    investigationsList() {
      return this.$store.getters.getInvestigationsList;
    }

  },

  async mounted() {

    try {

      await this.$store.dispatch("investigations_fetchAll");

    } catch (e) {
      errorMessageBox("Failed to load investigations");
    }

  },


}
</script>

<style scoped>

</style>
