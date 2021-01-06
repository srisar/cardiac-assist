<template>
  <div class="modal"
       :class="{'show' : isVisible, 'hide': !isVisible}"
       :id="id"
       tabindex="-1"
       role="dialog"
       :aria-labelledby="id"
       aria-hidden="true">

    <div class="modal-dialog" :class="{'expanded': isExpanded}">
      <div class="modal-content">

        <div class="modal-header p-2">
          <h3 class="p-0 m-0">
            <slot name="title"></slot>
          </h3>


          <div>
            <button class="header-button" type="button" @click="_resize">
              <i class="bi" :class="resizeButtonIcon"></i>
            </button>
            <button type="button" class="header-button" @click="hide">
              <i class="bi" :class="icons.closeIcon"></i>
            </button>
          </div>


        </div><!--modal-header-->

        <div class="modal-body">

          <slot></slot>

        </div>
        <div class="modal-footer">
          <slot name="footer"></slot>
        </div>
      </div>
    </div><!--modal-dialog-->

  </div>
</template>

<script>

export default {
  name: "ModalWindow",

  props: {
    id: String,
  },

  data: function () {
    return {
      isVisible: false,
      isExpanded: false,

      icons: {
        expandIcon: 'bi-arrows-angle-expand',
        contractIcon: 'bi-arrows-angle-contract',
        closeIcon: 'bi-x',
      },

      resizeButtonIcon: 'bi-arrows-angle-expand',

    };
  },

  computed: {},

  methods: {


    hide: function () {
      this.isVisible = false;
      this.$emit('modal-hiding');
    },

    show: function () {
      this.isVisible = true;
      this.$emit('modal-showing');
    },


    _resize: function () {
      this.isExpanded = !this.isExpanded;

      if (this.isExpanded) this.resizeButtonIcon = this.icons.contractIcon;
      else this.resizeButtonIcon = this.icons.expandIcon

    },

  },

}
</script>

<style scoped lang="scss">

.modal {
  background-color: rgba(108, 117, 125, 0.5);
  overflow-y: auto;
}

.show {
  display: block;
}

.hide {
  display: none;
}


.expanded {
  max-width: 90%;
}

.header-button {
  border: solid 1px #d0d0d0;
  background-color: #f8fafc;
  padding: 2px;
  margin: 0;
  border-radius: 5px;
  width: 28px;
  height: 28px;
}

.modal-header h3 {
  font-size: 1.2em;
  line-height: 1.6em;
  font-weight: bold;
}

</style>
