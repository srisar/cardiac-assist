<template>
  <div class="ck_editor">
    <textarea ref="richEditor"></textarea>
  </div>
</template>

<script>

const _ = require('lodash');

export default {
  name: "RichEditor",

  props: ['value'],

  data: function () {
    return {
      editorInstance: undefined,
    }
  },

  // watch: {
  //   value: function (oldValue, newValue) {
  //     if (this.editorInstance !== undefined) this.editorInstance.setData(this.value);
  //   }
  // },

  mounted: function () {
    ClassicEditor.create(this.$refs.richEditor, {
      toolbar: {
        items: [
          'heading',
          '|',
          'bold',
          'italic',
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
        uploadUrl: `${getSiteURL()}/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json`,
        openerMethod: 'modal'
      }
    })
        .then(editor => {
          this.editorInstance = editor;

          if (this.value !== undefined) editor.setData(this.value);

          // add event listener to capture the data
          editor.model.document.on('change', _.debounce(() => {
            this.$emit('input', this.editorInstance.getData());
          }, 150));


        })
        .catch(error => {
          console.log(error.stack);
        });


  },

  methods: {

    init: function (data) {
      /**
       * in order to capture the initial data and display it in the editor
       */

      if (data !== null) this.editorInstance.setData(data);
      else this.editorInstance.setData('');

    }

  }
}
</script>

<style scoped>

</style>
