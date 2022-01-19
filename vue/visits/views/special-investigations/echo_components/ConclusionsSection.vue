<template>
  <!-- section: Conclusions -->
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
      <div>Conclusions</div>
      <div>
        <button class="btn btn-tiny btn-outline-warning" @click="visible = !visible">
          <img :src="showHideIcon" class="icon-16" alt="">
        </button>
      </div>
    </div>
    <div class="card-body" v-if="visible">


      <!-- add remarks -->
      <div class="alert alert-warning p-1 m-0">

        <div class="font-weight-bold mb-2">Remarks</div>


        <AutoCompleteTextBox
            search-dispatch-name="echo_searchConclusionRemarks"
            add-dispatch-name="echo_addConclusionRemark"
            field-name="value"
            v-model="remarkToAdd"
            @input="onAdd"
        />

        <div class="mb-2">
          <button class="btn btn-tiny btn-dark" @click="onAddDefaultRemarks()">Add Defaults</button>
        </div>


        <table class="table table-bordered table-sm table-hover m-0">
          <tbody>
          <tr v-for="item in visitEchoRemarks.CONCLUSION">
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
  <!-- section: Conclusions -->
</template>

<script>
import {errorMessageBox} from '@/_common/bootbox_dialogs.js';
import AutoCompleteTextBox from '@/visits/views/components/AutoCompleteTextBox.vue';
import {sectionMixins} from './sections_mixins';
import _ from 'lodash';

export default {
  name: 'ConclusionsSection',
  components: {AutoCompleteTextBox},
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

  computed: {
    fillableRemarks() {
      return _.filter(this.allEchoRemarks['CONCLUSION'], {'fillable': 'Y'});
    }
  },

  methods: {

    async onAdd() {
      try {

        const id = this.remarkToAdd['id'];

        const params = {
          visit_id: this.visitId,
          echo_value_id: id,
        };

        await this.$store.dispatch('echo_addVisitRemark', params);

      } catch (e) {
        errorMessageBox('Failed to insert the remark');
      }

      /* fetch all visit echo remarks again */
      try {
        await this.$store.dispatch('echo_fetchAllVisitRemarks', this.visitId);
      } catch (e) {
        errorMessageBox('Failed to fetch remarks');
      }
    },

    async onAddDefaultRemarks() {

      try {

        for (const item of this.fillableRemarks) {

          const params = {
            visit_id: this.visitId,
            echo_value_id: item['id'],
          };

          await this.$store.dispatch('echo_addVisitRemark', params);
        }

      } catch (e) {

      } finally {
        /* fetch all visit echo remarks again */
        try {
          await this.$store.dispatch('echo_fetchAllVisitRemarks', this.visitId);
        } catch (e) {
          errorMessageBox('Failed to fetch remarks');
        }
      }

    }, /* onAddDefaultRemarks */

  },


};
</script>

<style scoped>

</style>
