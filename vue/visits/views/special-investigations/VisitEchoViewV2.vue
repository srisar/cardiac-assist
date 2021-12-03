<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Echocardiography
      </div>

      <div class="card-body" v-if="loaded">

        <LeftVentricleSection
            :show="false"
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('LEFT_VENTRICLE')"
            @insert-remark="onInsert('LEFT_VENTRICLE')"
            @open-modal="onOpenAddModal('LEFT_VENTRICLE')"
            @delete-remark="onDelete"
        />


        <LeftAtriumSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('LEFT_ATRIUM')"
            @insert-remark="onInsert('LEFT_ATRIUM')"
            @open-modal="onOpenAddModal('LEFT_ATRIUM')"
            @delete-remark="onDelete"
        />


        <MitralValveSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('MITRAL_VALVE')"
            @insert-remark="onInsert('MITRAL_VALVE')"
            @open-modal="onOpenAddModal('MITRAL_VALVE')"
            @delete-remark="onDelete"
        />


        <AorticValveSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('AORTIC_VALVE')"
            @insert-remark="onInsert('AORTIC_VALVE')"
            @open-modal="onOpenAddModal('AORTIC_VALVE')"
            @delete-remark="onDelete"
        />

        <AortaSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('AORTA')"
            @insert-remark="onInsert('AORTA')"
            @open-modal="onOpenAddModal('AORTA')"
            @delete-remark="onDelete"
        />


        <RightVentricleSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('RIGHT_VENTRICLE')"
            @insert-remark="onInsert('RIGHT_VENTRICLE')"
            @open-modal="onOpenAddModal('RIGHT_VENTRICLE')"
            @delete-remark="onDelete"
        />

        <RightAtriumSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('RIGHT_ATRIUM')"
            @insert-remark="onInsert('RIGHT_ATRIUM')"
            @open-modal="onOpenAddModal('RIGHT_ATRIUM')"
            @delete-remark="onDelete"
        />


        <PulmonicValveSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('PULMONIC_VALVE')"
            @insert-remark="onInsert('PULMONIC_VALVE')"
            @open-modal="onOpenAddModal('PULMONIC_VALVE')"
            @delete-remark="onDelete"
        />


        <TricuspidSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('TRICUSPID')"
            @insert-remark="onInsert('TRICUSPID')"
            @open-modal="onOpenAddModal('TRICUSPID')"
            @delete-remark="onDelete"
        />

        <PericardiumSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('PERICARDIUM')"
            @insert-remark="onInsert('PERICARDIUM')"
            @open-modal="onOpenAddModal('PERICARDIUM')"
            @delete-remark="onDelete"
        />


        <ConclusionsSection
            :visit-echo="visitEcho"
            :visit-echo-remarks="visitEchoRemarks"
            :selected-remarks="selectedRemarks"
            :all-echo-remarks="allEchoRemarks"
            :is-disable-add-remarks="hasRemarks('CONCLUSION')"
            @insert-remark="onInsert('CONCLUSION')"
            @open-modal="onOpenAddModal('CONCLUSION')"
            @delete-remark="onDelete"
        />


        <div class="text-center">
          <button class="btn btn-success" @click="onUpdate()">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
          </button>
        </div>


        <div class="my-2 d-flex justify-content-center" v-if="updated">
          <span class="alert alert-success m-0">✅ Successfully updated.</span>
        </div>


      </div><!-- card-body -->
      <div v-else class="my-5">
        <TheLoading/>
      </div>

    </div><!-- card -->


    <!-- Modal: add remarks -->
    <ModalWindow :visible="modalAddVisible" @close="modalAddVisible = false">
      <template v-slot:title>Add new remark for {{ echoRemarkToAdd.typeLabel }}</template>
      <slot>

        <div class="form-group">
          <label>Type</label>
          <input type="text" class="form-control" readonly v-model="echoRemarkToAdd.typeLabel">
        </div>

        <div class="form-group">
          <label>Value</label>
          <textarea class="form-control" rows="3" v-model.trim="echoRemarkToAdd.value"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAddRemark()" :disabled="echoRemarkToAdd.value === ''">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Add
          </button>
        </div>

      </slot>
    </ModalWindow>

  </div>


</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AlertArea from '../../../_common/components/AlertArea';
import ModalWindow from '../../../_common/components/ModalWindow';
import TheLoading from '../../../_common/components/TheLoading';
import AortaSection from './echo_components/AortaSection';
import AorticValveSection from './echo_components/AorticValveSection';
import ConclusionsSection from './echo_components/ConclusionsSection';
import LeftAtriumSection from './echo_components/LeftAtriumSection';
import LeftVentricleSection from './echo_components/LeftVentricleSection';
import MitralValveSection from './echo_components/MitralValveSection';
import PericardiumSection from './echo_components/PericardiumSection';
import PulmonicValveSection from './echo_components/PulmonicValveSection';
import RightAtriumSection from './echo_components/RightAtriumSection';
import RightVentricleSection from './echo_components/RightVentricleSection';
import TricuspidSection from './echo_components/TricuspidSection';

export default {
  name: 'VisitEchoViewV2',
  components: {
    AlertArea,
    ConclusionsSection,
    PericardiumSection,
    TricuspidSection,
    PulmonicValveSection,
    RightAtriumSection,
    RightVentricleSection,
    AortaSection,
    AorticValveSection,
    MitralValveSection,
    LeftAtriumSection,
    TheLoading,
    LeftVentricleSection,
    ModalWindow,
  },
  data() {
    return {

      loaded: false,
      modalAddVisible: false,

      echoRemarkToAdd: {
        value: '',
        type: '',
        typeLabel: '',
      },

      selectedRemarks: {
        'LEFT_VENTRICLE': 0,
        'LEFT_ATRIUM': 0,
        'MITRAL_VALVE': 0,
        'AORTIC_VALVE': 0,
        'AORTA': 0,
        'RIGHT_VENTRICLE': 0,
        'RIGHT_ATRIUM': 0,
        'PULMONIC_VALVE': 0,
        'TRICUSPID': 0,
        'PERICARDIUM': 0,
        'CONCLUSION': 0,
      },

      echoRemarksTypes: {
        'LEFT_VENTRICLE': 'Left Ventricle',
        'LEFT_ATRIUM': 'Left Atrium',
        'MITRAL_VALVE': 'Mitral Valve',
        'AORTIC_VALVE': 'Aortic Valve',
        'AORTA': 'Aorta',
        'RIGHT_VENTRICLE': 'Right Ventricle / Pulmonary Artery',
        'RIGHT_ATRIUM': 'Right Atrium',
        'PULMONIC_VALVE': 'Pulmonic Valve',
        'TRICUSPID': 'Tricuspid',
        'PERICARDIUM': 'Pericardium',
        'CONCLUSION': 'Conclusion',
      },

      updated: false,

    };
  },

  computed: {

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },

    allEchoRemarks: function () {
      return this.$store.getters.getEchoRemarks;
    },

    visitEchoRemarks: function () {
      return this.$store.getters.getVisitEchoRemarks;
    },


  },


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

    async onUpdate() {

      try {

        await this.$store.dispatch( 'visitEcho_update', this.visitEcho );
        this.setAsUpdated();
      } catch ( e ) {
        errorMessageBox( 'Failed to update echocardiogram details' );
      }

    }, /* update */


    async onAddRemark() {
      try {

        const params = {
          type: this.echoRemarkToAdd.type,
          value: this.echoRemarkToAdd.value,
        };

        await this.$store.dispatch( 'echo_addEchoRemark', params );
        await this.$store.dispatch( 'echo_fetchAllRemarks' );

        this.modalAddVisible = false;

      } catch ( e ) {
        errorMessageBox( 'Failed to add new echo remark item' );
      }
    },

    async onInsert( type ) {

      try {

        const index = this.selectedRemarks[ type ];
        const item = this.allEchoRemarks[ type ][ index ];

        const params = {
          visit_id: this.visitId,
          echo_value_id: item.id,
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

    async onDelete( item ) {

      try {
        await this.$store.dispatch( 'echo_deleteVisitRemark', item.id );

      } catch ( e ) {
        errorMessageBox( 'Failed to delete selected remark item' );
      }

      try {
        await this.$store.dispatch( 'echo_fetchAllVisitRemarks', this.visitId );
      } catch ( e ) {
        errorMessageBox( 'Failed to fetch remarks' );
      }

    },

    /*
     * On opening add modal
     * */
    onOpenAddModal( type ) {
      this.echoRemarkToAdd.type = type;
      this.echoRemarkToAdd.typeLabel = this.echoRemarksTypes[ type ];
      this.modalAddVisible = true;
    },

    /*
     * check if theres items in the echo remarks
     * */
    hasRemarks( group ) {
      return !!_.isEmpty( this.allEchoRemarks[ group ] );
    },

    setAsUpdated() {
      this.updated = true;

      setTimeout( () => {
        this.updated = false;
      }, 3500 );
    },

  },

};
</script>

<style scoped>

</style>
