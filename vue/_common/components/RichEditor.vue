<template>
  <div class="ck_editor">
    <textarea ref="richEditor"></textarea>
  </div>
</template>

<script>

const _ = require('lodash');

export default {
  name: "RichEditor",

  props: ['data'],

  data: function () {
    return {
      editorInstance: undefined,
      content: this.data,
    }
  },

  watch: {

    data: function (value) {
      this.setData(value)
    }

  },

  computed: {},

  mounted: function () {

    ClassicEditor.create(this.$refs.richEditor, {
      toolbar: {
        items: [
          'heading',
          '|',
          'bold',
          'italic',
          'underline',
          'link',
          'bulletedList',
          'numberedList',
          'horizontalLine',
          '|',
          'fontColor',
          'fontBackgroundColor',
          'highlight',
          '|',
          'alignment',
          'indent',
          'outdent',
          '|',
          'CKFinder',
          'imageInsert',
          'insertTable',
          'mediaEmbed',
          'undo',
          'redo'
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
      },
    }).then(editor => {
      this.editorInstance = editor;

      if (this.data) {
        this.editorInstance.setData(this.data);
      }

      // add event listener to capture the data
      editor.model.document.on('change', _.debounce(() => {
        this.$emit('input', this.editorInstance.getData());
      }, 150));

    }).catch(error => {
      console.error('Oops, something went wrong!');
      console.error(error);
    });

  },

  methods: {

    emptyData: function () {
      this.editorInstance.setData('');
    },

    getData: function () {
      return this.editorInstance.getData();
    },

    setData: function (data) {
      this.editorInstance.setData(data);
    }


  }
}
</script>

<style scoped>

</style>
