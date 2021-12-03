<template>

  <div>

    <div class="card shadow shadow-sm">

      <div class="card-header d-flex justify-content-between">
        <div>Diseases</div>
        <div>
          <router-link class="btn btn-tiny btn-outline-success" to="/add">
            <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
          </router-link>
        </div>
      </div>
      <div class="card-body p-2">

        <table class="table table-sm table-bordered">
          <thead>
          <tr>
            <th>Code</th>
            <th>Disease</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in diseasesList">
            <td>{{ item.disease_code }}</td>
            <td>
              <router-link :to="'/edit/' + item.id">{{ item.disease }}</router-link>
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
  name: 'ListDiseases',
  components: {},

  props: [],

  data() {
    return {};
  },

  computed: {

    diseasesList() {
      return this.$store.getters.getDiseasesList;
    },

  },

  async mounted() {

    try {
      await this.$store.dispatch( 'diseases_fetchAll' );
    } catch ( e ) {
      errorMessageBox( 'Failed to get disease details' );
    }

    this.$nextTick( () => {

      new DataTable( '.table', {
        responsive: true,
        info: true,
        paging: false,
        scrollY: 500,
        language: {
          search: '',
          searchPlaceholder: 'Filter diseases...',
        },
        dom: '<\'row\'<\'col-sm-12\'f>>' +
            '<\'row\'<\'col-sm-12\'tr>>' +
            '<\'row\'<\'col-sm-12\'i>>',
      } );

    } );
  },

  methods: {},

};
</script>

<style scoped>

</style>
