<template>

  <div>

    <ModalWindow ref="modalAddVisitSymptom"
                 id="modal-add-visit-symptom"
                 :visible="modalVisible"
                 @modal-hiding="onModalHiding">

      <template v-slot:title>Add a symptom</template>

      <slot>

        <div class="row">
          <div class="col">

            <div class="input-group">

              <select class="form-control" v-model="selectedSymptom">
                <option value="-1" disabled>SELECT</option>
                <option v-for="item in symptomsList" :value="item">{{ item.symptom_name }}</option>
              </select>

              <div class="input-group-append">
                <button class="btn btn-success" @click="onClickAdd">Add</button>
              </div>
            </div>

          </div><!-- col -->
        </div><!-- row -->

      </slot>

    </ModalWindow>

  </div>

</template>

<script>

import ModalWindow from "../../_common/components/ModalWindow";

export default {
  name: "AddVisitSymptom",
  components: {ModalWindow,},

  data() {
    return {
      selectedSymptom: "-1",
    }
  },

  computed: {
    modalVisible: function () {
      return this.$store.getters.getModalVisibleState;
    },

    symptomsList: function () {
      return this.$store.getters.getSymptomsList;
    }

  },

  mounted() {
    //
    this.$store.dispatch('fetchSymptoms');

  },

  methods: {
    //

    onModalHiding: function () {
      this.$store.commit('setAddModalVisible', false);
    },

    /*
    * Add selected symptom to the visit
    * */
    onClickAdd: function (symptom) {

    },

  },

}
</script>

<style scoped>

</style>
