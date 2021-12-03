<template>

  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-6">
          <!-- list problems -->

          <div class="card shadow shadow-sm">
            <div class="card-header d-flex justify-content-between">
              <div>Problems</div>
              <div>
                <router-link class="btn btn-tiny btn-outline-success" to="/add">
                  <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
                </router-link>
              </div>
            </div>

            <div class="card-body">

              <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr>
                  <th>All Problems</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in problemsList" :key="item.id">
                  <td class="text-left">
                    <router-link :to="'/edit/' + item.id">{{ item.problem }}</router-link>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>

          </div>

        </div>


        <div class="col-12 col-md-6 mb-2">
          <router-view></router-view>
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>
import {errorMessageBox} from '../_common/bootbox_dialogs';

export default {
  name: 'ManageProblems',

  data() {
    return {

      filterText: '',

    };
  },

  computed: {

    problemsList() {
      return this.$store.getters.getProblems;
    },

  },

  async mounted() {

    try {

      await this.$store.dispatch( 'problems_fetchAll' );

    } catch ( e ) {
      errorMessageBox( 'Failed to fetch problems' );
    }

    this.$nextTick( () => {

      new DataTable( '.table', {
        responsive: true,
        info: true,
        paging: false,
        scrollY: 500,
        language: {
          search: '',
          searchPlaceholder: 'Filter problems...',
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
