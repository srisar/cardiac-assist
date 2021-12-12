<template>
	
	<div v-if="loaded">
		
		
		<vue-html2pdf
				:show-layout="true"
				:float-layout="false"
				:enable-download="false"
				:preview-modal="true"
				:paginate-elements-by-height="1400"
				filename="hee hee"
				:pdf-quality="2"
				:manual-pagination="false"
				pdf-format="a5"
				pdf-orientation="portrait"
				pdf-content-width="545px"
				ref="html2Pdf"
				:html-to-pdf-options="htmlToPdfOptions"
		>
			<section slot="pdf-content">
				
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
					
					<PatientDetailsDiagnoses/>
					
					<PrescriptionDetails class="section"/>
				</div><!-- paper -->
			
			</section>
		</vue-html2pdf>
		
		
		<div class="d-print-none text-center">
			
			<div class="mb-3">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="chk_ems_header" v-model="isEmsHeaderVisible">
					<label class="form-check-label" for="chk_ems_header">
						Show EMS Hospital Header
					</label>
				</div>
			</div>
			
			<button class="btn btn-success" @click="generateReport()">
				<img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print
			</button>
			<router-link class="btn btn-secondary" to="/reports">
				<img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
			</router-link>
		</div>
	
	
	</div><!-- template -->

</template>

<script>
import VueHtml2pdf from 'vue-html2pdf';
import PatientDetailsDiagnoses from './basic_report_sections/PatientDetailsDiagnoses';
import PrescriptionDetails from './basic_report_sections/PrescriptionDetails';

export default {
	name: 'BasicReportView',
	components: { PrescriptionDetails, PatientDetailsDiagnoses, VueHtml2pdf },
	data() {
		return {
			isEmsHeaderVisible: true,
			
			htmlToPdfOptions: {
				margin: [0.2, 0.1, 0.2, 0.1],
				
				filename: `basic-report.pdf`,
				
				image: {
					type: 'jpeg',
					quality: 0.98,
				},
				
				enableLinks: false,
				
				html2canvas: {
					scale: 1,
					useCORS: true,
				},
				
				jsPDF: {
					unit: 'in',
					format: 'a5',
					orientation: 'portrait',
				},
			},
			
		};
	},
	
	computed: {
		
		visit() {
			return this.$store.getters.getVisit;
		},
		
		patient() {
			return this.$store.getters.getPatient;
		},
		
		loaded() {
			return this.patient !== undefined && this.visit !== undefined;
		},
		
		
	},
	
	
	async mounted() {
	
	
	},
	
	methods: {
		openPrintDialog() {
			
			window.print();
		},
		
		
		generateReport() {
			this.$refs.html2Pdf.generatePdf();
		},
		
	},
	
};
</script>

<style lang="scss" scoped>


</style>
