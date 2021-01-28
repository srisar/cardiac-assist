<template>
  <div class="modal"
       :class="{'show' : isVisible, 'hide': !isVisible}"
       :id="id"
       tabindex="-1"
       role="dialog"
       :aria-labelledby="id"
       aria-hidden="true">

    <div class="modal-dialog modal-lg" :class="{'expanded': isExpanded}">
      <div class="modal-content">

        <div class="modal-header p-1">
          <h3 class="pl-2 pb-0 pt-0 pr-0 m-0">
            <slot name="title"></slot>
          </h3>


          <div>
            <button class="btn btn-tiny btn-secondary" type="button" @click="_resize">
              {{ resizeButtonIcon }}
            </button>
            <button type="button" class="btn btn-tiny btn-danger" @click="hide">
              Close
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

  props: ['id', 'expanded', 'visible'],

  data: function () {
    return {
      isVisible: false,
      isExpanded: this.expanded,

      icons: {
        expandIcon: 'Expand',
        contractIcon: 'Contract',
        closeIcon: 'bi-x',
      },

      resizeButtonIcon: 'Expand',

    };
  },

  computed: {},

  mounted() {
    //
    if (this.expanded) {
      this.resizeButtonIcon = 'bi-arrows-angle-contract';
    }
  },

  watch: {
    visible(value) {
      this.isVisible = value;
    }
  },

  methods: {


    hide: function () {
      this.isVisible = false;
      this.$emit('modal-hiding');
      this.$emit('close');
    },

    show: function () {
      this.isVisible = true;
      this.$emit('modal-showing');
      this.$emit('open');
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

.modal-header {
  background-color: #212529;
  color: whitesmoke;
  line-height: 2em;

  h3 {
    font-size: 1em;
    line-height: 2em;
    font-weight: bold;

  }

}


</style>
