<template>
  <div>

    <div class="container-fluid">

      <div class="row mb-3">
        <div class="col">
          <PatientsFilter @update="onFilterUpdate"></PatientsFilter>
        </div>
      </div>

      <div class="row">

        <div class="col">

          <table class="table table-bordered data-table-full">
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
import PatientsFilter from "./PatientsFilter";

import * as values from '../values';

const _ = require('lodash');

export default {
  name: "ListAllPatients",
  components: {DateRangeField, DateField, ModalWindow, PatientsFilter,},

  data() {
    return {
      patientsList: [],
      dataTable: null,

      filters: {
        gender: 'SELECT'
      },

      GENDERS: values.GENDERS,

    }
  },

  computed: {},

  mounted() {

    this.generateDataTable();
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

            console.log(r)

            this.dataTable.rows.add(this.patientsList);
            this.dataTable.draw();

          })
          .fail(e => {

          });
    },

    onFilterUpdate: function (payload) {

      $.get(`${getSiteURL()}/api/filter/patients.php`, {
        gender: payload.gender,
        age_start: payload.age_start,
        age_end: payload.age_end,
      }).done(r => {

        if (r.data != null) {

          this.patientsList = r.data;

          this.dataTable.clear();
          this.dataTable.rows.add(this.patientsList);
          this.dataTable.draw();

        } else {
          this.dataTable.clear();
          this.dataTable.draw();
        }


      }).fail(e => {

      });
    },


    /**
     * Generate the data-table from the fetched / filtered data
     */
    generateDataTable: function () {

      this.dataTable = $(".data-table-full").DataTable({
        responsive: true,
        autoWidth: false,
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
          {
            'data': 'address',
            render: function (data, type, row) {
              return toBrString(data);
            }
          },
          {'data': 'phone'},
          {'data': 'job'},
          {'data': 'job_type'},
          {
            'data': 'income',
            render: function (data, type, row) {
              return toCurrency(data);
            }
          },
        ],
      });

    },


  },


}
</script>

<style scoped>

</style>
