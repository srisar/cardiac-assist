<template>

  <div>

    <div class="row">
      <div class="col">
        <h3 class="text-center">Special Investigations</h3>
      </div>
    </div>


    <div class="row">
      <div class="col">

        <div id="section-visit-ecg">
          <div class="card shadow shadow-sm">

            <div class="card-header">
              Electrocardiogram (ECG)
            </div>

            <div class="card-body">


             <div class="row">
               <div class="col-4">

                 <div class="input-group mb-3">
                   <div class="input-group-prepend"><span class="input-group-text">Performed On</span></div>
                   <DateField id="date-performed-on" v-model="visitECG.performed_on"/>
                 </div>

               </div>
             </div>

              <div class="form-group">
                <label>Indication</label>
                <input type="text" class="form-control" v-model="visitECG.indication">
              </div>

              <div class="form-group">
                <label>Description</label>
                <RichEditorV2 v-model="visitECG.description"></RichEditorV2>
              </div>

              <div class="text-center mt-3">
                <button class="btn btn-success" @click="onUpdate">Update</button>
              </div>


            </div>
          </div><!-- card -->
        </div><!-- visit ecg -->

      </div>
    </div>

  </div><!-- template -->

</template>

<script>
import DateField from "../../../_common/components/DateField";
import RichEditorV2 from "../../../_common/components/RichEditorV2";
import ModalWindow from "../../../_common/components/ModalWindow";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "VisitECGView",
  components: {DateField, RichEditorV2, ModalWindow},

  data() {
    return {

      visitECG: {
        visit_id: undefined,
        description: '',
        performed_on: moment().format('YYYY-MM-DD'),
        indication: '',
      },

      exist: false,
    }
  },

  computed: {
    visitId: function () {
      return this.$store.getters.getVisitId
    },
  },

  mounted() {
    this._fetch()
  },

  methods: {
    //

    /*
    * Add visit ecg investigation
    * */
    onUpdate: function () {

      const params = {
        id: this.visitECG.id,
        description: this.visitECG.description,
        indication: this.visitECG.indication,
        performed_on: this.visitECG.performed_on,
      };

      $.post(`${getSiteURL()}/api/update/visit/visit-ecg.php`, params)
          .done(r => {
            successMessageBox('ECG details updated')
          })
          .fail(e => {
            errorMessageBox('Failed to update ECG details')
          });
    },


    /*
    * Fetch visit ECG
    * */
    _fetch: function () {

      const params = {
        visit_id: this.visitId,
      }

      $.get(`${getSiteURL()}/api/get/visit/visit-ecg.php`, params)
          .done(response => {

            // check of performed_on has null value

            if (response.data.performed_on === null) {
              response.data.performed_on = moment().format('YYYY-MM-DD')
            }

            this.visitECG = response.data
          })
          .fail(() => {
          })

    }, /* fetch visit ECG */


  }, /* methods */

}
</script>

<style scoped>

</style>
