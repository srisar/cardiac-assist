<template>

  <div class="">

    <div class="container">
      <div class="row">
        <div class="col">

          <div class="mb-2 text-center">
            <h4>Echocardiography remark values</h4>
            <p>These values can be added to patient's visit echocardiography report.</p>
            <div class="alert alert-warning">
              <img src="/assets/images/actions/warning.svg" class="icon-24" alt="">
              Updating or deleting any of the remark value here will be reflected on all visit reports. Deleting will remove that remark
              from all the patients' report.
            </div>
          </div>

          <div class="card shadow-sm shadow mb-3" v-for="(items, key) in allValues">

            <div class="card-header d-flex justify-content-between">
              <div>{{ echoValueTypes[key] }}</div>
            </div>

            <div class="card-body">

              <div class="mb-2">
                <button class="btn btn-sm btn-outline-success" @click="onOpenAddModal(key)">
                  <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
                </button>
              </div>

              <table class="table table-sm table-bordered table-hover">

                <tbody>
                <tr v-for="item in items">
                  <td style="white-space: pre-line">
                    <span>{{ item.value }}</span>
                  </td>
                  <td style="width: 30px">
                    <div v-if="item.fillable === 'Y'" class="text-center">✔</div>
                  </td>
                  <td class="text-center" style="width: 80px">
                    <button type="button" class="btn btn-outline-secondary btn-tiny" @click="onOpenEditModal(item)">
                      <img src="/assets/images/actions/edit.svg" class="icon-16" alt="">

                    </button>
                    <button type="button" class="btn btn-outline-danger btn-tiny" @click="onDelete(item)">
                      <img src="/assets/images/actions/remove.svg" class="icon-16" alt="">

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

      <div>
        <div>Add to default fillable button?</div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="edit_fillable" id="edit_fillable_no" value="N" checked v-model="valueToEdit.fillable">
          <label class="form-check-label" for="edit_fillable_no">
            No
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="edit_fillable" id="edit_fillable_yes" value="Y" v-model="valueToEdit.fillable">
          <label class="form-check-label" for="edit_fillable_yes">
            Yes
          </label>
        </div>
      </div>

      <div class="text-center">
        <button class="btn btn-success" @click="onUpdate()">
          <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Update
        </button>
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
          <button class="btn btn-success" @click="onAdd()" :disabled="echoRemarkToAdd.value === ''">
            <img src="/assets/images/actions/save.svg" class="icon-24" alt=""> Save
          </button>
        </div>

      </slot>
    </ModalWindow>


  </div><!-- template -->

</template>

<script>


import ModalWindow from '../../_common/components/ModalWindow';

export default {
  name: 'EchoRemarks',

  components: {ModalWindow},

  data() {
    return {

      modalEditVisible: false,
      modalAddVisible: false,

      echoRemarkToAdd: {
        value: '',
        type: 'AORTA',
        typeLabel: '',
        fillable: 'N'
      },

      valueToEdit: {
        value: '',
        id: undefined,
        fillable: 'N'
      }

    };
  },

  computed: {
    echoValueTypes: function () {
      return this.$store.getters.getEchoValueTypes;
    },

    allValues: function () {
      return this.$store.getters.getEchoValues;
    }

  },

  async mounted() {

    try {
      await this.$store.dispatch('FETCH_ALL');
    } catch (e) {
      console.log(e);
    }

  },


  methods: {

    onOpenEditModal: function (item) {

      this.valueToEdit.id = item.id;
      this.valueToEdit.value = item.value;

      this.modalEditVisible = true;

    },

    onUpdate: function () {

      let item = {
        value: this.valueToEdit.value,
        id: this.valueToEdit.id,
        fillable: this.valueToEdit.fillable,
      };

      this.$store.dispatch('UPDATE', item)
          .then(() => {
            this.modalEditVisible = false;
          });

    },

    onAdd() {

      const params = {
        value: this.echoRemarkToAdd.value,
        type: this.echoRemarkToAdd.type
      };

      this.$store.dispatch('SAVE', params).then();

    },

    onDelete: function (item) {

      this.$store.dispatch('DELETE', item.id)
          .then();

    },

    onOpenAddModal(type) {

      this.echoRemarkToAdd.type = type;
      this.echoRemarkToAdd.typeLabel = this.echoValueTypes[type];

      this.modalAddVisible = true;

    },


  },

};
</script>

<style scoped>

</style>
