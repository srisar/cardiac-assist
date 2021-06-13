<template>

  <div>

    <div class="card shadow shadow-sm" v-if="selectedLetter">

      <div class="card-header">{{ selectedLetter.title }}</div>

      <div class="card-body">

        <div class="form-group">
          <label>Title</label>
          <input type="text" class="form-control" v-model="selectedLetter.title">
        </div>

        <div class="form-group">
          <label>Letter</label>
          <RichEditorV2 v-model="selectedLetter.letter"/>
        </div>

        <div class="d-flex justify-content-between">
          <div>
            <button class="btn btn-success" @click="onUpdate()">Update</button>
            <button class="btn btn-secondary">Print</button>
          </div>
          <div>
            <button class="btn btn-danger">Delete</button>
          </div>
        </div>

      </div>

    </div><!-- card -->
  </div><!-- template -->

</template>

<script>
import {errorMessageBox, successMessageBox} from "../../../../_common/bootbox_dialogs";
import RichEditorV2 from "../../../../_common/components/RichEditorV2";

export default {
  name: "EditReferralLetter",
  components: {RichEditorV2},
  data() {
    return {
      //
    }
  },

  computed: {

    selectedLetter() {
      return this.$store.getters.getSelectedVisitLetter;
    }

  },

  async mounted() {

    try {

      const id = this.$route.params.id;
      await this.$store.dispatch("visitLetters_fetch", id);

    } catch (e) {
      errorMessageBox("Failed to fetch the referral letter");
    }

  },

  methods: {

    async onUpdate() {

      try {

        const params = {
          id: this.selectedLetter.id,
          title: this.selectedLetter.title,
          letter: this.selectedLetter.letter
        };

        await this.$store.dispatch("visitLetters_update", params);
        successMessageBox("Letter updated");

      } catch (e) {
        errorMessageBox("Failed to update the letter");
      }

    },

  },
}
</script>

<style scoped>

</style>
