<template>
	
	<div>
		
		<!-- start: edit prescription -->
		
		<div v-if="isLoading" class="text-center font-weight-bold">Fetching selected prescription details</div>
		
		<div class="card shadow shadow-sm mb-3" v-else>
			<div class="card-header d-flex justify-content-between">
				<div>Prescription details</div>
				<div>
					<router-link to="/prescriptions" class="btn btn-tiny btn-outline-secondary">
						<img src="/assets/images/actions/close.svg" class="icon-16" alt=""> Close
					</router-link>
				</div>
			</div>
			
			<div class="card-body">
				
				<div class="row mb-3">
					<div class="col-3">
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text">Date</span></div>
							<DateField v-model="selectedPrescription.date"/>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<textarea rows="2" class="form-control" v-model="selectedPrescription.remarks" placeholder="Add a remark about the prescription..."></textarea>
				</div>
				
				
				<div class="d-flex justify-content-between mb-3">
					<div></div>
					<button class="btn btn-success" @click="onUpdatePrescription()">
						<img src="/assets/images/actions/save.svg" class="icon-16" alt=""> Update
					</button>
				</div>
				
				<div class="row no-gutters">
					<div class="col">
						<AutoCompleteTextBox
								place-holder-text="Search and add drugs..."
								search-dispatch-name="prescriptions_searchDrugs"
								add-dispatch-name="prescriptions_saveDrug"
								field-name="drug_name"
								v-model="drugToAdd.drug"
								@input="onAdd"
						/>
					</div>
				</div>
				
				<!-- drugs details -->
				<table class="table table-bordered table-sm">
					<thead>
					<tr>
						<th class="" style="width: 20%">Drug</th>
						<th class="text-right" style="width: 100px">Dose</th>
						<th class="text-right" style="width: 130px">Frequency</th>
						<th class="text-right" style="width: 100px">Duration</th>
						<th class="text-right">Remarks</th>
					</tr>
					</thead>
					
					<tbody>
					<tr v-for="item in selectedPrescription.prescription_items" :key="item.id"
							@mouseover="showDeleteItemById = item.id" @mouseout="showDeleteItemById = null">
						
						<td class="align-middle">
							{{ item.drug.drug_name }}
						</td>
						
						<td class="text-right">
							<input type="text"
										 class="form-control form-control-sm text-right"
										 @keyup="onUpdatePrescriptionItem(item)"
										 v-model.trim="item.dose">
						</td>
						<td class="text-right">
							<input type="text"
										 class="form-control form-control-sm text-right"
										 @keyup="onUpdatePrescriptionItem(item)"
										 v-model.trim="item.frequency">
						</td>
						<td class="text-right">
							<input type="text"
										 class="form-control form-control-sm text-right"
										 @keyup="onUpdatePrescriptionItem(item)"
										 v-model.trim="item.duration">
						</td>
						<td class="text-right align-middle">
							<div class="d-flex align-items-center" style="gap: 10px">
								<div class="flex-grow-1">
									<input type="text"
												 class="form-control form-control-sm"
												 @keyup="onUpdatePrescriptionItem(item)"
												 v-model.trim="item.remarks">
								</div>
								<div>
									<button class="btn btn-tiny btn-outline-danger" @click="onDeletePrescriptionItem(item)" v-show="showDeleteItemById === item.id">
										<img src="/assets/images/actions/remove.svg" class="icon-16" alt="">
									</button>
								</div>
							</div>
						
						
						</td>
					</tr>
					</tbody>
				</table>
				<!-- drugs details -->
				
				<div class="text-center mb-5" v-if="itemsUpdated">
					<span class="alert alert-success p-1">✅ Details updated</span>
				</div>
				
				
				<div>
					<button class="btn btn-sm btn-danger" @click="modalDeleteVisible = true">
						<img src="/assets/images/actions/remove.svg" class="icon-16" alt=""> Delete
					</button>
				</div>
			
			</div><!-- card-body -->
		
		</div><!-- card -->
		
		
		<!-- modal: delete prescription  -->
		<ModalWindow :visible="modalDeleteVisible" @close="modalDeleteVisible = false">
			<template v-slot:title>Delete prescription</template>
			
			<h5 class="text-center">Confirm deleting the prescription</h5>
			<p class="text-center">All associated items such as drug details associated with this prescription will be lost.</p>
			
			<div class="text-center">
				<button class="btn btn-danger" @click="onDeletePrescription()">
					<img src="/assets/images/actions/remove.svg" class="icon-24" alt=""> Delete
				</button>
			</div>
		</ModalWindow>
		<!-- end:modal: delete prescription -->
		
		<!-- end: edit prescription -->
	
	
	</div>

</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import AlertArea from '../../../../_common/components/AlertArea';
import DateField from '../../../../_common/components/DateField';
import ModalWindow from '../../../../_common/components/ModalWindow';

export default {
	name: 'EditPrescription',
	components: { AutoCompleteTextBox, AlertArea, DateField, ModalWindow },
	
	data() {
		return {
			
			/* prescription id from route */
			prescriptionId: undefined,
			isLoading: true,
			
			
			modalDeleteVisible: false,
			
			
			selectedPrescription: {
				id: undefined,
				visit_id: undefined,
				remarks: '',
				date: moment().format( 'YYYY-MM-DD' ),
				prescription_items: [],
			},
			
			
			/* delete prescription */
			chkConfirmDeletePrescription: false,
			
			
			showDeleteItemById: null,
			
			drugToAdd: {
				drug: null,
			},
			
			itemsUpdated: false,
			
		};
		
	},
	
	
	computed: {
		visitId() {
			return this.$store.getters.getVisitId;
		},
	},
	
	
	async mounted() {
		
		try {
			
			this.isLoading = true;
			
			this.prescriptionId = this.$route.params.id;
			
			await this.$store.dispatch( 'prescriptions_fetch', this.prescriptionId );
			this.selectedPrescription = this.$store.getters.getSelectedPrescription;
			
			this.isLoading = false;
			
		} catch ( e ) {
			await this.$router.push( '/prescriptions' );
		}
		
	},
	
	async beforeRouteUpdate( to, from, next ) {
		
		try {
			
			this.isLoading = true;
			
			this.prescriptionId = to.params.id;
			
			await this.$store.dispatch( 'prescriptions_fetch', this.prescriptionId );
			this.selectedPrescription = this.$store.getters.getSelectedPrescription;
			
			this.isLoading = false;
			next();
			
		} catch ( e ) {
			await this.$router.push( '/prescriptions' );
		}
		
	},
	
	methods: {
		
		
		/*
		* On selecting a drug to add to prescription
		* */
		async onAdd() {
			
			try {
				
				const params = {
					prescription_id: this.selectedPrescription.id,
					drug_id: this.drugToAdd.drug.id,
					dose: '',
					frequency: '',
					duration: '',
					remarks: '',
				};
				
				await this.$store.dispatch( 'prescriptions_addPrescriptionItem', params );
				
				/* fetch updated prescription details */
				await this.$store.dispatch( 'prescriptions_fetch', this.prescriptionId );
				this.selectedPrescription = this.$store.getters.getSelectedPrescription;
				
				
			} catch ( e ) {
				alert( 'Failed to insert selected drug' );
			}
			
		},
		
		/*
		* On update prescription details
		* */
		async onUpdatePrescription() {
			
			try {
				
				const params = {
					id: this.selectedPrescription.id,
					date: this.selectedPrescription.date,
					remarks: this.selectedPrescription.remarks,
				};
				
				// console.log(params);
				
				await this.$store.dispatch( 'prescriptions_update', params );
				
				this.itemsUpdated = true;
				setTimeout( () => {
					this.itemsUpdated = false;
				}, 3000 );
				
			} catch ( e ) {
				alert( 'Failed to update prescription details' );
			}
			
		},
		
		/*
		* On delete prescription
		* */
		async onDeletePrescription() {
			
			try {
				
				const params = {
					id: this.selectedPrescription.id,
				};
				
				await this.$store.dispatch( 'prescriptions_delete', params );
				await this.$store.dispatch( 'prescriptions_fetchAll', this.visitId );
				
				await this.$router.push( '/prescriptions' );
				
			} catch ( e ) {
				errorMessageBox( 'Failed to delete the prescription' );
			}
			
		},
		
		/*
		* On delete prescription item
		* */
		async onDeletePrescriptionItem( prescription ) {
			
			try {
				
				const params = {
					id: prescription.id,
				};
				
				await this.$store.dispatch( 'prescriptions_deletePrescriptionItem', params );
				
				/* fetch updated prescription details */
				await this.$store.dispatch( 'prescriptions_fetch', this.prescriptionId );
				this.selectedPrescription = this.$store.getters.getSelectedPrescription;
				
				this.isEditPrescriptionItemModalVisible = false;
				
			} catch ( e ) {
				errorMessageBox( 'Failed to delete prescription item' );
			}
			
		}, /* on delete prescription item */
		
		
		onUpdatePrescriptionItem: _.debounce( async function ( item ) {
			
			try {
				
				const params = {
					id: item.id,
					dose: item.dose,
					frequency: item.frequency,
					duration: item.duration,
					remarks: item.remarks,
				};
				
				await this.$store.dispatch( 'prescriptions_updatePrescriptionItem', params );
				
				this.itemsUpdated = true;
				setTimeout( () => {
					this.itemsUpdated = false;
				}, 3000 );
				
			} catch ( e ) {
				errorMessageBox( 'Failed to update items details' );
			}
			
		}, 500 ),
		
	},
	
};
</script>

<style scoped>

.clickable-td:hover {
	cursor: pointer;
	background-color: #0a90eb;
	color: #FFFFFF;
}

</style>
