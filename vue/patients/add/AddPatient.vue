<template>

  <div>

    <div class="container-fluid">
      <div class="row justify-content-center">

        <div class="col-md-12 col-lg-7">

          <div class="card card-collapsible mb-4" id="container_add_patient">

            <div class="card-header">Add new patient</div>

            <div class="card-body">

              <div class="form-row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="required">First name</label>
                    <input class="form-control" type="text" v-model.trim="patient.firstName">
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group">
                    <label class="required">Last name</label>
                    <input class="form-control" type="text" v-model.trim="patient.lastName">
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="field_sex" class="required">Gender</label>
                    <select name="" id="field_sex" class="form-control" v-model="patient.gender">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in gender" :value="key">{{ item }}</option>
                    </select>
                  </div>
                </div>

              </div><!--.row-->

              <div class="form-row">
                <div class="col-sm-4 col-md-3">

                  <div class="form-group">
                    <label>NIC</label>
                    <input class="form-control" type="text" v-model.trim="patient.nic">

                  </div>


                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Date of birth</label>
                    <DateField v-model="patient.dob"></DateField>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="field_age">Age (calculated)</label>
                    <input class="form-control" type="number" id="field_age" v-model="calculatedAge" readonly>

                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="field_phone">Phone number</label>
                    <input class="form-control" type="text" id="field_phone" v-model.trim="patient.phoneNumber">

                  </div>
                </div>

              </div><!--.row-->

              <div class="row">


              </div><!--.row-->

              <div class="form-row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" rows="4" v-model="patient.address"></textarea>

                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="field_ds_division">DS division</label>
                    <select name="" id="field_ds_division" class="form-control" v-model="patient.dsDivision">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in dsDivision" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>
              </div><!--.row-->

              <div class="form-row">


                <div class="col-md-4">
                  <div class="form-group">
                    <label for="field_job">Job</label>
                    <select name="" id="field_job" class="form-control" v-model="patient.job">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in job" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="field_job_type">Job type</label>
                    <select name="" id="field_job_type" class="form-control" v-model="patient.jobType">
                      <option value="" disabled>SELECT</option>
                      <option v-for="(item, key) in jobType" :value="key">{{ item }}</option>
                    </select>

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="field_income">Monthly income</label>
                    <input class="form-control" type="number" id="field_income" v-model.trim="patient.monthlyIncome">

                  </div>
                </div>
              </div><!--.row-->


              <div class="text-right">
                <button type="button" class="btn btn-success" :disabled="!formValidated" @click="onClickSave">Add Patient</button>
                <a href="#" class="btn btn-secondary">Cancel</a>
              </div>

            </div> <!--.card-body-->
          </div><!--.card-->


        </div><!--end column-->

      </div>
    </div>

  </div>

</template>

<script>

import DateField from "../../_common/DateField";
import * as constants from "../constants";

export default {
  name: "AddPatient",
  components: {DateField,},

  data: function () {
    return {
      patient: {
        firstName: "",
        lastName: "",
        gender: "",
        nic: "",
        dob: "2012-10-12",
        age: 0,
        phoneNumber: "",
        address: "",
        dsDivision: "",
        job: "",
        jobType: "",
        monthlyIncome: 0,
      },

      gender: constants.GENDER,
      job: constants.JOB_TYPE,
      jobType: constants.JOB_TYPE,
      dsDivision: constants.DS_DIVISION

    };
  },

  computed: {

    formValidated: function () {
      if (_.isEmpty(this.patient.firstName)) return false;
      if (_.isEmpty(this.patient.lastName)) return false;
      return !_.isEmpty(this.patient.gender);
    },

    calculatedAge: function () {
      return this._calculateAge()
    }

  },

  mounted() {
  },

  methods: {

    onClickSave: function () {

      axios.post(`${getSiteUrl()}/api/patients/add`, {
        'first_name': this.patient.firstName,
        'last_name': this.patient.lastName,
        'gender': this.patient.gender,
        'nic': this.patient.nic,
        'dob': this.patient.dob,
        'age': this.patient.age,
        'phone': this.patient.phoneNumber,
        'address': this.patient.address,
        'ds_division': this.patient.dsDivision,
        'job': this.patient.job,
        'job_type': this.patient.jobType,
        'income': this.patient.monthlyIncome,
      }).then(response => {

        const id = response.data.patient.id;
        redirect(`${getSiteUrl()}/patients/edit?id=${id}`);

      }).catch(function (error) {
        console.log(error.response);
        alert(error.response.data.message);
      });


    },

    /*
    * PRIVATE METHODS
    * */

    _calculateAge: function () {
      const today = moment();
      const diff = moment.duration(today.diff(moment(this.patient.dob)));
      return Math.round(diff.asYears());
    }


  },
}
</script>

<style scoped>

</style>