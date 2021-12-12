<template>
	
	<div id="report__echo" v-if="loaded">
		
		
		<vue-html2pdf
				:show-layout="true"
				:float-layout="false"
				:enable-download="false"
				:preview-modal="true"
				:paginate-elements-by-height="50"
				filename="hee hee"
				:pdf-quality="2"
				:manual-pagination="true"
				pdf-format="a4"
				pdf-orientation="portrait"
				pdf-content-width="755px"
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
					
					<h3 class="text-center">Echocardiogram Report</h3>
					
					<!-- Patient basic details: Name and age -->
					<PatientBasicDetails :show-e-f="false" :show-extra="false"/>
					
					<div class="d-flex justify-content-end font-weight-bold" style="gap: 10px">
						<span>Performed by:</span>
						<span>{{ visit.performed_by }}</span>
					</div>
					
					<!--
					 /
					 /
					 /
					 -->
					
					<!-- SECTION: Echo Report -->
					<div class="mt-3">
						
						
						<LeftVentricle :visit-echo="visitEcho" :visit-echo-remarks="visitEchoRemarks"/>
						
						
						<!-- section: Left Atrium -->
						<div class="mb-1 pdf-item" v-if="isLeftAtriumSectionVisible">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Left Atrium</h5>
							</div>
							
							<div v-if="visitEcho.is_left_atrium_dilated">
								
								<div class="">
									<div class="font-weight-bold text-uppercase sub-title">Is dilated</div>
								</div>
								
								<table class="table table-sm table-bordered">
									<tr>
										<td class="w-50" v-if="visitEcho.param_la_systolic_diameter">
											LA Systolic Diameter:
											<span class="font-weight-bold">{{ visitEcho.param_la_systolic_diameter }}mm</span>
										</td>
										<td class="w-50" v-if="visitEcho.param_la_area">
											LA Area:
											<span class="font-weight-bold">{{ visitEcho.param_la_area }}mm²</span>
										</td>
									</tr>
								</table>
							
							</div>
							
							
							<div class="" v-if="visitEcho.has_asd && visitEcho.param_asd_size">
								
								<div class="">
									<div class="font-weight-bold text-uppercase sub-title">Has ASD</div>
								</div>
								
								<table class="table table-sm table-bordered">
									<tr>
										<td class="w-50">
											ASD Size:
											<span class="font-weight-bold">{{ visitEcho.param_asd_size }}mm</span>
										</td>
									</tr>
								</table>
							
							</div>
							
							
							<div class="" v-if="visitEchoRemarks.LEFT_ATRIUM.length > 0">
								
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.LEFT_ATRIUM">
										{{ item.value }}
									</li>
								</ul>
							</div>
						
						</div>
						<!-- section: Left Atrium -->
						
						<!-- section: mitral valve -->
						<div class="mb-1 pdf-item" v-if="visitEcho.has_mitral_stenosis || visitEchoRemarks.MITRAL_VALVE.length > 0">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Mitral Valve</h5>
							</div>
							
							<div class="" v-if="visitEcho.has_mitral_stenosis">
								
								<div class="">
									<div class="font-weight-bold text-uppercase sub-title">Has Mitral Stenosis</div>
								</div>
								
								<table class="table table-sm table-bordered">
									<tr>
										
										<td>
											<div class="d-flex justify-content-between">
												
												<div class="text-center" v-if="visitEcho.param_mitral_pressure">
													<div>Mitral Pressure 1/2 T:</div>
													<div class="font-weight-bold">{{ visitEcho.param_mitral_pressure }}mmHg</div>
												</div>
												
												<div class="text-center" v-if="visitEcho.param_mean_mitral_gradient">
													<div>Mean Mitral Gradient:</div>
													<span class="font-weight-bold">{{ visitEcho.param_mean_mitral_gradient }}mmHg</span>
												</div>
												
												<div class="text-center" v-if="visitEcho.param_doppler_mitral_valve_area">
													<div>Doppler Mitral VA:</div>
													<span class="font-weight-bold">{{ visitEcho.param_doppler_mitral_valve_area }}mm²</span>
												</div>
												
												<div class="text-center" v-if="visitEcho.param_trace_mitral_valve_area">
													<div>Trace Mitral VA:</div>
													<span class="font-weight-bold">{{ visitEcho.param_trace_mitral_valve_area }}mm²</span>
												</div>
												
												<div class="text-center" v-if="visitEcho.param_mv_score">
													<div>MV Score:</div>
													<span class="font-weight-bold">{{ visitEcho.param_mv_score }}</span>
												</div>
											
											</div>
										</td>
									
									
									</tr>
								
								</table>
							
							</div>
							
							<div class="" v-if="visitEchoRemarks.MITRAL_VALVE.length > 0">
								
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.MITRAL_VALVE">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: mitral valve -->
						
						<!-- section: aortic valve -->
						<div class="mb-1 pdf-item" v-if="isAorticValveVisible">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Aortic Valve</h5>
							</div>
							
							
							<div class="" v-if="visitEcho.is_diseased_aortic_valve">
								
								<div class="font-weight-bold text-uppercase sub-title">Diseased</div>
								
								<div class="abbr">VA = Valve Area, AV = Aortic Velocity, AG = Aortic Gradient, V = velocity</div>
								<table class="table table-sm table-bordered">
									
									
									<tr>
										<td>
											<div class="d-flex flex-wrap justify-content-between">
												
												<div class="text-center" v-if="visitEcho.param_peak_aortic_gradient">
													<div>Peak AG:</div>
													<span class="font-weight-bold">{{ visitEcho.param_peak_aortic_gradient }}mmHg</span>
												</div>
												<div class="text-center" v-if="visitEcho.param_mean_aortic_gradient">
													<div>Mean AG:</div>
													<span class="font-weight-bold">{{ visitEcho.param_mean_aortic_gradient }}mmHg</span>
												</div>
												<div class="text-center" v-if="visitEcho.param_aortic_valve_area">
													<div>Aortic VA:</div>
													<span class="font-weight-bold">{{ visitEcho.param_aortic_valve_area }}mm²</span>
												</div>
												<div class="text-center" v-if="visitEcho.param_peak_aortic_velocity">
													<div>Peak AV:</div>
													<span class="font-weight-bold">{{ visitEcho.param_peak_aortic_velocity }}cm/s</span>
												</div>
												
												<div class="text-center" v-if="visitEcho.param_peak_lvot_velocity">
													<div>Peak LVOT V:</div>
													<span class="font-weight-bold">{{ visitEcho.param_peak_lvot_velocity }}cm/s</span>
												</div>
												<div class="text-center" v-if="visitEcho.param_aortic_lvot_velocity">
													<div>Aortic/LVOT V:</div>
													<span class="font-weight-bold">{{ visitEcho.param_aortic_lvot_velocity }}cm/s</span>
												</div>
												<div class="text-center" v-if="visitEcho.param_arpht">
													<div>ARPHT:</div>
													<span class="font-weight-bold">{{ visitEcho.param_arpht }}mm</span>
												</div>
												<div class="text-center" v-if="visitEcho.param_lvot_diameter">
													<div>LVOT Diameter:</div>
													<span class="font-weight-bold">{{ visitEcho.param_lvot_diameter }}mm</span>
												</div>
											
											</div>
										</td>
									</tr>
								
								</table>
							
							</div>
							
							<div class="" v-if="visitEchoRemarks.AORTIC_VALVE.length > 0">
								
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.AORTIC_VALVE">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: aortic valve -->
						
						<!-- section: aorta -->
						<div class="mb-1 pdf-item" v-if="showAortaSection">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Aorta</h5>
							</div>
							
							<table class="table table-sm table-bordered" v-if="visitEcho.has_aorta">
								<tr>
									
									<td>
										<div class="d-flex justify-content-between">
											
											<div class="text-center" v-if="visitEcho.param_aorta_root">
												Root:
												<span class="font-weight-bold">{{ visitEcho.param_aorta_root }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_aorta_annulus">
												Annulus:
												<span class="font-weight-bold">{{ visitEcho.param_aorta_annulus }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_aorta_st_junction">
												ST Junction:
												<span class="font-weight-bold">{{ visitEcho.param_aorta_st_junction }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_aorta_proximal">
												Proximal Aorta:
												<span class="font-weight-bold">{{ visitEcho.param_aorta_proximal }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_aorta_aortic_arch">
												Aortic Arch:
												<span class="font-weight-bold">{{ visitEcho.param_aorta_aortic_arch }}mm</span>
											</div>
										
										</div>
									</td>
								
								
								</tr>
							</table>
							
							<div class="" v-if="visitEcho.is_diseased_aorta">
								<div class="">
									<div class="font-weight-bold text-uppercase">Diseased</div>
								</div>
								
								<table class="table table-bordered table-sm">
									<tr>
										<td>Aortic Root Diameter:
											<span class="font-weight-bold">{{ visitEcho.param_aortic_root_diameter }} mm</span>
										</td>
									</tr>
								</table>
							
							</div>
							
							<div class="" v-if="visitEchoRemarks.AORTA.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.AORTA">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: aorta -->
						
						<!-- section: right-ventricle -->
						<div class="mb-1 pdf-item" v-if="isRightVentricleVisible">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Right Ventricle / Pulmonary Artery</h5>
							</div>
							
							<div class="abbr">TV = Tricuspid Velocity</div>
							<table class="table table-bordered table-sm">
								
								<tr>
									<td>
										<div class="d-flex justify-content-between">
											
											<div class="text-center" v-if="visitEcho.param_tapse">
												<div>TAPSE:</div>
												<span class=" font-weight-bold">{{ visitEcho.param_tapse }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_peak_tricuspid_velocity">
												<div>Peak TV:</div>
												<span class="text-center font-weight-bold">{{ visitEcho.param_peak_tricuspid_velocity }}cm/s</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_est_rvsp">
												<div>Est. RVSP:</div>
												<span class=" font-weight-bold">{{ visitEcho.param_est_rvsp }}mmHg</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_est_cvp">
												<div>Est. CVP:</div>
												<span class="text-center font-weight-bold">{{ visitEcho.param_est_cvp }}mmHg</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_est_pasp">
												<div>Est. PASP:</div>
												<span class="font-weight-bold">{{ visitEcho.param_est_pasp }}mmHg</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_mpa">
												<div>MPA:</div>
												<span class="font-weight-bold">{{ visitEcho.param_mpa }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_rvot1">
												<div>RVOT1:</div>
												<span class="font-weight-bold">{{ visitEcho.param_rvot1 }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_rvot2">
												<div>RVOT2:</div>
												<span class="font-weight-bold">{{ visitEcho.param_rvot2 }}mm</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_rvotat">
												<div>RVOTAT:</div>
												<span class="font-weight-bold">{{ visitEcho.param_rvotat }}ms</span>
											</div>
											<div class="text-center" v-if="visitEcho.param_rvid">
												<div>RVID:</div>
												<span class="font-weight-bold">{{ visitEcho.param_rvid }}mm</span>
											</div>
										
										</div>
									</td>
								</tr>
							
							</table>
							
							
							<div class="" v-if="visitEcho.has_vsd && (visitEcho.param_rv_size || visitEcho.param_rv_ivg)">
								<div class="">
									<div class="font-weight-bold text-uppercase sub-title">VSD</div>
								</div>
								
								<table class="table table-sm table-bordered">
									<tr>
										<td>
											<div class="d-flex justify-content-center" style="gap: 1rem">
												
												<div class="" v-if="visitEcho.param_rv_size">
													Size: <span class="font-weight-bold">{{ visitEcho.param_rv_size }}mm</span>
												</div>
												<div class="" v-if="visitEcho.param_rv_ivg">
													IVG: <span class="font-weight-bold">{{ visitEcho.param_rv_ivg }}mm</span>
												</div>
											
											</div>
										</td>
									
									</tr>
								</table>
							
							</div>
							
							
							<div class="" v-if="visitEchoRemarks.RIGHT_VENTRICLE.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.RIGHT_VENTRICLE">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: right-ventricle -->
						
						<!-- section: right-atrium -->
						<div class="mb-1 pdf-item" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Right Atrium</h5>
							</div>
							
							<div class="" v-if="visitEchoRemarks.RIGHT_ATRIUM.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.RIGHT_ATRIUM">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: right-atrium -->
						
						<!-- section: pulmonic valve -->
						<div class="mb-1 pdf-item" v-if="showPulmonicValveSection">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Pulmonic Valve</h5>
							</div>
							
							
							<div class="" v-if="visitEcho.has_ps && (visitEcho.param_pv_pg || visitEcho.param_pv_annulus)">
								<div class="">
									<div class="font-weight-bold text-uppercase sub-title">Has PS</div>
								</div>
								
								<table class="table table-bordered table-sm">
									<tr>
										
										<td>
											<div class="d-flex justify-content-center" style="gap: 1rem">
												
												<div class="" v-if="visitEcho.param_pv_pg">
													PS: <span class="font-weight-bold">{{ visitEcho.param_pv_pg }}mmHg</span>
												</div>
												<div class="" v-if="visitEcho.param_pv_annulus">
													PV Annulus: <span class="font-weight-bold">{{ visitEcho.param_pv_annulus }}mm</span>
												</div>
											
											</div>
										</td>
									
									
									</tr>
								</table>
							
							</div>
							
							
							<div class="" v-if="visitEchoRemarks.PULMONIC_VALVE.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.PULMONIC_VALVE">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: pulmonic valve -->
						
						<!-- section: tricuspid -->
						<div class="mb-1 pdf-item" v-if="visitEchoRemarks.TRICUSPID.length > 0">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Tricuspid</h5>
							</div>
							
							<div class="" v-if="visitEchoRemarks.TRICUSPID.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.TRICUSPID">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: tricuspid -->
						
						<!-- section: pericardium -->
						<div class="mb-1 pdf-item" v-if="visitEchoRemarks.PERICARDIUM.length > 0">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Pericardium</h5>
							</div>
							
							<div class="" v-if="visitEchoRemarks.PERICARDIUM.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.PERICARDIUM">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: pericardium -->
						
						<!-- section: conclusions -->
						<div class="mb-1 pdf-item" v-if="visitEchoRemarks.CONCLUSION.length > 0">
							
							<div class="">
								<h5 class="font-weight-bold text-uppercase">Conclusions</h5>
							</div>
							
							<div class="" v-if="visitEchoRemarks.CONCLUSION.length > 0">
								<ul class="list-unstyled">
									<li v-for="item in visitEchoRemarks.CONCLUSION">
										{{ item.value }}
									</li>
								</ul>
							</div>
						</div>
						<!-- section: conclusions -->
					
					
					</div><!-- section-echo-report -->
				
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
import {errorMessageBox} from '@/_common/bootbox_dialogs';
import TheLoading from '@/_common/components/TheLoading';
import PatientBasicDetails from '@/visits/views/reports/basic_report_sections/PatientBasicDetails';
import LeftVentricle from '@/visits/views/reports/echo_report_sections/LeftVentricle.vue';
import VueHtml2pdf from 'vue-html2pdf';

export default {
	name: 'EchoReportView',
	components: { LeftVentricle, TheLoading, PatientBasicDetails, VueHtml2pdf },
	data() {
		return {
			loaded: false,
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
					format: 'a4',
					orientation: 'portrait',
				},
			},
			
		};
	},
	
	computed: {
		
		visitEcho() {
			return this.$store.getters.getVisitEcho;
		},
		
		visitId() {
			return this.$store.getters.getVisitId;
		},
		
		visit() {
			return this.$store.getters.getVisit;
		},
		
		allEchoRemarks: function () {
			return this.$store.getters.getEchoRemarks;
		},
		
		visitEchoRemarks: function () {
			return this.$store.getters.getVisitEchoRemarks;
		},
		
		
		/* section display logic */
		showAortaSection() {
			return this.visitEcho.has_aorta || this.visitEcho.is_diseased_aorta || this.visitEchoRemarks.AORTA.length > 0;
		},
		
		showPulmonicValveSection() {
			return this.visitEcho.has_ps || this.visitEchoRemarks.PULMONIC_VALVE.length > 0;
		},
		
		
		isLeftAtriumSectionVisible() {
			return this.visitEcho.is_left_atrium_dilated || this.visitEcho.has_asd || this.visitEchoRemarks.LEFT_ATRIUM.length > 0;
		},
		
		isAorticValveVisible() {
			return this.visitEcho.is_diseased_aortic_valve || this.visitEchoRemarks.AORTIC_VALVE.length > 0;
		},
		
		isRightVentricleVisible() {
			return this.visitEcho.param_tapse ||
					this.visitEcho.param_peak_tricuspid_velocity ||
					this.visitEcho.param_est_rvsp ||
					this.visitEcho.param_est_cvp ||
					this.visitEcho.param_est_rvsp ||
					this.visitEcho.param_mpa ||
					this.visitEcho.param_rvot1 ||
					this.visitEcho.param_rvot2 ||
					this.visitEcho.param_rvotat ||
					this.visitEcho.param_rvid ||
					this.visitEcho.has_vsd ||
					this.visitEchoRemarks.RIGHT_VENTRICLE.length > 0;
		},
		
		
		/*
		* ------------------------------------------------
		*
		* Used in left ventricle section
		*
		* -----------------------------------------------
		* */
		
		eOverA() {
			if ( this.visitEcho.param_dd_a === 0 ) return 0;
			return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_a ).toFixed( 2 );
		},
		
		eOverEBar() {
			if ( this.visitEcho.param_dd_e_bar === 0 ) return 0;
			return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_e_bar ).toFixed( 2 );
		},
		
		cardiacIndex() {
			if ( this.visitEcho.param_cardiac_output === 0 ) return 0;
			return ( this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa ).toFixed( 2 );
		},
		
		
	},
	/* -- computed -- */
	
	
	async mounted() {
		try {
			
			await this.$store.dispatch( 'visitEcho_fetch', this.visitId );
			
			
		} catch ( e ) {
			errorMessageBox( 'Failed to fetch echo details' );
		}
		
		/* fetch all echo remarks */
		try {
			
			await this.$store.dispatch( 'echo_fetchAllRemarks' );
			await this.$store.dispatch( 'echo_fetchAllVisitRemarks', this.visitId );
			
			this.loaded = true;
			
		} catch ( e ) {
			errorMessageBox( 'Failed to fetch remarks' );
		}
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

<style lang="scss">

.abbr {
	font-size : 12px;
}

@media print {
	
	#report__echo {
		
		h5 {
			font-size : 16pt;
		}
		
		.abbr {
			font-size : 12pt;
		}
		
	}
	
}

</style>
