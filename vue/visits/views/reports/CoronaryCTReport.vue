<template>

  <div>


  </div>

</template>

<script>
import {errorMessageBox} from "../../../_common/bootbox_dialogs";

export default {
  name: "CoronaryCTReport",
  data() {
    return {
      visitCoronaryCT: {},
    }
  },


  computed: {
    //
  },

  async mounted() {
    try {

      const id = this.$store.getters.getVisitId;
      const params = {
        visit_id: id,
      };

      const response = await $.get( `${ getSiteURL() }/api/get/visit/visit-coronary-ct.php`, params );
      this.visitCoronaryCT = response.data;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch coronary ct details" );
    }
  },

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
