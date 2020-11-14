<template>
  <div class="card" id="form_add_symptom">
    <div class="card-header">Add a symptom</div>
    <div class="card-body">

      <div class="form-group">
        <label for="field_symptom_name">Symptom name <span class="badge badge-danger">required</span></label>
        <input type="text" id="field_symptom_name" class="form-control" v-model="symptom.symptom_name" required>
        <div class="invalid-feedback">Symptom name is required.</div>
      </div>

      <div class="form-group">
        <label>Description</label>
        <rich-editor content=""></rich-editor>
      </div>

      <div class="text-right">
        <button class="btn btn-success" @click="addSymptom">Add symptom</button>
      </div>

    </div>
  </div><!--card-->
</template>

<script>

import RichEditor from "../../_common/RichEditor";

export default {
  name: "AddSymptom",
  components: {
    RichEditor
  },
  props: {
    eventBus: undefined
  },

  data() {
    return {
      symptom: {
        symptom_name: "",
        description: "",
      },
      description: {
        editor: ClassicEditor,
        editorData: "Example text...",
        editorConfig: {}
      }
    }
  },

  computed: {
    isEmptySymptomName() {
      return _.isEmpty(this.symptom.symptom_name);
    }
  },

  mounted() {
    // init rich text input

  },

  methods: {
    addSymptom() {

      axios.post(`${getSiteUrl()}/api/symptom/add`, {
        symptom_name: this.symptom.symptom_name,
        description: this.symptom.description
      }).then(response => {

        showSuccessToast("Symptom added");
        this.emitSymptomAddedEvent();

      }).catch(error => {
        showErrorToast("Failed to add symptom");
        console.log(error.response.data);
      });

    },

    emitSymptomAddedEvent() {
      this.$emit('symptom-added');
    }
  },
}
</script>

<style scoped>

</style>