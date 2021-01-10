<template>

  <div>
    <ModalWindow ref="modalWindow" id="modal-view-selected-symptom" expanded="true" @modal-hiding="onModalHide">
      <template v-slot:title>
        <button class="btn btn-tiny btn-primary" @click="onClickEdit">{{ buttonText }}</button>
        {{ selectedSymptom.symptom_name }}
      </template>
      <slot>
        <div v-if="!editable">
          <div class="content-description" v-html="selectedSymptom.description"></div>
        </div>
        <div v-else>

          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Symptom name</label>
                <input type="text" class="form-control" v-model="selectedSymptom.symptom_name">
              </div>
            </div>
          </div><!-- row -->

          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label>Description</label>
                <RichEditor v-model="selectedSymptom.description"/>
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
import ModalWindow from "../_common/components/ModalWindow";

export default {
  name: "SelectedSymptomModal",
  components: {ModalWindow, RichEditor},

  props: ['symptom', 'eventBus'],

  data() {
    return {
      selectedSymptom: {
        id: "",
        symptom_name: "",
        description: "",
      },

      editable: false,
      buttonText: 'Edit',

    }
  },

  watch: {
    symptom(newValue) {
      if (newValue != null) {
        this.selectedSymptom = newValue;
      }
    }
  },

  computed: {
    //
  },

  mounted() {
    //

    this.eventBus.$on('edit-modal-open', () => {
      this.$refs.modalWindow.show();
    });

  },

  methods: {
    //

    onModalHide: function () {
      this.cleanSelectedSymptom();
      this.editable = false;
      this.buttonText = 'Edit';
      this.eventBus.$emit('edit-modal-close');
    },

    onClickEdit: function () {
      this.editable = !this.editable;
      if (this.editable) this.buttonText = 'View';
      else this.buttonText = 'Edit';
    },

    onClickUpdate: function () {
      $.post(`${getSiteURL()}/api/update/symptom.php`, {
        id: this.selectedSymptom.id,
        symptom_name: this.selectedSymptom.symptom_name,
        description: this.selectedSymptom.description,
      }).done(r => {

        alert(this.symptom.symptom_name + ' updated');

      }).fail(e => {

      });
    },

    /*
    * PRIVATE METHODS
    * */

    cleanSelectedSymptom: function () {
      this.selectedSymptom = {
        id: "",
        symptom_name: "",
        description: "",
      };
    },

  },

}
</script>

<style scoped lang="scss">


</style>
