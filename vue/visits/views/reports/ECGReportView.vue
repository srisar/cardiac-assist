<template>

  <div>

    <div class="paper">
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
      <button class="btn btn-success" @click="openPrintDialog()">Print</button>
      <router-link class="btn btn-secondary" to="/reports">Back</router-link>
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
.paper {
  border: solid 1px #cccccc;
  box-shadow: 0 0 10px #cccccc;
  padding: 5mm;
  margin-bottom: 5mm;
}


@media print {


  @page {
    size: A4;
    margin: 20mm 10mm;
  }

  .paper {
    font-size: 14pt !important;
    border: none;
    /*width: 200mm !important;*/
  }

}

</style>

<style lang="scss">

.ck_text {

  figure {
    //margin: 0;
    text-align: center;
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  figure img {
    width: 100% !important;
    display: inline-block;
  }

}

</style>
