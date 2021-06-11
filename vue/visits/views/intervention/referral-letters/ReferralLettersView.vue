<template>

  <div>

    <div class="card shadow shadow-sm mb-3">

      <div class="card-header">Referral Letters</div>
      <div class="card-body">

        <div class="form-row mb-2">
          <div class="col">

            <div class="form-group">
              <label>Letter model</label>
              <select class="custom-select" v-model="selectedModelId">
                <option value="-1" disabled selected>CHOOSE ONE</option>
                <option v-for="(item, index) in letterModels" :value="index">{{ item.title }}</option>
              </select>
            </div>

            <div class="text-center">
              <button class="btn btn-success" :disabled="selectedModelId === '-1'" @click="onChoose()">Choose</button>
            </div>

          </div>
        </div><!-- row -->

        <div class="row mb-2" v-if="selectedLetterToAdd">
          <div class="col">

            <RichEditorV2 v-model="selectedLetterToAdd"/>

            <div class="alert alert-secondary my-2">

              <div class="row my-2">
                <div class="col">

                  <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" class="form-control" v-model.trim="fields.doctorName" placeholder="Doctor's name">
                  </div>

                  <div class="form-group">
                    <label>Address</label>
                    <!--                    <RichEditorV2 v-model="fields.address"/>-->
                    <textarea rows="3" v-model="fields.address" class="form-control" placeholder="Doctor's address"></textarea>
                  </div>

                  <div class="text-center">
                    <button class="btn btn-success" :disabled="selectedModelId === '-1'" @click="onUpdateValues()">Update Letter Model</button>
                  </div>

                </div>
              </div>

            </div>

          </div>
        </div>


      </div>
    </div><!-- card -->

  </div>

</template>

<script>
import RichEditorV2 from "../../../../_common/components/RichEditorV2";
import {errorMessageBox} from "../../../../_common/bootbox_dialogs";

import voca from "voca";

export default {
  name: "ReferralLettersView",
  components: {RichEditorV2},
  data() {
    return {

      selectedModelId: "-1",
      selectedLetterToAdd: "",

      fields: {
        doctorName: "",
        address: "",
        symptoms: "",
        treatments: "",
      }

    }
  },

  computed: {

    visit() {
      return this.$store.getters.getVisit;
    },

    patient() {
      return this.visit.patient;
    },

    letterModels() {
      return this.$store.getters.getLetterModels;
    },

    selectedLetterModel() {
      return this.letterModels[this.selectedModelId];
    }

  },

  async mounted() {

    /* fetch all letter models */
    try {
      await this.$store.dispatch("visitLetters_fetchAllModels");
    } catch (e) {
      errorMessageBox("Failed to fetch letter models");
    }


  },

  methods: {

    onChoose() {

      const today = moment().format("YYYY-MM-DD");
      let pronounStart = "He";
      let pronoun = "he";
      let pronounPossessiveStart = "His";
      let pronounPossessive = "his";

      if (this.patient.gender === "FEMALE") {
        pronoun = "she";
        pronounStart = "She";
        pronounPossessive = "her";
        pronounPossessiveStart = "Her";
      }

      let temp = this.selectedLetterModel.letter_model;

      temp = voca.replaceAll(temp, "{DATE}", today);
      temp = voca.replaceAll(temp, "{PATIENT_NAME}", `${this.patient.first_name} ${this.patient.last_name}`);
      temp = voca.replaceAll(temp, "{PRONOUN}", pronoun);
      temp = voca.replaceAll(temp, "{PRONOUN|START}", pronounStart);
      temp = voca.replaceAll(temp, "{PRONOUN|POSSESSIVE}", pronounPossessive);
      temp = voca.replaceAll(temp, "{PRONOUN|POSSESSIVE|START}", pronounPossessiveStart);

      this.selectedLetterToAdd = temp;

    },

    onUpdateValues() {
      let temp = this.selectedLetterToAdd;

      /* add doctor name */
      if (!voca.isEmpty(this.fields.doctorName)) {
        temp = voca.replaceAll(temp, "{DR_NAME}", this.fields.doctorName);
      }

      /* add doctor address */
      if (!voca.isEmpty(this.fields.address)) {

        temp = voca.replaceAll(temp, "{ADDRESS}", voca.replaceAll(this.fields.address, "\n", "<br>"));
      }

      this.selectedLetterToAdd = temp;

    }

  },

}
</script>

<style scoped>

</style>
