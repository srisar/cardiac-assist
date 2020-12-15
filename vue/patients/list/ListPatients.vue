<template>

  <div>
    <div class="container-fluid">
      <div class="row justify-content-center">

        <div class="col-md-12">


          <table class="table table-bordered table-striped" id="table_all_patients">
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


        </div><!--end column-->

      </div>
    </div>
  </div>

</template>

<script>
export default {
  name: "ListPatients",
  data: function () {
    return {
      patients: [],
      dataTablePatients: null,
    };
  },

  mounted: function () {
    //

    this.dataTablePatients = $("#table_all_patients").DataTable();

    this._getPatients();

  },

  methods: {
    //

    _getPatients: function () {
      axios.get(`${getSiteUrl()}/api/patients/all`, {
        limit: 50,
        offset: 0
      }).then(response => {

        console.log(response);

        this.patients = response.data.data;


        for (const patient of this.patients) {
          this.dataTablePatients.row.add([
            `<a href="${getSiteUrl()}/patients/edit?id=${patient['id']}">${patient['first_name']} ${patient['last_name']}</a>`,
            patient['gender'],
            patient['dob'],
            patient['age'],
            patient['address'],
            patient['phone'],
            patient['job'],
            patient['job_type'],
            toCurrency(patient['income'])
          ]);
        }

        this.dataTablePatients.draw();

      }).catch(function (error) {
        showErrorToast(error.response.data.data);
      });
    },

  }

}
</script>

<style scoped>

</style>