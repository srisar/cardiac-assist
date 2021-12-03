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
                <div class="col-4">

                  <div class="form-group">
                    <label>Performed on <span v-if="performedOnOutput" class="badge badge-danger">{{ performedOnOutput }}</span></label>
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
                <button class="btn btn-success" @click="onUpdate">
                  <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
                </button>
              </div>

              <div class="my-2 d-flex justify-content-center" v-if="updated">
                <span class="alert alert-success m-0">✅ Successfully updated.</span>
              </div>

            </div>
          </div><!-- card -->
        </div><!-- visit ecg -->

      </div>
    </div>

  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import DateField from '../../../_common/components/DateField';
import ModalWindow from '../../../_common/components/ModalWindow';
import RichEditorV2 from '../../../_common/components/RichEditorV2';

export default {
  name: 'VisitECGView',
  components: { DateField, RichEditorV2, ModalWindow },

  data() {
    return {

      exist: false,
      performedOnOutput: '',

      updated: false,

    };
  },

  computed: {
    visitId: function () {
      return this.$store.getters.getVisitId;
    },

    visitECG() {
      return this.$store.getters.getVisitECG;
    },

  },

  async mounted() {

    try {

      await this.$store.dispatch( 'visitECG_fetch', this.visitId );

      if ( this.visitECG.performed_on === null ) {
        this.visitECG.performed_on = moment().format( 'YYYY-MM-DD' );
        this.performedOnOutput = 'No performed on date. Displaying today\'s date';
      }


    } catch ( e ) {
      errorMessageBox( 'Failed to fetch ECG details' );
    }

  },

  methods: {

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

        await this.$store.dispatch( 'visitECG_update', params );

        this.setAsUpdated();

        await this.$store.dispatch( 'visitECG_fetch', this.visitId );

      } catch ( e ) {
        errorMessageBox( 'Failed to update ECG details' );
      }
    },

    setAsUpdated() {
      this.updated = true;

      setTimeout( () => {
        this.updated = false;
      }, 3500 );
    },

  }, /* methods */

};
</script>

<style scoped>

</style>
