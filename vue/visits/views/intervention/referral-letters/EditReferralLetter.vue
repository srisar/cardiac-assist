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
            <button class="btn btn-success" @click="onUpdate()">
              <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
            </button>
            <router-link class="btn btn-secondary" :to="'/referral-letters/print/' + selectedLetter.id">
              <img src="/assets/images/actions/print.svg" class="icon-24" alt=""> Print Preview
            </router-link>
            <router-link class="btn btn-secondary" to="/referral-letters/">
              <img src="/assets/images/actions/back.svg" class="icon-24" alt=""> Back
            </router-link>
          </div>
          <div>
            <button class="btn btn-danger" @click="modalDeleteConfirmVisible = true">
              <img src="/assets/images/actions/remove.svg" class="icon-24" alt=""> Delete
            </button>
          </div>
        </div>

      </div>
    </div><!-- card -->


    <ModalWindow :visible="modalDeleteConfirmVisible" @close="modalDeleteConfirmVisible = false">
      <template v-slot:title>Confirm delete</template>
      <slot>

        <h3 class="text-center">Are you sure to delete?</h3>
        <div class="text-center">
          <button class="btn btn-danger" @click="onDelete()">Delete</button>
          <button class="btn btn-secondary" @click="modalDeleteConfirmVisible = false">Cancel</button>
        </div>

      </slot>
    </ModalWindow>

  </div><!-- template -->

</template>

<script>
import {errorMessageBox, successMessageBox} from "../../../../_common/bootbox_dialogs";
import RichEditorV2 from "../../../../_common/components/RichEditorV2";
import ModalWindow from "../../../../_common/components/ModalWindow";

export default {
  name: "EditReferralLetter",
  components: { ModalWindow, RichEditorV2 },
  data() {
    return {
      modalDeleteConfirmVisible: false,
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
      await this.$store.dispatch( "visitLetters_fetch", id );

    } catch ( e ) {
      errorMessageBox( "Failed to fetch the referral letter" );
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

        await this.$store.dispatch( "visitLetters_update", params );
        successMessageBox( "Letter updated" );

      } catch ( e ) {
        errorMessageBox( "Failed to update the letter" );
      }

    }, /* update */

    async onDelete() {

      try {

        await this.$store.dispatch( "visitLetters_delete", this.selectedLetter.id );

        await this.$router.push( "/referral-letters" );

      } catch ( e ) {
        errorMessageBox( "Failed to delete the letter" );
      }

    }, /* delete */

  },
}
</script>

<style scoped>

</style>
