<template>

  <div>
    <div class="container">

      <div class="row">

        <div class="col">

          <div class="card shadow shadow-sm">
            <div class="card-header">Suppliers</div>
            <div class="card-body">

              <table class="table table-bordered table-striped table-sm">

                <thead>
                <tr>
                  <th>Supplier</th>
                  <th>Telephone</th>
                  <th>Email</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="supplier in suppliers">
                  <td><a :href="editURL(supplier)">{{ supplier.supplier_name }}</a></td>
                  <td>{{ supplier.telephone }}</td>
                  <td>{{ supplier.email }}</td>
                </tr>
                </tbody>

              </table>

            </div>
          </div><!-- card -->

        </div><!-- col -->

      </div><!-- .row -->

    </div><!-- .container -->
  </div>

</template>

<script>
export default {
  name: "ManageSuppliers",
  data() {
    return {
      suppliers: []
    }
  },

  computed: {},

  mounted() {
    // fetch all suppliers
    this.fetchSuppliers();
  },

  methods: {

    editURL(supplier) {
      return `${getSiteURL()}/bookstore/supplier/edit.php?id=${supplier.id}`;
    },

    fetchSuppliers() {

      const url = `${getSiteURL()}/api/get/suppliers.php`;
      $.get(url)
          .then(response => {
            this.suppliers = response.data;
          })
          .fail(error => {
            console.log(error.responseJSON.message);
          });

    }
  },

}
</script>

<style scoped>

</style>
