<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">

        <div class="d-flex align-items-center justify-content-between">
          <div>Visits</div>
          <button class="btn btn-tiny btn-outline-dark" @click="modalAddVisit.visible = true">
            <img src="/assets/images/actions/add.svg" alt="" class="icon-16">
            Add a visit
          </button>
        </div>

      </div>
      <div class="card-body">

        <table class="table table-sm table-bordered" v-if="visitsList.length > 0">
          <thead>
          <tr>
            <th style="width: 100px">Date</th>
            <th>Remarks</th>
            <th style="width: 10px" class="text-center">Status</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item) in visitsList">
            <td><a :href="createVisitLink(item)">{{ item.visit_date }}</a></td>
            <td style="white-space: pre-line">{{ item.remarks }}</td>
            <td class="align-middle text-center">
              <img :src="getStatusIcon(item.status)" alt="" class="icon-24">
            </td>
          </tr>
          </tbody>
        </table>

        <p v-else>There is no visit details. You can add one using the button above.</p>

      </div><!-- card-body -->
    </div><!-- card -->

    <!-- MODAL: add new visit -->
    <ModalWindow id="modal-add-visit" :visible="modalAddVisit.visible" @close="modalAddVisit.visible = false">
      <template v-slot:title>Add a visit for {{ fullName }}</template>
      <slot>

        <div class="form-row">
          <div class="col-auto">
            <div class="form-group">
              <label>Date</label>
              <DateField v-model="visitToAdd.visit_date"/>
            </div>
          </div>
        </div>

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Height (m)</label>
              <input type="number" class="form-control" v-model="visitToAdd.height">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Weight (kg)</label>
              <input type="number" class="form-control" v-model="visitToAdd.weight">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>BMI (kg/m&sup2;)</label>
              <input type="number" class="form-control" :value="bmi" readonly>
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>BSA (m&sup2;)</label>
              <input type="number" class="form-control" :value="bsa" readonly>
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Systolic BP</label>
              <input type="number" class="form-control" v-model="visitToAdd.sbp">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Diastolic BP</label>
              <input type="number" class="form-control" v-model="visitToAdd.dsp">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row justify-content-center">

          <div class="col-4 text-center">

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-dm" v-model="visitToAdd.dm">
              <label class="form-check-label" for="check-dm">DM</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-ht" v-model="visitToAdd.ht">
              <label class="form-check-label" for="check-ht">HT</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="check-dl" v-model="visitToAdd.dl">
              <label class="form-check-label" for="check-dl">DL</label>
            </div>

          </div>

        </div><!-- row -->

        <div class="row justify-content-center mt-2">
          <div class="col-2 text-center">

            <div class="form-group">
              <label>EF</label>
              <input type="number" class="form-control" v-model="visitToAdd.ef">
            </div>

          </div>
        </div>


        <div class="form-row">
          <div class="col">
            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" v-model="visitToAdd.remarks"></textarea>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col text-center">
            <button class="btn btn-success" @click="onClickSave">Save</button>
          </div>
        </div>

      </slot>
    </ModalWindow>

  </div><!-- template -->

</template>

<script>

import ModalWindow from "../../../_common/components/ModalWindow";
import DateField from "../../../_common/components/DateField";

const _ = require( 'lodash' );

export default {

  name: "ListVisits",

  components: { ModalWindow, DateField },

  data() {
    return {

      modalAddVisit: {
        visible: false,
      },

      visitToAdd: {
        patient_id: null,
        visit_date: moment().format( 'YYYY-MM-DD' ),
        remarks: "",
        height: 1,
        weight: 1,
        sbp: 0,
        dsp: 0,
        dm: false,
        ht: false,
        dl: false,
        ef: 0,
      },


    }
  },
  /* -- data -- */


  computed: {

    visitsList() {
      return this.$store.getters.getVisitsList;
    },

    patient() {
      return this.$store.getters.getPatient;
    },

    fullName() {
      return this.patient.first_name + " " + this.patient.last_name;
    },

    /* BMI calculation */
    bmi() {
      return _.round( this.visitToAdd.weight / ( this.visitToAdd.height * this.visitToAdd.height ), 2 );
    },

    bsa() {
      // https://www.nursingcenter.com/ncblog/august-2017/body-mass-index-and-body-surface-area-what-s-the-d
      return _.round( Math.sqrt( ( ( this.visitToAdd.height / 100.0 ) * this.visitToAdd.weight ) / 3600.0 ), 2 );
    },

  },
  /* -- computed -- */

  watch: {
    patient( value ) {
      this.visitToAdd.patient_id = value.id;
    }
  },
  /* -- watch -- */

  mounted() {
    /**/
  },
  /* -- mounted -- */

  methods: {

    createVisitLink( visit ) {
      return `${ getSiteURL() }/app/visits/manage.php?id=${ visit.id }`;
    },


    onClickSave() {

      const visit = {
        patient_id: this.patient.id,
        visit_date: this.visitToAdd.visit_date,
        remarks: this.visitToAdd.remarks,
        height: this.visitToAdd.height,
        weight: this.visitToAdd.weight,
        bmi: this.bmi,
        bsa: this.bsa,
        dbp: this.visitToAdd.dsp,
        sbp: this.visitToAdd.sbp,
        dm: this.visitToAdd.dm,
        ht: this.visitToAdd.ht,
        dl: this.visitToAdd.dl,
        ef: this.visitToAdd.ef,
      };


      this.$store.dispatch( 'addVisit', visit )
          .then( () => {

            // hide modal
            this.modalAddVisit.visible = false;

            // clear fields
            this.visitToAdd.remarks = ''
            this.visitToAdd.height = 1
            this.visitToAdd.weight = 1
            this.visitToAdd.dsp = 0
            this.visitToAdd.sbp = 0
            this.visitToAdd.dm = false
            this.visitToAdd.ht = false
            this.visitToAdd.dl = false
            this.visitToAdd.ef = 0

          } )
          .catch( () => {
            alert( 'Failed to add a visit' );
          } );

    }, /* on save */


    getStatusIcon( status ) {
      if ( status === "COMPLETE" ) {
        return "/assets/images/actions/done.svg";
      } else {
        return "/assets/images/actions/in-progress.svg"
      }
    }


  },
  /* *** METHODS *** */

}
</script>

<style scoped>

</style>
