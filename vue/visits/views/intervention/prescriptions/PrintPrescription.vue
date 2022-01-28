<template>

  <div class="">

    <div class="d-flex align-items-center" style="gap: .25rem">
      <div>
        <button class="btn btn-primary" @click="onClickPrint">
          <img src="/assets/images/actions/print.svg" class="icon-16" alt="Print this prescription">
          {{ buttonLabel }}
        </button>
      </div>

      <div class="form-group mb-0 form-check">
        <input type="checkbox" class="form-check-input" id="chk_ems_header" v-model="addEmsHeader">
        <label class="form-check-label" for="chk_ems_header">Add EMS Header</label>
      </div>

    </div>

    <vue-html2pdf
        :show-layout="false"
        :float-layout="true"
        :enable-download="false"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="prescription-report"
        :pdf-quality="2"
        :manual-pagination="true"
        pdf-format="a5"
        pdf-orientation="portrait"
        pdf-content-width="100%"
        ref="html2Pdf"
        :html-to-pdf-options="htmlToPdfOptions"
        @progress="onProgress($event)"
    >
      <section slot="pdf-content" class="text-dark">

        <SectionEMSHeader :is-visible="addEmsHeader"/>

        <PatientBasicDetails :show-extra="true" :show-e-f="false"/>
        <div class="mb-3"></div>

        <div class="section-header text-dark">Prescribed on {{ selectedPrescription.date }}</div>
        <div class="" v-if="selectedPrescription.remarks">{{ selectedPrescription.remarks }}</div>

        <section class="pdf-item-table">
          <table class="table table-bordered table-sm">
            <thead>
            <tr>
              <th class="">Drug</th>
              <th class="text-right">Dose</th>
              <th class="text-right">Frequency</th>
              <th class="text-right">Duration</th>
              <th class="text-right">Remarks</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="item in selectedPrescription.prescription_items" :key="item.id">

              <td class="align-middle">
                {{ item.drug.drug_name }}
              </td>

              <td class="text-right">
                {{ item.dose }}
              </td>
              <td class="text-right">
                {{ item.frequency }}
              </td>
              <td class="text-right">
                {{ item.duration }}
              </td>
              <td class="text-right align-middle">
                {{ item.remarks }}
              </td>
            </tr>
            </tbody>
          </table>
        </section>


      </section>

    </vue-html2pdf>

  </div>

</template>

<script>

import VueHtml2pdf from 'vue-html2pdf';
import PatientBasicDetails from '@/visits/views/reports/basic_report_sections/PatientBasicDetails';
import SectionEMSHeader from '@/visits/views/reports/components/SectionEMSHeader';

export default {
  name: 'PrintPrescription',
  components: {SectionEMSHeader, PatientBasicDetails, VueHtml2pdf},

  props: {
    prescriptionId: {
      required: true,
    }
  },
  /* PROPS */

  data() {
    return {

      isLoading: false,
      addEmsHeader: false,

      selectedPrescription: {
        id: undefined,
        visit_id: undefined,
        remarks: '',
        date: moment().format('YYYY-MM-DD'),
        prescription_items: [],
      },

      htmlToPdfOptions: {
        margin: [5.5, 0.5, 0.5, 0.5],

        filename: `basic-report.pdf`,

        image: {
          type: 'jpeg',
          quality: 1,
        },

        enableLinks: false,

        html2canvas: {
          scale: 3,
          useCORS: true,
          letterRendering: true
        },

        jsPDF: {
          unit: 'cm',
          format: 'a5',
          orientation: 'portrait',
        },
        pagebreak: {mode: ['avoid-all', 'css', 'legacy']}
      },


    };
  },
  /* DATA */

  watch: {
    addEmsHeader(value) {
      if (value) {
        this.htmlToPdfOptions.margin = [0.5, 0.5, 0.5, 0.5];
      } else {
        this.htmlToPdfOptions.margin = [5.5, 0.5, 0.5, 0.5];
      }
    },
  },


  computed: {
    buttonLabel() {
      return this.isLoading ? 'Processing...' : 'Print';
    }
  },

  methods: {
    async onClickPrint() {

      await this.fetch();

      this.$refs.html2Pdf.generatePdf();

    },

    async fetch() {
      try {

        this.isLoading = true;

        await this.$store.dispatch('prescriptions_fetch', this.prescriptionId);
        this.selectedPrescription = this.$store.getters.getSelectedPrescription;

        this.isLoading = false;

      } catch (e) {

      }
    },

    onProgress(event) {
      console.log(event);
    }


  },
  /* METHODS */

};
</script>

<style scoped>

</style>