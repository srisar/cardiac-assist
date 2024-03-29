<template>
	
	<div>
		
		<div class="card shadow shadow-sm">
			<div class="card-header">
				
				<div class="d-flex align-items-center justify-content-between">
					<div>Appointments</div>
					<button class="btn btn-tiny btn-outline-success" @click="modalAddAppointment.visible = true">
						<img src="/assets/images/actions/add.svg" class="icon-16" alt="">
						Add an appointment
					</button>
				</div>
			
			</div>
			<div class="card-body">
				
				<table class="table table-sm table-bordered" v-if="appointmentsList.length > 0">
					<thead>
					<tr>
						<th style="width: 100px">Date</th>
						<th>Remarks</th>
						<th>Status</th>
						<th style="width: 10px"></th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="(item) in appointmentsList">
						<td><a href="#" @click="onClickSelectAppointment(item)">{{ item.date }}</a></td>
						<td>{{ item.remarks }}</td>
						<td class="text-center" :class="renderStatusColor(item.status)" data-toggle="tooltip" data-placement="left" :title="item.status">
							<img :src="getStatusIcon(item.status)" class="icon-16" alt="">
						</td>
						<td>
							<div class="d-flex" style="gap: 5px">
								
								<button class="btn btn-tiny btn-success"
												:class="{'d-none': item.status === statuses.completed}"
												@click="onSetStatus(statuses.completed, item)"
												title="Set as completed">
									<img src="/assets/images/actions/done.svg" class="icon-16" alt="">
								</button>
								
								<button class="btn btn-tiny btn-danger"
												:class="{'d-none': item.status === statuses.missed}"
												@click="onSetStatus(statuses.missed, item)"
												title="Set as missed">
									<img src="/assets/images/actions/warning.svg" class="icon-16" alt="">
								</button>
								
								<button class="btn btn-tiny btn-info"
												:class="{'d-none': item.status === statuses.cancelled}"
												@click="onSetStatus(statuses.cancelled, item)"
												title="Set as cancelled">
									<img src="/assets/images/actions/question.svg" class="icon-16">
								</button>
								
								<button class="btn btn-tiny btn-warning"
												:class="{'d-none': item.status === statuses.pending}"
												@click="onSetStatus(statuses.pending, item)"
												title="Set as pending">
									<img src="/assets/images/actions/in-progress.svg" class="icon-16">
								</button>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				
				<p v-else>There is no appointments set for the patient. Add one using the button above.</p>
			
			</div><!-- card-body -->
		</div><!-- card -->
		
		
		<!-- ----------------------- -->
		<!-- MODAL: Add appointment -->
		<!-- ----------------------- -->
		<ModalWindow id="modal-add-appointment" :visible="modalAddAppointment.visible" @modal-hiding="modalAddAppointment.visible = false">
			<template v-slot:title>Add an appointment for {{ fullName }}</template>
			<slot>
				
				<div class="form-row">
					<div class="col-auto">
						<div class="form-group">
							<label>Date</label>
							<DateField v-model="appointmentToAdd.date"/>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label>Remarks</label>
							<textarea class="form-control" v-model="appointmentToAdd.remarks" rows="5"></textarea>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="col text-center">
						<button class="btn btn-success" @click="onSave()">
							<img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Save
						</button>
					</div>
				</div>
			
			</slot>
		</ModalWindow>
		<!-- add appointment -->
		
		
		<!-- ----------------------- -->
		<!-- MODAL: Edit appointment -->
		<!-- ----------------------- -->
		<ModalWindow id="modal-edit-appointment" :visible="modalEditAppointment.visible" @close="modalEditAppointment.visible = false">
			<template v-slot:title>Edit appointment</template>
			<slot>
				
				<div class="form-row">
				
				</div>
				
				<div class="form-row">
					<div class="col-4">
						<div class="form-group">
							<label>Date</label>
							<DateField v-model="appointmentToEdit.date"/>
						</div>
					</div><!-- col -->
				
				</div><!-- row -->
				
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label>Remarks</label>
							<textarea class="form-control" v-model="appointmentToEdit.remarks" rows="5"></textarea>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="col">
						
						<div class="d-flex justify-content-center">
							<button class="btn btn-success mx-1" @click="onUpdate()">Update</button>
							<button class="btn btn-danger mx-1" @click="onDelete()">Delete</button>
						</div>
					
					</div>
				</div>
			
			</slot>
		</ModalWindow>
	
	</div><!-- template -->

</template>

<script>

import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import DateField from '../../../_common/components/DateField';
import ModalWindow from '../../../_common/components/ModalWindow';

const _ = require( 'lodash' );

export default {
	name: 'ListAppointments',
	
	components: { ModalWindow, DateField },
	
	data() {
		return {
			
			colored: true,
			
			modalAddAppointment: {
				visible: false,
			},
			modalEditAppointment: {
				visible: false,
			},
			
			appointmentToAdd: {
				patient_id: undefined,
				date: moment().format( 'YYYY-MM-DD' ),
				remarks: '',
			},
			
			appointmentToEdit: {
				id: undefined,
				patient_id: undefined,
				date: undefined,
				remarks: undefined,
				status: undefined,
			},
			
			statuses: {
				pending: 'PENDING',
				completed: 'COMPLETED',
				missed: 'MISSED',
				cancelled: 'CANCELLED',
			},
			
		};
	},
	/* *** DATA *** */
	
	computed: {
		
		appointmentsList() {
			return this.$store.getters.getAppointmentsList;
		},
		
		patient() {
			return this.$store.getters.getPatient;
		},
		
		fullName() {
			return this.patient.first_name + ' ' + this.patient.last_name;
		},
		
	},
	/* -- computed -- */
	
	
	async mounted() {
	
	},
	/* -- mounted -- */
	
	
	methods: {
		
		
		async onSave() {
			
			try {
				
				const appointment = {
					patient_id: this.patient.id,
					date: this.appointmentToAdd.date,
					remarks: this.appointmentToAdd.remarks,
				};
				
				await this.$store.dispatch( 'appointments_add', appointment );
				
				await this.$store.dispatch( 'appointments_fetchAll', this.patient.id );
				
				// hide modal
				this.modalAddAppointment.visible = false;
				
				// clear fields
				this.appointmentToAdd.remarks = '';
				
			} catch ( e ) {
				errorMessageBox( 'Failed to add an appointment' );
			}
			
		}, /* on click save */
		
		async onUpdate() {
			
			try {
				
				const appointment = {
					id: this.appointmentToEdit.id,
					date: this.appointmentToEdit.date,
					remarks: this.appointmentToEdit.remarks,
					status: this.appointmentToEdit.status,
				};
				
				await this.$store.dispatch( 'appointments_update', appointment );
				await this.$store.dispatch( 'appointments_fetchAll', this.patient.id );
				this.modalEditAppointment.visible = false;
				
			} catch ( e ) {
				errorMessageBox( 'Failed to update the appointment' );
			}
			
			
		}, /* on click update */
		
		async onDelete() {
			
			try {
				
				const id = this.appointmentToEdit.id;
				await this.$store.dispatch( 'appointments_delete', id );
				
				await this.$store.dispatch( 'appointments_fetchAll', this.patient.id );
				
				this.modalEditAppointment.visible = false;
				
			} catch ( e ) {
				errorMessageBox( 'Failed to delete the appointment' );
			}
			
			
		}, /* on click delete */
		
		onClickShowAddModal() {
			this.appointmentToAdd.patient_id = this.patient.id;
			this.modalAddAppointment.visible = true;
		},
		
		onClickSelectAppointment( appointment ) {
			this.appointmentToEdit = appointment;
			this.modalEditAppointment.visible = true;
		},
		
		
		async onSetStatus( status, item ) {
			
			try {
				const params = {
					id: item.id,
					status: status,
				};
				
				await this.$store.dispatch( 'appointments_setStatus', params );
				
				await this.$store.dispatch( 'appointments_fetchAll', this.patient.id );
				
				this.$emit( 'status-updated' );
			} catch ( e ) {
			
			}
		},
		
		
		renderStatusColor( status ) {
			if ( this.colored ) {
				if ( status === this.statuses.completed ) return 'table-success';
				if ( status === this.statuses.pending ) return 'table-warning';
				if ( status === this.statuses.cancelled ) return 'table-info';
				if ( status === this.statuses.missed ) return 'table-danger';
			}
		},
		
		getStatusIcon( status ) {
			if ( status === this.statuses.completed ) {
				return '/assets/images/actions/done.svg';
			} else if ( status === this.statuses.pending ) {
				return '/assets/images/actions/in-progress.svg';
			} else if ( status === this.statuses.missed ) {
				return '/assets/images/actions/warning.svg';
			} else if ( status === this.statuses.cancelled ) {
				return '/assets/images/actions/question.svg';
			}
		},
		
	},
	/* -- methods -- */
	
};
</script>

<style scoped>

</style>
