<template>

  <div>

    <div class="card">
      <div class="card-header">Visits</div>
      <div class="card-body">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th style="width: 100px">Date</th>
            <th>Remarks</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in visitsList">
            <td><a :href="createVisitLink(item)">{{ item.visit_date }}</a></td>
            <td>{{ item.remarks }}</td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->
    </div><!-- card -->

  </div><!-- template -->

</template>

<script>
export default {
  name: "ListVisits",

  data() {
    return {
      //
    }
  },

  computed: {
    visitsList: function () {
      return this.$store.getters.getVisitsList;
    }

  },

  mounted() {

  },

  methods: {
    //
    createVisitLink: function (visit) {
      return `${getSiteURL()}/app/visits/manage.php?id=${visit.id}`;
    }
  },

}
</script>

<style scoped>

</style>
