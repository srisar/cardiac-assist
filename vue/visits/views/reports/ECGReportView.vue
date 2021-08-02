<template>

  <div>

    <div class="paper">

      <div class="ems-header mb-3" v-if="isEmsHeaderVisible">
        <div class="d-flex align-items-center">
          <div class="mr-3">
            <img src="/assets/images/ems-logo.png" style="width: 100px" alt="">
          </div>

          <div>
            <div class="font-weight-bold">No.121, New Kalmunai Road</div>
            <div class="font-weight-bold">Kallady, Batticaloa</div>
            <div class="">Phone: 065 222 8812, 065 222 8800</div>
            <div>Email: ems.hospital.batticaloa@gmail.com</div>
          </div>

        </div>
      </div>


      <div class="mb-3">
        <p class="">Performed on {{ visitECG.performed_on }}</p>
      </div>
      <div class="mb-3">
        <p class="lead">Indication: {{ visitECG.indication }}</p>
      </div>

      <div class="ck_text" v-html="visitECG.description">
      </div>

    </div>

    <div class="d-print-none text-center">

      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="chk_ems_header" v-model="isEmsHeaderVisible">
          <label class="form-check-label" for="chk_ems_header">
            Show EMS Hospital Header
          </label>
        </div>
      </div>

      <button class="btn btn-success" @click="openPrintDialog()">
        <img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print
      </button>
      <router-link class="btn btn-secondary" to="/reports">
        <img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
      </router-link>
    </div>

  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "ECGReportView",

  data() {
    return {
      loaded: false,
      isEmsHeaderVisible: false,
    }
  },

  computed: {

    visitECG() {
      return this.$store.getters.getVisitECG;
    }

  },

  async mounted() {
    try {

      const id = this.$store.getters.getVisitId;

      await this.$store.dispatch( "visitECG_fetch", id );

    } catch ( e ) {
      errorMessageBox( "Failed to load ECG data" );
    }
  },

  methods: {
    openPrintDialog() {
      window.print();
    }
  },
}
</script>

<style scoped lang="scss">



</style>
