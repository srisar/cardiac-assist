<template>
	<div>
		
		<!-- section: Mitral Valve -->
		<div class="card mb-3">
			<div class="card-header d-flex justify-content-between">
				<div>Mitral Valve</div>
				<div>
					<button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
						<img :src="showHideIcon" class="icon-16" alt="">
					</button>
				</div>
			</div>
			<div class="card-body" v-if="visible">
				
				<div class="mb-3">
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input" id="chk_has_mitral_stenosis" v-model="visitEcho.has_mitral_stenosis">
						<label class="form-check-label" for="chk_has_mitral_stenosis">Has Mitral Stenosis</label>
					</div>
				</div>
				
				<div class="form-row" v-if="visitEcho.has_mitral_stenosis">
					<div class="col-3 mb-2">
						Mitral Pressure 1/2 T (mmHg)
						<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mitral_pressure">
					</div>
					<div class="col-3 mb-2">
						Mean Mitral Gradient (mmHg)
						<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mean_mitral_gradient">
					</div>
					<div class="col-3 mb-2">
						Doppler Mitral Valve Area (mm²)
						<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_doppler_mitral_valve_area">
					</div>
					<div class="col-3 mb-2">
						Trace Mitral Valve Area (mm²)
						<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_trace_mitral_valve_area">
					</div>
					<div class="col-3 mb-2">
						MV Score
						<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mv_score">
					</div>
				</div>
				
				<!-- add remarks -->
				<div class="alert alert-warning p-1 m-0">
					
					<div class="font-weight-bold mb-2">Remarks</div>
					
					<AutoCompleteTextBox
							search-dispatch-name="echo_searchMitralValveRemarks"
							add-dispatch-name="echo_addMitralValveRemark"
							field-name="value"
							v-model="remarkToAdd"
							@input="onAdd"
					/>
					
					
					<table class="table table-bordered table-sm table-hover m-0">
						<tbody>
						<tr v-for="item in visitEchoRemarks.MITRAL_VALVE">
							<td style="white-space: pre-line">{{ item.value }}</td>
							<td style="width: 30px">
								<button class="btn btn-tiny btn-outline-danger" @click="$emit('delete-remark',item)">
									<img src="/assets/images/actions/remove.svg" class="icon-16" alt="">
								</button>
							</td>
						</tr>
						</tbody>
					</table>
				
				</div>
				<!-- add remarks -->
			
			</div>
		</div>
		<!-- section: Mitral Valve -->
	
	</div>
</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import {sectionMixins} from './sections_mixins';

export default {
	name: 'MitralValveSection',
	components: { AutoCompleteTextBox },
	mixins: [sectionMixins],
	props: [
		'visitId',
		'visitEcho',
		'visitEchoRemarks',
		'allEchoRemarks',
		'selectedRemarks',
		'isDisableAddRemarks',
	],
	
	data() {
		return {
			remarkToAdd: null,
		};
	},
	
	methods: {
		
		async onAdd() {
			try {
				
				const id = this.remarkToAdd[ 'id' ];
				
				const params = {
					visit_id: this.visitId,
					echo_value_id: id,
				};
				
				await this.$store.dispatch( 'echo_addVisitRemark', params );
				
			} catch ( e ) {
				errorMessageBox( 'Failed to insert the remark' );
			}
			
			/* fetch all visit echo remarks again */
			try {
				await this.$store.dispatch( 'echo_fetchAllVisitRemarks', this.visitId );
			} catch ( e ) {
				errorMessageBox( 'Failed to fetch remarks' );
			}
		},
		
	},
	
};
</script>

<style scoped>

</style>
