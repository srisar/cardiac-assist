<template>

  <div class="container my-3">
    <div class="row">
      <div class="col">
        <h3 class="text-uppercase text-center">Common Statistics</h3>
      </div>
    </div>

    <div class="form-row justify-content-center">

      <div class="col-6">

        <div class="card">
          <div class="card-header">Most used investigations</div>
          <div class="card-body" style="height: 250px">
            <div id="chart_investigations"></div>
          </div>
        </div>

      </div><!-- col -->

      <div class="col-6">

        <div class="card">
          <div class="card-header">Most common problems</div>
          <div class="card-body" style="height: 250px">
            <div id="chart_problems"></div>
          </div>
        </div>

      </div><!-- col -->


    </div>

  </div><!-- container -->

</template>

<script>
export default {
  name: 'CommonStatsSection',

  data() {
    return {

      allStats: null,

    };
  },

  computed: {

    investigationsStats() {
      return this.allStats[ 'investigations' ];
    },

    investigationsChartData() {

      const data = {
        seriesData: [],
        labelsData: [],
      };

      if ( this.investigationsStats !== undefined ) {
        this.investigationsStats.forEach( item => {

          data.seriesData.push( parseInt( item[ 'total' ] ) );
          data.labelsData.push( item[ 'investigation' ][ 'investigation_name' ] );

        } );
      }

      return data;
    }, /* investigationsChartData */

    problemsStats() {
      return this.allStats[ 'problems' ];
    },
    problemsChartData() {
      const data = {
        seriesData: [],
        labelsData: [],
      };

      if ( this.problemsStats !== undefined ) {
        this.problemsStats.forEach( item => {

          data.seriesData.push( parseInt( item[ 'total' ] ) );
          data.labelsData.push( item[ 'problem' ][ 'problem' ] );

        } );
      }
      return data;

    }, /* problemsChartData */

  },

  async mounted() {
    try {

      this.allStats = await this.$store.dispatch( 'stats_fetchAllDiagnoses' );

    } catch ( e ) {
      console.log( e );
    }

    this.generateInvestigationsCountChart();
    this.generateProblemsCountChart();

  },

  methods: {
    //

    generateInvestigationsCountChart() {
      const options = {
        chart: {
          type: 'donut',
          fontFamily: 'Sen',
          height: '100%',
        },
        series: this.investigationsChartData.seriesData,
        labels: this.investigationsChartData.labelsData,
        chartOptions: {},
      };

      const chart = new ApexCharts( document.querySelector( '#chart_investigations' ), options );
      chart.render();
    }, /* generateInvestigationsCountChart */

    generateProblemsCountChart() {
      const options = {
        chart: {
          type: 'donut',
          fontFamily: 'Sen',
          height: '100%',
        },
        series: this.problemsChartData.seriesData,
        labels: this.problemsChartData.labelsData,
        chartOptions: {},
      };

      const chart = new ApexCharts( document.querySelector( '#chart_problems' ), options );
      chart.render();
    }, /* generateInvestigationsCountChart */

  },

};
</script>

<style scoped>

</style>
