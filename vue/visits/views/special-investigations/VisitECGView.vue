<template>

  <div>

    <div class="row">
      <div class="col">

        <div id="section-visit-ecg">
          <div class="card shadow shadow-sm">

            <div class="card-header">
              Electrocardiogram (ECG)
            </div>

            <div class="card-body">


              <div class="row">
                <div class="col-5">

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
    async onUpdate() {

      try {

        const params = {
          id: this.visitECG.id,
          description: this.visitECG.description,
          indication: this.visitECG.indication,
          performed_on: this.visitECG.performed_on,
        };


        await $.post(`${getSiteURL()}/api/update/visit/visit-ecg.php`, params);

        successMessageBox('ECG details updated');
      } catch (e) {
        errorMessageBox('Failed to update ECG details');
      }
    },


    /*
    * Fetch visit ECG
    * */
    async _fetch() {

      try {

        const params = {
          visit_id: this.visitId,
        }

        const response = await $.get(`${getSiteURL()}/api/get/visit/visit-ecg.php`, params);

        if (response.data.performed_on === null) {
          response.data.performed_on = moment().format('YYYY-MM-DD')
        }

        this.visitECG = response.data;


      } catch (e) {
        errorMessageBox("Failed to fetch ECG details");
      }

    }, /* fetch visit ECG */


  }, /* methods */

}
</script>

<style scoped>

</style>
