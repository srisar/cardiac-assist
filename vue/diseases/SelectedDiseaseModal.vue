<template>

  <div>
    <ModalWindow ref="modalWindow" id="modal-view-selected-symptom" expanded="true" @modal-hiding="onModalHide">
      <template v-slot:title>
        <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ buttonText }}</button>
        {{ selectedDisease.disease }} ({{ selectedDisease.disease_code }})
      </template>
      <slot>
        <div v-if="!editable">
          <div class="content-description">
            <RichViewer :value="selectedDisease.description"/>
          </div>
        </div>
        <div v-else>

          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Disease name</label>
                <input type="text" class="form-control" v-model="selectedDisease.disease">
              </div>
            </div>

            <div class="col">
              <div class="form-group">
                <label>Disease code</label>
                <input type="text" class="form-control" v-model="selectedDisease.disease_code">
              </div>
            </div>

          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Description</label>
                <RichEditor v-model="selectedDisease.description"/>
              </div>
            </div>
          </div>
        </div>
      </slot>

      <template v-slot:footer v-if="editable">
        <div class="form-row my-2">
          <div class="col text-center">
            <button class="btn btn-success" @click="onClickUpdate">Update</button>
          </div>
        </div>
      </template>

    </ModalWindow>
  </div>

</template>

<script>

import RichEditor from "../_common/components/RichEditor";
import RichViewer from "../_common/components/RichViewer";
import ModalWindow from "../_common/components/ModalWindow";

export default {
  name: "SelectedDiseaseModal",
  components: {ModalWindow, RichEditor, RichViewer,},

  props: ['eventBus'],

  data() {
    return {
      selectedDisease: {
        id: "",
        disease: "",
        disease_code: "",
        description: "",
      },

      editable: false,
      buttonText: 'Edit',

    }
  },

  watch: {},

  computed: {
    //
  },

  mounted() {
    //

    this.eventBus.$on('open-view-disease-modal', (disease) => {
      this.selectedDisease = disease;
      this.$refs.modalWindow.show();
    });

  },

  methods: {
    //

    onModalHide: function () {
      this.cleanSelectedDisease();

      this.editable = false;
      this.buttonText = 'Edit';
    },

    onClickEdit: function () {
      this.editable = !this.editable;
      if (this.editable) this.buttonText = 'View';
      else this.buttonText = 'Edit';
    },

    onClickUpdate: function () {
      $.post(`${getSiteURL()}/api/update/disease.php`, {
        id: this.selectedDisease.id,
        disease: this.selectedDisease.disease,
        disease_code: this.selectedDisease.disease_code,
        description: this.selectedDisease.description,
      }).done(r => {

        alert(this.selectedDisease.disease + ' updated');

      }).fail(e => {

      });
    },

    /*
    * PRIVATE METHODS
    * */

    cleanSelectedDisease: function () {
      this.selectedDisease = {
        id: "",
        disease: "",
        disease_code: "",
        description: "",
      };
    },

  },

}
</script>

<style scoped lang="scss">


</style>
