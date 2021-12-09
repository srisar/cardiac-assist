<template>
	
	<div>
		<div class="container">
			<div class="row">
				<div class="col">
					
					<!-- Today's appointments -->
					<SingleDayAppointments/>
					
					
					<div class="card shadow shadow-sm mb-3">
						<div class="card-header">{{ customDateRangeLabel }}</div>
						<div class="card-body">
							
							<div class="mb-3 text-center">
								<button class="btn btn-sm btn-primary" @click="modalCustomDateRange.visible=true">Choose date range</button>
							</div>
							
							<div v-if="appointmentsBetweenDates.length > 0">
								
								<div class="mb-3 alert alert-dark text-center">
									
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="chk_all" name="chk_status" value="ALL" v-model="checkStatus">
										<label class="form-check-label" for="chk_all">
											All
										</label>
									</div>
									
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="chk_pending" name="chk_status" value="PENDING" v-model="checkStatus">
										<label class="form-check-label" for="chk_pending">
											Pending
										</label>
									</div>
									
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="chk_completed" name="chk_status" value="COMPLETED" v-model="checkStatus">
										<label class="form-check-label" for="chk_completed">
											Completed
										</label>
									</div>
									
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="chk_cancelled" name="chk_status" value="CANCELLED" v-model="checkStatus">
										<label class="form-check-label" for="chk_cancelled">
											Cancelled
										</label>
									</div>
									
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="chk_missed" name="chk_status" value="MISSED" v-model="checkStatus">
										<label class="form-check-label" for="chk_missed">
											Missed
										</label>
									</div>
								</div><!-- filter radio buttons -->
								
								<AppointmentsTable
										@status-updated="onBetweenDatesStatusUpdated()"
										:appointments="filteredAppointmentsBetweenDates"
										:colored="true"/>
							</div><!-- section -->
							
							<div v-else class="text-center">
								No results.
							</div>
						
						
						</div>
					</div>
				
				
				</div><!-- col -->
			</div><!-- row -->
		</div><!-- container -->
		
		
		<ModalWindow :visible="modalCustomDateRange.visible" @close="modalCustomDateRange.visible = false" size="small">
			<template v-slot:title>Choose date range</template>
			<div class="form-row justify-content-center">
				<div class="col">
					<div class="form-group text-center">
						<DateRangeField v-model="dateRange" class="text-center"/>
					</div>
				</div>
			</div>
			
			<div class="text-center">
				<button class="btn btn-primary" @click="onCustomDateRangeChoice()">
					<img src="/assets/images/actions/done.svg" class="icon-24" alt=""> Choose
				</button>
			</div>
		
		</ModalWindow>
	
	</div><!-- template -->

</template>

<script>
import {DateTime} from 'luxon';
import DateRangeField from '../../_common/components/DateRangeField';
import ModalWindow from '../../_common/components/ModalWindow';
import AppointmentsTable from '../components/AppointmentsTable';
import SingleDayAppointments from './appointments/SingleDayAppointments';

export default {
	name: 'AppointmentsView',
	components: { SingleDayAppointments, ModalWindow, DateRangeField, AppointmentsTable },
	data() {
		return {
			
			today: DateTime.now().toFormat( 'yyyy-MM-dd' ),
			
			/* custom date range appointments */
			modalCustomDateRange: {
				visible: false,
			},
			dateRange: {
				startDate: DateTime.now().minus( { days: 7 } ).toFormat( 'yyyy-MM-dd' ),
				endDate: DateTime.now().toFormat( 'yyyy-MM-dd' ),
			},
			checkStatus: 'ALL',
			appointmentsBetweenDates: [],
			customDateRangeLabel: 'Appointments between dates',
			
			
		};
	},
	
	
	computed: {
		statuses() {
			return this.$store.getters.getAppointmentStatuses;
		},
		
		filteredAppointmentsBetweenDates() {
			
			if ( this.checkStatus === 'ALL' ) return this.appointmentsBetweenDates;
			
			return _.filter( this.appointmentsBetweenDates, ( o ) => {
				return o.status === this.checkStatus;
			} );
			
		},
		
	},
	
	filters: {},
	
	async mounted() {
		
		/* luxon test */
		// console.log( DateTime.now().toFormat( "yyyy-MM-dd" ) );
		// console.log( DateTime.now().plus( { days: 7 } ).toFormat( "yyyy-MM-dd" ) );
		// console.log( DateTime.now().toISO() );
		
		try {
			await this.__fetchAppointments();
		} catch ( e ) {
		}
		
	},
	
	methods: {
		
		
		async onBetweenDatesStatusUpdated() {
			try {
				const params = {
					start_date: this.dateRange.startDate,
					end_date: this.dateRange.endDate,
				};
				
				this.appointmentsBetweenDates = await this.$store.dispatch( 'appointments_fetchBetweenDates', params );
			} catch ( e ) {
			
			}
		},
		
		async onCustomDateRangeChoice() {
			
			try {
				
				const params = {
					start_date: this.dateRange.startDate,
					end_date: this.dateRange.endDate,
				};
				
				this.appointmentsBetweenDates = await this.$store.dispatch( 'appointments_fetchBetweenDates', params );
				
				this.customDateRangeLabel = `Appointments between ${ params.start_date } and ${ params.end_date }`;
				
				this.modalCustomDateRange.visible = false;
			} catch ( e ) {
			
			}
			
		},
		
		
	},
	
};
</script>

<style scoped>

</style>
