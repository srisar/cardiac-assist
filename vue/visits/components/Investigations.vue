<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Investigations

        <div class="float-right" v-if="!addInvestigationPanelVisible">
          <button class="btn btn-tiny btn-success" @click="onShowAddInvestigationPanel">Add</button>
        </div>
      </div><!-- card-header -->

      <div class="card-body">

        <!-- add investigation form -->
        <div id="form-add-investigation" v-if="addInvestigationPanelVisible">

          <div class="alert alert-secondary">

            <div class="form-row">
              <div class="col">

                <div class="form-group">
                  <label>Investigation</label>
                  <input type="text" class="form-control" v-model="investigationToAdd.investigation_name">
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <RichEditor @input="getDescription"/>
                </div>

                <div class="form-group text-center">
                  <button class="btn btn-success" @click="onAddInvestigation">Add</button>
                  <button class="btn btn-secondary" @click="onHideAddInvestigationPanel">Close</button>
                </div>

              </div>
            </div><!-- row -->

          </div><!-- alert -->

        </div><!-- add investigation form -->


        <!-- investigations list -->
        <div class="my-3">
          <table class="table table-bordered table-sm">
            <thead>
            <tr>
              <th>Investigation</th>
              <th style="width: 50px" class="text-center">Description</th>
              <th style="width: 100px" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in investigationsList">
              <td>{{ item.investigation_name }}</td>
              <td class="text-center">
                <button class="btn btn-tiny btn-secondary">View</button>
              </td>
              <td class="text-center"></td>
            </tr>
            </tbody>
          </table>
        </div><!-- investigations list -->


      </div><!-- card-body -->

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>
import RichEditor from "../../_common/components/RichEditor";

const _ = require('lodash');

export default {
  name: "Investigations",
  components: {RichEditor},

  data() {
    return {
      addInvestigationPanelVisible: false,

      investigationToAdd: {
        investigation_name: "",
        description: "",
      },

    }
  },

  computed: {

    investigationsList: function () {
      return this.$store.getters.investigationsList;
    },

  },

  mounted() {
    //
  },

  methods: {


    onShowAddInvestigationPanel: function () {
      this.addInvestigationPanelVisible = true;
    },

    onHideAddInvestigationPanel: function () {
      this.addInvestigationPanelVisible = false;
    },

    getDescription: function (data) {
      this.investigationToAdd.description = data;
    },


    onAddInvestigation: function () {
      this.$store.dispatch('addInvestigation', this.investigationToAdd)
          .then(r => {

            alert('Investigation added');

            // clearing out the form
            this.investigationToAdd = {
              investigation_name: "",
              description: "",
            };

          })
          .catch(e => {
            alert('Failed to add investigation');
          })
    },

    /*
    *
    * HELPERS
    * */


  },

}
</script>

<style scoped>

</style>
