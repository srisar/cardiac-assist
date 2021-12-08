<template>
	
	<div>
		
		<div class="card shadow shadow-sm">
			<div class="card-header">
				Investigations
			</div><!-- card-header -->
			
			<div class="card-body" v-if="loaded">
				
				<div class="row no-gutters">
					<div class="col">
						<AutoCompleteTextBox
								place-holder-text="Search and add investigations..."
								search-dispatch-name="visitInvestigations_search"
								add-dispatch-name="visitInvestigations_addInvestigation"
								field-name="investigation_name"
								v-model="investigationToAdd.selectedInvestigation"
								@input="onAdd"
						/>
					</div>
				</div>
				
				
				<!-- investigations list -->
				<div id="visit-investigations-list" class="">
					
					<table class="table table-bordered table-hover table-sm" v-if="!isEmptyInvestigationsList">
						
						<tbody>
						<tr v-for="item in visitInvestigationsList" @mouseover="hoverItemId = item.id" @mouseout="hoverItemId = null">
							
							<td class="position-relative">
								<p class="font-weight-bold">
									<a :href="'/app/investigations/manage.php#/edit/' + item.investigation.id" target="_blank">{{ item.investigation.investigation_name }}</a>
								</p>
								
								<!-- remarks show and edit -->
								<div class="" v-if="showEditRemarks && selectedItemId === item.id">
									<input type="text"
												 class="form-control"
												 :id="'txt_remarks'+item.id"
												 v-model="selectedItem.remarks"
												 @blur="onUpdateRemarks"
												 @keyup.enter="onUpdateRemarks">
								</div>
								<div class="" v-else>
									
									<div class="pointer" style="white-space: pre-line" v-if="item.remarks" @click="onSelectRemarkToEdit(item)">
										<span :class="abnormalRemarks(item.remarks)">{{ item.remarks }}</span>
									</div>
									<div class="text-secondary pointer" v-else @click="onSelectRemarkToEdit(item)">
										Click here to add remarks (Enter to save)
									</div>
								</div>
								<!-- remarks show and edit -->
								
								<div class="mt-2 position-absolute hover-group rounded p-1" v-show="hoverItemId === item.id">
									<button class="btn btn-tiny btn-outline-danger" @click="onDelete(item)">
										<img src="/assets/images/actions/remove.svg" alt="" class="icon-16">
									</button>
								</div>
							
							</td>
						
						</tr>
						</tbody>
					</table>
					
					<div v-else>
						<p>No items. Start adding something.</p>
					</div>
				
				</div><!-- investigations list -->
			</div><!-- card-body -->
			
			<div class="card-body" v-else>
				<TheLoading/>
			</div>
		
		</div><!-- card -->
	
	</div><!-- template -->

</template>

<script>

import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import voca from 'voca';
import ModalWindow from '../../../_common/components/ModalWindow';
import RichEditorV2 from '../../../_common/components/RichEditorV2';
import TheLoading from '../../../_common/components/TheLoading';

const _ = require( 'lodash' );

export default {
	name: 'VisitInvestigations',
	components: { AutoCompleteTextBox, TheLoading, ModalWindow, RichEditorV2 },
	
	/*
	* DATA
	* */
	data() {
		return {
			
			loaded: false,
			
			modalAddVisible: false,
			modalEditVisible: false,
			
			modalDeleteVisible: false,
			
			
			investigationToAdd: {
				selectedInvestigation: null,
				remarks: '',
			},
			
			investigationToEdit: {
				id: undefined,
				investigation: {},
				investigation_id: -1,
				remarks: '',
			},
			
			hoverItemId: null,
			
			/* edit remarks */
			showEditRemarks: false,
			selectedItemId: null,
			selectedItem: {
				item: null,
				remarks: '',
			},
			
		};
	},
	
	/*
	* COMPUTED
	* */
	computed: {
		
		visitId() {
			return this.$store.getters.getVisitId;
		},
		
		visitInvestigationsList: function () {
			return this.$store.getters.getVisitInvestigationsList;
		},
		
		investigationsList() {
			return this.$store.getters.getInvestigationsList;
		},
		
		isEmptyInvestigationsList() {
			return _.isEmpty( this.visitInvestigationsList );
		},
		
		
	},
	
	/*
	* MOUNTED
	* */
	async mounted() {
		
		try {
			
			/*
			 * Fetch investigations for the dropdown
			 * */
			await this.$store.dispatch( 'investigations_fetchAllAvailableInvestigation' );
			
		} catch ( e ) {
			errorMessageBox( 'Failed to fetch visit investigations' );
		}
		
		try {
			await this.$store.dispatch( 'visitInvestigations_fetchAll', this.visitId );
			
			this.loaded = true;
			
		} catch ( e ) {
			errorMessageBox( 'Failed to fetch visit investigation details' );
		}
		
	},
	
	/*
	* METHODS
	* */
	methods: {
		
		abnormalRemarks( remarks ) {
			console.log( remarks );
			if ( voca.first( remarks ) === '*' ) {
				return 'text-danger font-weight-bold';
			}
			return '';
		},
		
		/*
		* On add
		* */
		async onAdd() {
			
			try {
				
				const params = {
					visit_id: this.visitId,
					investigation_id: this.investigationToAdd.selectedInvestigation.id,
					remarks: this.investigationToAdd.remarks,
				};
				
				await this.$store.dispatch( 'visitInvestigations_add', params );
				
				await this.$store.dispatch( 'visitInvestigations_fetchAll', this.visitId );
				
				
			} catch ( e ) {
				errorMessageBox( 'Failed to add investigation' );
			}
			
		},
		
		/*
		* On delete
		* */
		async onDelete( item ) {
			
			try {
				
				await this.$store.dispatch( 'visitInvestigations_delete', item.id );
				await this.$store.dispatch( 'visitInvestigations_fetchAll', this.visitId );
				
			} catch ( e ) {
				errorMessageBox( 'Failed to remove selected investigation' );
			}
			
		},
		
		/*
	 * ------------------------------------------------------------
	 * Selected item's edit remarks logic
	 * ------------------------------------------------------------
	 * */
		
		onSelectRemarkToEdit( problem ) {
			this.selectedItem = _.cloneDeep( problem );
			
			this.selectedItemId = problem.id;
			this.showEditRemarks = true;
			
			this.$nextTick( () => {
				/* set focus on the selected text box */
				document.getElementById( 'txt_remarks' + problem.id ).focus();
			} );
			
		}, /* onSelectRemarkToEdit */
		
		async onUpdateRemarks() {
			
			/*
			 * if selectedProblem is null, then dont do anything
			 * this is needed because we are hooking both blur and enter events
			 * to the same function. once enter is pressed, this code will run
			 * and then set selectedProblem = null, this will cause an issue
			 * when blur is trying to run.
			 * */
			if ( _.isNull( this.selectedItem ) ) return false;
			
			try {
				
				const params = {
					id: this.selectedItemId,
					remarks: voca.capitalize( this.selectedItem.remarks ),
				};
				
				await this.$store.dispatch( 'visitInvestigations_update', params );
				
				await this.$store.dispatch( 'visitInvestigations_fetchAll', this.visitId );
				
			} catch ( e ) {
				console.log( e );
				errorMessageBox( 'Failed to update' );
			}
			
			
			this.$nextTick( () => {
				this._resetSelectedProblem();
			} );
			
		},
		
		
		_resetSelectedProblem() {
			this.selectedItem = null;
			this.selectedItemId = null;
			this.showEditRemarks = false;
		},
		
		
	},
	
};
</script>

<style scoped>

</style>
