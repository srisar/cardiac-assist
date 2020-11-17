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
          <h3 class="">
            <slot name="title"></slot>
          </h3>


          <div>
            <button class="header-button" type="button" @click="_resize">
              <img :src="resizeButtonIcon" alt="">
            </button>
            <button type="button" class="header-button" @click="hide">
              <img :src="icons.closeIcon" alt="">
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

import closeIcon from "bootstrap-icons/icons/x.svg";
import expandIcon from "bootstrap-icons/icons/arrows-angle-expand.svg";
import contractIcon from "bootstrap-icons/icons/arrows-angle-contract.svg";


export default {
  name: "ModalWindow",

  props: {
    id: String,
    modalTitle: String

  },

  data: function () {
    return {
      isVisible: false,
      isExpanded: false,

      icons: {
        expandIcon: expandIcon,
        contractIcon: contractIcon,
        closeIcon: closeIcon,
      },

      resizeButtonIcon: expandIcon,

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

<style scoped>

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
  border-radius: 5px
}

.modal-header h3 {
  line-height: 1.5rem;
  font-weight: bold;
}

</style>