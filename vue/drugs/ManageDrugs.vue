<template>

  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-4">
          <!-- list drugs -->

          <div class="card shadow shadow-sm">
            <div class="card-header d-flex justify-content-between">
              <div>Drugs</div>
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
                  <th>All Drugs</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="drug in drugsList" :key="drug.id">
                  <td class="text-left">
                    <router-link :to="'/edit/' + drug.id">{{ drug.drug_name }}</router-link>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>

          </div>

        </div>


        <div class="col-12 col-md-8 mb-2">
          <router-view></router-view>
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

export default {
  name: 'ManageDrugs',
  components: {},
  data() {
    return {

      filterText: '',

    };
  },

  computed: {

    drugsList() {
      return this.$store.getters.getDrugs;
    },

    // filteredDrugsList() {
    //
    //   const filteredTextUpper = _.upperCase( this.filterText );
    //
    //   return _.filter( this.drugsList, ( obj ) => {
    //     const drugName = _.upperCase( obj.drug_name );
    //
    //     if ( drugName.includes( filteredTextUpper ) ) return obj;
    //   } );
    //
    // },

  },

  async mounted() {

    try {

      await this.$store.dispatch( 'drugs_fetchAll' );

    } catch ( e ) {
      console.log( e );
    }

    this.$nextTick( () => {

      new DataTable( '.table', {
        responsive: true,
        info: true,
        paging: false,
        scrollY: 500,
        language: {
          search: '',
          searchPlaceholder: 'Filter drugs...',
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
