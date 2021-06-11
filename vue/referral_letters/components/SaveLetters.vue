<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">Add a new letter</div>
    <div class="card-body">

      <div class="">
        <div class="form-group">
          <label>Title</label>
          <input type="text" class="form-control" v-model="letter.title">
        </div>

        <div class="form-group">
          <label>Remarks</label>
          <RichEditorV2 v-model="letter.letter_model"/>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-success" :disabled="!isFormValid" @click="onSave()">Save</button>
        </div>

      </div>

    </div>
  </div>

</template>

<script>
import {errorMessageBox} from "../../_common/bootbox_dialogs";
import RichEditorV2 from "../../_common/components/RichEditorV2";

export default {
  name: "SaveLetters",
  components: {RichEditorV2},
  data() {
    return {
      letter: {
        title: "",
        letter_model: "",
      }
    }
  },

  computed: {

    isFormValid() {
      return this.letter.title !== "";
    }

  },

  mounted() {
    //
  },

  methods: {

    /*
    * On save
    * */
    async onSave() {

      try {

        const params = {
          title: this.letter.title,
          letter_model: this.letter.letter_model,
        };

        await this.$store.dispatch("letters_save", params);

      } catch (e) {
        errorMessageBox("Failed to save");
      }

      try {
        await this.$store.dispatch("letters_fetchAll");
      } catch (e) {
        errorMessageBox("Failed to fetch letter details");
      }

    },

  },

}
</script>

<style scoped>

</style>
