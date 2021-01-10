<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Add a disease</div>
      <div class="card-body">

        <div class="form-row">

          <div class="col">
            <div class="form-group">
              <label>Disease name</label>
              <input type="text" class="form-control" v-model.trim="disease.disease">
            </div>
          </div><!-- col -->

          <div class="col">
            <div class="form-group">
              <label>Disease code</label>
              <input type="text" class="form-control" v-model.trim="disease.disease_code">
            </div>
          </div><!-- col -->

        </div><!-- row -->

        <div class="form-row">
          <div class="col">
            <RichEditor ref="richEditor" v-model="disease.description"/>
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
  name: "SaveDisease",
  components: {RichEditor,},

  props: ['eventBus'],

  data() {
    return {

      disease: {
        disease: "",
        disease_code: "",
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

      $.post(`${getSiteURL()}/api/save/disease.php`, {
        disease: this.disease.disease,
        disease_code: this.disease.disease_code,
        description: this.disease.description,
      }).done(r => {

        console.log(r);

        this.disease = {
          disease: "",
          disease_code: "",
          description: "",
        }

        this.$refs.richEditor.cleanText();
        this.eventBus.$emit('disease-save');

      }).fail(e => {

      });

    },

  },

}
</script>

<style scoped>

</style>
