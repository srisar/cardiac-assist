<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Add a symptom</div>
      <div class="card-body">

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Symptom name</label>
              <input type="text" class="form-control" v-model.trim="symptom.symptom_name">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row">
          <div class="col">
            <RichEditor ref="richEditor" v-model="symptom.description"/>
          </div>
        </div>

        <div class="form-row my-2">
          <div class="col text-center">
            <button class="btn btn-success" @click="onClickSave">Save</button>
          </div>
        </div>
      </div>
    </div><!-- card -->


  </div><!-- template -->

</template>

<script>

import RichEditor from "../_common/components/RichEditor";

export default {
  name: "SaveSymptom",
  components: {RichEditor,},

  props: ['eventBus'],

  data() {
    return {

      symptom: {
        symptom_name: "",
        description: "",
      },
    }
  },

  computed: {
    //
  },

  mounted() {
    //
  },

  methods: {
    //

    onClickSave: function () {

      $.post(`${getSiteURL()}/api/save/symptom.php`, {
        symptom_name: this.symptom.symptom_name,
        description: this.symptom.description,
      }).done(r => {

        console.log(r);

        this.symptom.symptom_name = "";
        this.symptom.description = "";

        this.$refs.richEditor.cleanText();
        this.eventBus.$emit('symptom-saved');

      }).fail(e => {

      });

    },

  },

}
</script>

<style scoped>

</style>
