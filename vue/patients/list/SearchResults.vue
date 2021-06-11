<template>

  <div>


    <div class="container">

      <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-6">
          <PatientsFilter/>
        </div>
      </div>

    </div><!-- container -->

    <div class="container-fluid">


      <div class="row">

        <div class="col">

          <table class="table table-bordered data-table-full text-right">
            <thead>
            <tr>
              <th>Full name</th>
              <th>Gender</th>
              <th>DoB</th>
              <th>Age</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Job</th>
              <th>Job type</th>
              <th>Income</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>

        </div><!-- col -->

      </div><!-- row -->


    </div><!-- container -->


  </div><!-- template -->


</template>

<script>
import PatientsFilter from "./PatientsFilter";
import * as values from "../values";
import {errorMessageBox} from "../../_common/bootbox_dialogs";

export default {
  name: "SearchResults",
  components: {PatientsFilter},

  data() {
    return {

      dataTable: null,

    }
  },

  computed: {

    patientsList() {
      return this.$store.getters.getPatientsList;
    },

  },

  async mounted() {

    this.generateDataTable();

    try {

      const keyword = this.$route.params.keyword;

      await this.$store.dispatch("patients_search", keyword);

    } catch (e) {
      errorMessageBox("Failed to fetch patients data");
    }


    try {
      this.dataTable.rows.add(this.patientsList);
      this.dataTable.draw();
    } catch (e) {
      alert("Failed to populate data table");
    }

  },

  async beforeRouteUpdate(to, from, next) {

    // this.generateDataTable();

    try {

      const keyword = to.params.keyword;

      await this.$store.dispatch("patients_search", keyword);

    } catch (e) {
      errorMessageBox("Failed to fetch patients data");
    }

    try {

      this.dataTable.clear();
      this.dataTable.rows.add(this.patientsList);
      this.dataTable.draw();

    } catch (e) {
      alert("Failed to populate data table");
    }

    next();

  },

  methods: {

    /**
     * Generate the data-table from the fetched / filtered data
     */
    generateDataTable: function () {

      this.dataTable = $(".data-table-full").DataTable({
        responsive: true,
        autoWidth: false,
        columns: [
          {
            "data": "first_name",
            render(data, type, row) {
              return `<a href="${getSiteURL()}/app/patients/edit.php?id=${row.id}">${data} ${row.last_name}</a>`;
            }
          },
          {
            "data": "gender",
            render(data, type, row) {
              return values.GENDERS[data];
            }
          },
          {"data": "dob"},
          {
            "data": "age",
            render(data, type, row) {


              if (!_.isEmpty(row.dob)) {

                const today = moment();
                const diff = moment.duration(today.diff(moment(row.dob)));
                return Math.round(diff.asYears());
              }

              return data;
            }
          },
          {
            "data": "address",
            render(data, type, row) {
              return toBrString(data);
            }
          },
          {"data": "phone"},
          {"data": "job"},
          {"data": "job_type"},
          {
            "data": "income",
            render(data, type, row) {
              return toCurrency(data);
            }
          },
        ],
      });

    }, /* generate data table */

  }, /* methods */

}
</script>

<style scoped>

</style>
