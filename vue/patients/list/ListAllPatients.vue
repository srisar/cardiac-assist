<template>
  <div>

    <div class="container-fluid">

      <div class="row">
        <div class="col">
          <div class="alert alert-primary">

          </div>
        </div>
      </div>

      <div class="row">

        <div class="col">

          <table class="table table-bordered">
            <thead>
            <tr>
              <th>Full name</th>
              <th>Gender</th>
              <th>Date of birth</th>
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

import DateRangeField from "../../_common/components/DateRangeField";
import DateField from "../../_common/components/DateField";
import ModalWindow from "../../_common/components/ModalWindow";

import * as values from '../values';

export default {
  name: "ListAllPatients",
  components: {DateRangeField, DateField, ModalWindow},

  data() {
    return {
      patientsList: [],
      dateRange: {startDate: moment().format('YYYY-MM-DD'), endDate: moment().format('YYYY-MM-DD')},
      date: moment().format('YYYY-MM-DD'),
    }
  },

  computed: {},

  mounted() {

    this.fetchAllPatients();

  },

  methods: {

    /*
    * Fetch all patients
    * */
    fetchAllPatients: function () {
      $.get(`${getSiteURL()}/api/get/patients.php`)
          .done(r => {
            this.patientsList = r.data;
            this.generateDataTable();

          })
          .fail(e => {

          });
    },


    generateDataTable: function () {

      $("table").DataTable({
        data: this.patientsList,
        columns: [
          {
            'data': 'first_name',
            render: function (data, type, row) {
              return `<a href="${getSiteURL()}/app/patients/edit.php?id=${row.id}">${data} ${row.last_name}</a>`;
            }
          },
          {
            'data': 'gender',
            render: function (data, type, row) {
              return values.GENDERS[data];
            }
          },
          {'data': 'dob'},
          {'data': 'age'},
          {'data': 'address'},
          {'data': 'phone'},
          {'data': 'job'},
          {'data': 'job_type'},
          {
            'data': 'income',
            render: function (data, type, row) {
              return toCurrency(data, 'LKR');
            }
          },
        ]
      });
    },



  },


}
</script>

<style scoped>

</style>
