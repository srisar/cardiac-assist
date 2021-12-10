<template>
	
	<div>
		
		<div class="row">
			<div class="col">
				
				<div class="card shadow-sm shadow">
					
					<div class="card-header">Other remarks</div>
					
					<div class="card-body">
						
						<div class="row justify-content-center">
							<div class="col">
								
								<div class="form-group">
									<RichEditorV2 v-model="otherRemarks"/>
								</div>
							
							</div>
						</div>
						
						
						<div class="row">
							<div class="col">
								
								<div class="text-center">
									<button class="btn btn-success" @click="onUpdate()">
										<img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
									</button>
								</div>
							
							</div>
						</div>
						
						<div class="row justify-content-center mt-3" v-if="updated">
							<div class="col">
								
								<div class="text-center">
									<span class="alert alert-success p-1">✅ Remarks updated</span>
								</div>
							
							</div>
						</div>
					
					</div>
				
				</div><!-- card -->
			
			</div><!-- col -->
		</div><!-- row -->
	
	
	</div>

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import RichEditorV2 from '../../../_common/components/RichEditorV2';

export default {
	name: 'OtherRemarksView',
	components: { RichEditorV2 },
	
	data() {
		return {
			
			otherRemarks: '',
			
			updated: false,
			
		};
	},
	
	computed: {
		visitId() {
			return this.$store.getters.getVisitId;
		},
		
		visit() {
			return this.$store.getters.getVisit;
		},
	},
	
	watch: {
		visit() {
			this.otherRemarks = this.visit.other_remarks || '';
		},
	},
	
	created() {
		
		this.otherRemarks = this.visit.other_remarks || '';
		
	},
	
	methods: {
		
		async onUpdate() {
			
			try {
				
				const params = {
					id: this.visitId,
					other_remarks: this.otherRemarks,
				};
				
				await $.post( `${ getSiteURL() }/api/update/visit/visit-other-remarks.php`, params );
				
				this.updated = true;
				
				setTimeout( () => {
					this.updated = false;
				}, 3000 );
				
				await this.$store.dispatch( 'visit_fetch', this.visitId );
				
				
			} catch ( e ) {
				errorMessageBox( 'Failed to update' );
			}
			
		},
		
	},
	
};
</script>

<style scoped>

</style>
