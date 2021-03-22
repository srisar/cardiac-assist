<template>

  <div>

    <div>

      <div class="form-group">
        <label>Description</label>
        <RichEditorV2 v-model="visitECG.description"></RichEditorV2>
      </div>

      <div class="text-center mt-3">
        <button class="btn btn-success" @click="onUpdate">Update</button>
      </div>

    </div>

  </div><!-- template -->

</template>

<script>
import ModalWindow from "../../../_common/components/ModalWindow";
import RichEditorV2 from "../../../_common/components/RichEditorV2";
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";

const _ = require('lodash');

export default {
  name: "VisitECG",

  components: {RichEditorV2, ModalWindow},

  data() {
    return {

      visitECG: {
        visit_id: undefined,
        description: ""
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
        description: this.visitECG.description
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
