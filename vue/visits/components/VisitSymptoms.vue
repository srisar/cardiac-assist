<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Symptoms
        <div class="float-right">
          <button class="btn btn-tiny btn-success">Add new symptom</button>
        </div>
      </div>

      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th>Symptom</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in visitSymptomsList">
            <td>{{ item.symptom.symptom_name }}</td>
            <td><a :href="createSymptomLink(item.symptom)" target="_blank" class="btn btn-tiny btn-secondary">View</a></td>
            <td>
              <button class="btn btn-tiny btn-danger">Delete</button>
            </td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->

    </div><!-- card -->

  </div><!-- Template -->

</template>

<script>
export default {
  name: "VisitSymptoms",

  data() {
    return {
      //
    }
  },

  computed: {
    visitSymptomsList: function () {
      return this.$store.getters.getVisitSymptomsList;
    }
  },

  mounted() {
    //
  },

  methods: {

    createSymptomLink: function (symptom) {
      return `${getSiteURL()}/app/symptoms/view.php?id=${symptom.id}`;
    }

  },

}
</script>

<style scoped>

</style>
