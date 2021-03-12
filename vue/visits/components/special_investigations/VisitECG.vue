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

const _ = require('lodash');

export default {
  name: "VisitECG",

  components: { RichEditorV2, ModalWindow },

  data() {
    return {

      visitECG: {
        visit_id   : undefined,
        description: ""
      },

      exist: false,
    }
  },

  computed: {
    visit: function () {
      return this.$store.getters.getVisit
    }
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
        id         : this.visitECG.id,
        description: this.visitECG.description
      };

      $.post(`${getSiteURL()}/api/update/visit-ecg.php`, params)
          .done(r => {
            bootbox.alert('ECG details updated')
          })
          .fail(e => {
            console.log(e);
            bootbox.alert('Failed to update ECG details')
          });

    },


    /*
    * Fetch visit ECG
    * */
    _fetch: function () {

      const params = {
        visit_id: this.visit.id,
      }

      $.get(`${getSiteURL()}/api/get/visit-ecg.php`, params)
          .done(response => {
            this.visitECG = response.data
          })
          .fail(error => {
          })
    }, /* fetch visit ECG */


  }, /* methods */

}
</script>

<style scoped>

</style>
