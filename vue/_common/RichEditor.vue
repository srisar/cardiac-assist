<template>
  <div class="ck_editor">
    <textarea ref="richEditor"></textarea>
  </div>
</template>

<script>


// import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
// import Base64UploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/base64uploadadapter';
// import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';

export default {
  name: "RichEditor",

  props: {
    value: ""
  },

  data: function () {
    return {
      editor: null,
      editorData: this.value,
    }
  },

  computed: {},

  mounted: function () {

    ClassicEditor.create(this.$refs.richEditor, {
      toolbar: {
        items: [
          'heading',
          '|',
          'fontSize',
          'fontColor',
          'bold',
          'italic',
          'highlight',
          'alignment',
          'link',
          'bulletedList',
          'numberedList',
          'ckfinder',
          'insertTable',
          '|',
          'indent',
          'outdent',
          '|',
          'blockQuote',
          'mediaEmbed',
          'undo',
          'redo',

        ]
      },
      language: 'en',
      image: {
        toolbar: [
          'imageTextAlternative',
          'imageStyle:full',
          'imageStyle:side',
          'linkImage'
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
      ckfinder: {
        uploadUrl: '/ckf/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
      }
    })
        .then(editor => {
          this.editor = editor;

          if (this.value != null) this.editor.setData(this.value);

          Array.from(editor.ui.componentFactory.names());

          // add event listener to capture the data
          editor.model.document.on('change', _.debounce(() => {
            this.$emit('input', this.editor.getData());

            this.editorData = this.editor.getData();

          }, 150));


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