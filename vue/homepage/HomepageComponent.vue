<template>

  <div>

    <div class="container-fluid">

      <div class="row">


        <div class="col-12 col-md-9 order-md-6 order-0">

          <div class="text-right">
            <h2>Welcome, Admin Bala</h2>
            <p class="lead">Today is {{ today }}</p>
          </div>

        </div><!-- col -->


        <div class="col-12 col-md-3 order-md-0 order-6">
          <div class="card">

            <div class="card-header">System Information</div>
            <div class="card-body p-2">

              <div class="">
                <table class="table table-bordered table-sm">
                  <tbody>
                  <tr>
                    <td><a href="/bookstore/books/manage.php">Books</a></td>
                    <td>{{ basicInformation.books_count }}</td>
                  </tr>
                  <tr>
                  <tr>
                    <td><a href="/bookstore/subjects/manage.php">Subjects</a></td>
                    <td>{{ basicInformation.subjects_count }}</td>
                  </tr>
                  <tr>
                    <td><a href="/bookstore/supplier/manage.php">Suppliers</a></td>
                    <td>{{ basicInformation.suppliers_count }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>

            </div>

          </div><!-- card -->
        </div><!-- col -->


      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>
import {DateTime} from "luxon";

export default {
  name: "HomepageComponent",

  data() {
    return {
      basicInformation: {
        books_count: 0,
        subjects_count: 0,
        suppliers_count: 0,
      },

      today: DateTime.local().toISODate()
    }
  },

  computed: {
    name() {
      return this.data;
    }
  },

  mounted() {

    this.fetchBasicInformation();

  },

  methods: {

    fetchBasicInformation: function () {
      $.get(`${getSiteURL()}/api/get/analytics.php`)
          .done(r => {
            this.basicInformation = r.data;
          })
          .fail(e => {
            console.log(e);
          })
    }

  },
}
</script>

<style scoped>

</style>