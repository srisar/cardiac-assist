<template>

  <div>

    <div class="paper">
      <div v-html="selectedLetter.letter"></div>
    </div>

    <div class="d-print-none text-right">
      <button class="btn btn-success" @click="openPrintDialog()">Print</button>
      <router-link :to="'/referral-letters/edit/' + selectedLetter.id" class="btn btn-secondary">Back</router-link>
    </div>

  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";

export default {
  name: "PrintReferralLetter",

  data() {
    return {
      /**/
    }
  },
  /* -- data -- */

  computed: {
    selectedLetter() {
      return this.$store.getters.getSelectedVisitLetter;
    },
  },
  /* -- computed -- */

  async mounted() {

    try {

      const id = this.$route.params.id;
      await this.$store.dispatch( "visitLetters_fetch", id );

    } catch ( e ) {
      errorMessageBox( "Failed to fetch the referral letter" );
    }

  },
  /* -- mounted -- */

  methods: {
    openPrintDialog() {
      window.print();
    }
  },


}
</script>

<style scoped>

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
