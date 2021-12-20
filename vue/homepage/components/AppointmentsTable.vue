<template>
	
	<div class="">
		
		<table class="table table-sm table-bordered">
			<thead>
			<tr :class="tableClass">
				<th style="width: 220px">Patient</th>
				<th class="text-center" style="width: 30px">Gender</th>
				<th class="text-center" style="width: 135px">DoB/Age</th>
				<th>Remarks</th>
				<th class="text-center" style="width: 110px">Date</th>
				<th class="text-center" style="width: 10px">Status</th>
				<th style="width: 10px"></th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="item in appointments">
				<td>
					<a :href="renderPatientUrl(item.patient.id)" target="_blank">
						{{ item.patient.first_name }} {{ item.patient.last_name }}
					</a>
				</td>
				<td class="text-center">{{ item.patient.gender | gender }}</td>
				<td class="text-center">{{ item.patient.dob }} ({{ calculateAge( item.patient.dob ) }})</td>
				<td>{{ item.remarks }}</td>
				<td class="text-center">{{ item.date }}</td>
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
						
						<button class="btn btn-tiny btn-outline-secondary"
										@click="onShowSelectedAppointment(item)"
										title="Edit appointment">
							<img src="/assets/images/actions/edit.svg" class="icon-16" alt="">
						</button>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
		
		<ModalWindow :visible="modalAppointment.visible" @close="modalAppointment.visible = false">
			<template v-slot:title>Edit Appointment</template>
			<slot>
				
				<div class="form-row justify-content-center">
					<div class="col-4">
						<div class="form-group">
							<label>Date</label>
							<DateField v-model="selectedAppointment.date"/>
						</div>
					</div>
					
					<div class="col-4">
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" disabled :value="selectedAppointment.status">
						</div>
					</div>
				
				</div>
				
				<div class="form-row">
					<div class="col">
						
						<div class="form-group">
							<label>Remarks</label>
							<textarea rows="5" class="form-control" v-model.trim="selectedAppointment.remarks"></textarea>
						</div>
					
					</div>
				</div>
				
				<div class="text-center">
					<button class="btn btn-success" @click="onUpdate()">
						<img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
					</button>
				</div>
			
			
			</slot>
		</ModalWindow>
	
	</div>


</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import DateField from '../../_common/components/DateField';
import ModalWindow from '../../_common/components/ModalWindow';

export default {
	name: 'AppointmentsTable',
	components: { DateField, ModalWindow },
	props: ['appointments', 'tableClass', 'colored'],
	
	data() {
		return {
			modalAppointment: {
				visible: false,
			},
			
			selectedAppointment: {
				id: null,
				patient_id: null,
				date: '',
				remarks: '',
				status: '',
			},
		};
	},
	
	
	computed: {
		statuses() {
			return this.$store.getters.getAppointmentStatuses;
		},
	},
	
	filters: {
		gender( value ) {
			if ( value === 'MALE' ) return 'M';
			if ( value === 'FEMALE' ) return 'F';
			if ( value === 'OTHER' ) return 'O';
			return value;
		},
	},
	
	mounted() {
		
		$( '[data-toggle="tooltip"]' ).tooltip( {
			trigger: 'hover',
		} );
		
		
	},
	
	methods: {
		
		calculateAge( dob ) {
			const today = moment();
			const diff = moment.duration( today.diff( moment( dob ) ) );
			return Math.round( diff.asYears() );
		},
		
		renderPatientUrl( id ) {
			return `${ getSiteURL() }/app/patients/edit.php?id=${ id }`;
		},
		
		renderStatusColor( status ) {
			if ( this.colored ) {
				if ( status === this.statuses.completed ) return 'table-success';
				if ( status === this.statuses.pending ) return 'table-warning';
				if ( status === this.statuses.cancelled ) return 'table-danger';
				if ( status === this.statuses.missed ) return 'table-info';
			}
		},
		
		/* ------------------------------------------- */
		
		onShowSelectedAppointment( appointment ) {
			this.selectedAppointment = appointment;
			this.modalAppointment.visible = true;
		},
		
		/* ------------------------------------------- */
		
		async onSetStatus( status, item ) {
			
			try {
				const params = {
					id: item.id,
					status: status,
				};
				
				await this.$store.dispatch( 'appointments_setStatus', params );
				
				this.modalAppointment.visible = false;
				this.$emit( 'status-updated' );
			} catch ( e ) {
			
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
		
		
		async onUpdate() {
			try {
				
				const params = {
					id: this.selectedAppointment.id,
					date: this.selectedAppointment.date,
					remarks: this.selectedAppointment.remarks,
					status: this.selectedAppointment.status,
				};
				
				await this.$store.dispatch( 'appointments_update', params );
				this.modalAppointment.visible = false;
				
				this.$emit( 'status-updated' );
				
			} catch ( e ) {
				errorMessageBox( 'Failed to update appointment details' );
			}
		},
		
	},
	
};
</script>

<style>

</style>
