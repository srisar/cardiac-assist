<template>
  <div class="ck_editor">
    <textarea ref="richViewer"></textarea>
  </div>
</template>

<script>

export default {
  name: "RichViewer",

  props: ['data'],

  data: function () {
    return {
      editor: undefined,
      content: this.data,
    }
  },

  watch: {
    data(newValue) {
      this.content = newValue;
      this.editor.setData(this.content)
    }
  },

  mounted: function () {
    ClassicEditor
        .create(this.$refs.richViewer)
        .then(editor => {
          this.editor = editor;
          this.editor.isReadOnly = true;

          if (this.content !== undefined) this.editor.setData(this.content);

        })
        .catch(error => {
          console.log(error.stack);
        });


  },

  methods: {}
}
</script>

<style scoped>

</style>
