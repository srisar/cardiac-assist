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
    visit: function () {
      return this.$store.getters.getVisit;
    }
  },

  mounted() {

    /*
    * Check if visit ecg exist, otherwise add a new one
    * */
    this._checkIfExist()
        .then(r => {

          if (!this.exist) {
            this._addNew()
                .then(r => {
                  this.visitECG = r.data;
                });
          } else {
            this.visitECG = r.data[0];
          }
        });
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

      $.post(`${getSiteURL()}/api/update/visit-ecg.php`, params)
          .done(r => {
            alert("ECG details updated");
          })
          .fail(e => {
            console.log(e);
            alert("Failed to update ECG details");
          });

    },


    /*
    * Check if visit ecg exist in the database,
    * */
    _checkIfExist: function () {

      const params = {
        visit_id: this.visit.id,
      };

      return new Promise((resolve, reject) => {
        $.get(`${getSiteURL()}/api/get/visit-ecg.php`, params)
            .done(r => {
              this.exist = !_.isEmpty(r.data);
              resolve(r);
            })
            .fail(e => {
              reject(e);
            });
      });

    },

    _addNew: function () {

      const params = {
        visit_id: this.visit.id,
        description: "",
      };

      return new Promise((resolve, reject) => {
        $.get(`${getSiteURL()}/api/save/visit-ecg.php`, params)
            .done(r => {
              this.exist = true;
              resolve(r);
            })
            .fail(e => {
              reject(e);
            });
      });

    }

  },

}
</script>

<style scoped>

</style>
