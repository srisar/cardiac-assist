<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Symptoms</div>

      <div class="card-body">

        <!-- section : add symptom -->
        <div class="row mb-3">
          <div class="col">

            <div class="input-group">

              <select class="form-control" v-model="selectedSymptom">
                <option value="-1" disabled>SELECT</option>
                <option v-for="item in symptomsList" :value="item">{{ item.symptom_name }}</option>
              </select>

              <div class="input-group-append">
                <button class="btn btn-success" @click="onClickAdd">Add</button>
              </div>
            </div>

          </div><!-- col -->
        </div><!-- row -->
        <!-- section: add symptom -->


        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th>Symptom</th>
            <th style="width: 50px" class="text-center">Description</th>
            <th style="width: 100px" class="text-center">Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in visitSymptomsList">
            <td>{{ item.symptom.symptom_name }}</td>
            <td class="text-center"><a :href="createSymptomLink(item.symptom)" target="_blank" class="btn btn-tiny btn-secondary">View</a></td>
            <td class="text-center">
              <button class="btn btn-tiny btn-danger" @click="onClickDelete(item)">Delete</button>
            </td>
          </tr>
          </tbody>
        </table>

      </div><!-- card-body -->

    </div><!-- card -->


  </div><!-- Template -->

</template>

<script>

const _ = require('lodash');

export default {
  name: "VisitSymptoms",
  components: {},
  data() {
    return {
      selectedSymptom: "-1",
    }
  },

  computed: {
    visitSymptomsList: function () {
      return this.$store.getters.getVisitSymptomsList;
    },

    symptomsList: function () {
      return this.$store.getters.getSymptomsList;
    }

  },

  mounted() {
    this.$store.dispatch('fetchSymptoms');
  },

  methods: {

    createSymptomLink: function (symptom) {
      return `${getSiteURL()}/app/symptoms/view.php?id=${symptom.id}`;
    },


    /*
   * Add selected symptom to the visit
   * */
    onClickAdd: function () {

      // check if selected symptom is already added
      const s = _.find(this.visitSymptomsList, (o) => {
        return o.symptom.id === this.selectedSymptom.id;
      });

      if (s !== undefined) {
        alert(`${this.selectedSymptom.symptom_name} is already added`);
      } else {
        this.$store.dispatch('addVisitSymptom', this.selectedSymptom);
      }

    },

    onClickDelete: function (visitSymptom) {

      this.$store.dispatch('deleteVisitSymptom', visitSymptom);

    }

  },

}
</script>

<style scoped>

</style>
