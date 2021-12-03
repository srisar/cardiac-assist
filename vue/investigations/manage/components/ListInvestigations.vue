<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div>Investigations</div>
        <div>
          <router-link class="btn btn-tiny btn-outline-success" to="/add">
            <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
          </router-link>
        </div>
      </div>

      <div class="card-body p-2">

        <table class="table table-sm table-bordered table-hover">
          <thead>
          <tr>
            <th>All Investigations</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in investigationsList" :key="item.id">
            <td>
              <router-link :to="'/edit/' + item.id">{{ item.investigation_name }}</router-link>
            </td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!-- card -->

  </div><!-- template -->

</template>

<script>


import {errorMessageBox} from '@/_common/bootbox_dialogs.js';

export default {
  name: 'ListInvestigations',


  data() {
    return {};
  },

  computed: {

    investigationsList() {
      return this.$store.getters.getInvestigationsList;
    },

  },

  async mounted() {

    try {

      await this.$store.dispatch( 'investigations_fetchAll' );

    } catch ( e ) {
      errorMessageBox( 'Failed to load investigations' );
    }

    this.$nextTick( () => {

      new DataTable( '.table', {
        responsive: true,
        info: true,
        paging: false,
        scrollY: 500,
        language: {
          search: '',
          searchPlaceholder: 'Filter investigations...',
        },
        dom: '<\'row\'<\'col-sm-12\'f>>' +
            '<\'row\'<\'col-sm-12\'tr>>' +
            '<\'row\'<\'col-sm-12\'i>>',
      } );

    } );

  },


};
</script>

<style scoped>

</style>
