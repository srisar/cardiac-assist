<template>

  <div class="card shadow shadow-sm">
    <div class="card-header">Add Subject</div>
    <div class="card-body">

      <div class="form-row">
        <div class="col">

          <div class="form-group">
            <label for="field_subject">Subject</label>
            <input type="text" class="form-control" id="field_subject" v-model="subjectName">
          </div>

          <div class="text-center">
            <button type="button" class="btn btn-success" :disabled="!isValid" @click="save">Save</button>
          </div>

        </div>
      </div>

    </div>

  </div><!--card-->

</template>

<script>
export default {
  name: "AddSubject",
  props: ['eventBus'],

  data: function () {
    return {
      subjectName: '',
    };
  },

  computed: {
    isValid: function () {
      return this.subjectName !== '';
    }
  },

  mounted: function () {
    //
  },

  methods: {

    save: function () {

      $.post(`${getSiteURL()}/api/save/subject.php`, {
        subject_name: this.subjectName
      }).done(response => {

        this.eventBus.$emit('subject-saved');

      }).fail(error => {
        alert(error.responseJSON.message);
      });


    },

  }
}
</script>

<style scoped>

</style>
