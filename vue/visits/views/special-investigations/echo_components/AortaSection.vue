<template>
	
	<!-- section: Aorta -->
	<div class="card mb-3">
		<div class="card-header d-flex justify-content-between">
			<div>Aorta</div>
			<div>
				<button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
					<img :src="showHideIcon" class="icon-16" alt="">
				</button>
			</div>
		</div>
		<div class="card-body" v-if="visible">
			
			<div class="mb-3">
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" id="chk_has_aorta" v-model="visitEcho.has_aorta">
					<label class="form-check-label" for="chk_has_aorta">Has values</label>
				</div>
			</div>
			
			<div class="form-row" v-if="visitEcho.has_aorta">
				<div class="col-3 mb-2">
					Root (mm)
					<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_root">
				</div>
				<div class="col-3 mb-2">
					Annulus (mm)
					<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_annulus">
				</div>
				
				<div class="col-3 mb-2">
					ST Junction (mm)
					<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_st_junction">
				</div>
				
				<div class="col-3 mb-2">
					Proximal Aorta (mm)
					<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_proximal">
				</div>
				
				<div class="col-3 mb-2">
					Aortic Arch (mm)
					<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_aortic_arch">
				</div>
			</div>
			
			<hr>
			
			<div class="mb-3">
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" id="chk_is_diseased_aorta" v-model="visitEcho.is_diseased_aorta">
					<label class="form-check-label" for="chk_is_diseased_aorta">Diseased</label>
				</div>
			</div>
			
			<div class="form-row" v-if="visitEcho.is_diseased_aorta">
				<div class="col-3 mb-2">
					Aortic Root Diameter (mm)
					<input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_root_diameter">
				</div>
			</div>
			
			<!-- add remarks -->
			<div class="alert alert-warning p-1 m-0">
				
				<div class="font-weight-bold mb-2">Remarks</div>
				
				<AutoCompleteTextBox
						search-dispatch-name="echo_searchAortaValveRemarks"
						add-dispatch-name="echo_addAortaRemark"
						field-name="value"
						v-model="remarkToAdd"
						@input="onAdd"
				/>
				
				
				<table class="table table-bordered table-sm table-hover m-0">
					<tbody>
					<tr v-for="item in visitEchoRemarks.AORTA">
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
	<!-- section: Aorta -->

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import {sectionMixins} from './sections_mixins';

export default {
	name: 'AortaSection',
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
