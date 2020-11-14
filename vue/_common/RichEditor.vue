<template>
  <div class="ck_editor">
    <textarea ref="richEditor"></textarea>
  </div>
</template>

<script>
export default {
  name: "RichEditor",

  props: {
    content: "",
  },

  data: function () {
    return {
      editor: null,
      editorData: this.content,
    }
  },

  computed: {},

  watch: {
    content: function (data) {
      this.editor.setData(data);
    }
  },

  mounted: function () {

    ClassicEditor
        .create(this.$refs.richEditor, {
          toolbar: {
            items: [
              'heading',
              '|',
              'bold',
              'italic',
              'highlight',
              'blockQuote',
              'bulletedList',
              'numberedList',
              '|',
              'indent',
              'outdent',
              '|',
              'link',
              'imageInsert',
              'insertTable',
              'mediaEmbed'
            ]
          },
          language: 'en',
          image: {
            toolbar: [
              'imageTextAlternative',
              'imageStyle:full',
              'imageStyle:side'
            ]
          },
          table: {
            contentToolbar: [
              'tableColumn',
              'tableRow',
              'mergeTableCells'
            ]
          },
          licenseKey: '',
        })
        .then(newEditor => {
          this.editor = newEditor;

          this.editor.setData(this.content);

          // add event listener to capture the data
          newEditor.model.document.on('change', _.debounce(() => {
            this.$emit('content-updated', this.editor.getData());

            this.editorData = this.editor.getData();

          }, 300));


        })
        .catch(error => {
          console.log(error);
        });


  },

  methods: {}
}
</script>

<style scoped>

</style>