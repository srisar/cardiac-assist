<template>

  <div class="">

    <div class="container">
      <div class="row">
        <div class="col">

          <div class="mb-2 text-center">
            <h4>Echocardiography remark values</h4>
            <p>These values can be added to patient's visit echocardiography report.</p>
            <div class="alert alert-warning">
              <i class="bi bi-info-circle"></i>
              Updating or deleting any of the remark value here will be reflected on all visit reports. Deleting will remove that remark
              from all the patients' report.
            </div>
          </div>

          <div class="card shadow-sm shadow mb-3" v-for="(items, key) in allValues">

            <div class="card-header d-flex justify-content-between">
              <div>{{ echoValueTypes[ key ] }}</div>

            </div>

            <div class="card-body">

              <div class="mb-2">
                <button class="btn btn-sm btn-outline-dark" @click="onOpenAddModal(key)">
                  <img src="/assets/images/actions/add.svg" class="icon-16" alt="">
                  Add
                </button>
              </div>

              <table class="table table-sm table-bordered table-hover">

                <tbody>
                <tr v-for="item in items">
                  <td style="white-space: pre-line">{{ item.value }}</td>

                  <td class="text-center" style="width: 150px">
                    <button type="button" class="btn btn-outline-dark btn-tiny" @click="onOpenEditModal(item)">
                      <img src="/assets/images/actions/edit.svg" class="icon-16" alt="">
                      Edit
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-tiny" @click="onDelete(item)">
                      <img src="/assets/images/actions/remove.svg" class="icon-16" alt="">
                      Delete
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
          </div>


        </div><!-- col -->
      </div><!-- row -->
    </div>


    <!-- --------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <!-- EDIT Modal -->
    <ModalWindow :visible="modalEditVisible" @close="modalEditVisible= false">

      <template v-slot:title>Edit Value</template>

      <div class="form-group">
        <textarea class="form-control" rows="4" v-model="valueToEdit.value"></textarea>
      </div>

      <div class="text-center">
        <button class="btn btn-success" @click="onUpdate()">Update</button>
      </div>

    </ModalWindow>


    <!-- --------------------------------------------------------------------------------------------------------------------------------------------------- -->

    <ModalWindow :visible="modalAddVisible" @close="modalAddVisible = false">
      <template v-slot:title>Add new remark for {{ echoRemarkToAdd.typeLabel }}</template>
      <slot>

        <div class="form-group">
          <label>Type</label>
          <input type="text" class="form-control" readonly v-model="echoRemarkToAdd.typeLabel">
        </div>

        <div class="form-group">
          <label>Value</label>
          <textarea class="form-control" rows="3" v-model.trim="echoRemarkToAdd.value"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAdd()" :disabled="echoRemarkToAdd.value === ''">Add</button>
        </div>

      </slot>
    </ModalWindow>


  </div><!-- template -->

</template>

<script>


import ModalWindow from "../../_common/components/ModalWindow";

export default {
  name: "EchoRemarks",

  components: { ModalWindow },

  data() {
    return {

      modalEditVisible: false,
      modalAddVisible: false,

      echoRemarkToAdd: {
        value: "",
        type: "AORTA",
        typeLabel: "",
      },

      valueToEdit: {
        value: "",
        id: undefined,
      }

    }
  },

  computed: {
    echoValueTypes: function () {
      return this.$store.getters.getEchoValueTypes
    },

    allValues: function () {
      return this.$store.getters.getEchoValues
    }

  },

  mounted() {

    this.$store.dispatch( 'FETCH_ALL' );

  },


  methods: {

    onOpenEditModal: function ( item ) {

      this.valueToEdit.id = item.id;
      this.valueToEdit.value = item.value;

      this.modalEditVisible = true;

    },

    onUpdate: function () {

      let item = {
        value: this.valueToEdit.value,
        id: this.valueToEdit.id
      };

      this.$store.dispatch( 'UPDATE', item )
          .then( () => {
            this.modalEditVisible = false;
          } );

    },

    onAdd() {

      const params = {
        value: this.echoRemarkToAdd.value,
        type: this.echoRemarkToAdd.type
      }

      this.$store.dispatch( 'SAVE', params ).then()

    },

    onDelete: function ( item ) {

      this.$store.dispatch( 'DELETE', item.id )
          .then()

    },

    onOpenAddModal( type ) {

      this.echoRemarkToAdd.type = type;
      this.echoRemarkToAdd.typeLabel = this.echoValueTypes[ type ];

      this.modalAddVisible = true;

    },


  },

}
</script>

<style scoped>

</style>
