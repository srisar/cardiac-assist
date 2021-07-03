<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div> Symptoms</div>
        <div>
          <router-link class="btn btn-tiny btn-outline-success" to="/add">
            <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
          </router-link>
        </div>
      </div>

      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-hover">

          <tbody>
          <tr v-for="item in symptomsList">
            <td>
              <router-link :to="'/edit/' + item.id">{{ item.symptom_name }}</router-link>
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
  name: "ListSymptoms",
  components: {},


  data() {
    return {}
  },

  computed: {

    symptomsList() {
      return this.$store.getters.getSymptomsList;
    }

  },

  async mounted() {
    try {

      await this.$store.dispatch("symptoms_fetchAll");

    } catch (e) {
      errorMessageBox("Failed to load symptoms");
    }

  },

  methods: {},

}
</script>

<style scoped>

</style>
