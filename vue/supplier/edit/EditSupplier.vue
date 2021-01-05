<template>

  <div>

    <div class="container">

      <div class="row justify-content-center">

        <div class="col-12 col-md-8">

          <div class="card shadow shadow-sm">
            <div class="card-header">Edit Supplier:</div>
            <div class="card-body">
              <div id="add-new-supplier">

                <div class="form-row">

                  <div class="col">
                    <div class="form-group">
                      <label>Supplier Name</label>
                      <input type="text" class="form-control" v-model="supplier.supplier_name">
                    </div>

                    <div class="form-group">
                      <label>Address</label>
                      <textarea rows="5" class="form-control" v-model="supplier.address"></textarea>
                    </div>

                  </div>

                </div><!-- .row -->

                <div class="form-row">

                  <div class="col">

                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" v-model="supplier.email">
                    </div>

                  </div>

                  <div class="col">
                    <div class="form-group">
                      <label>Telephone</label>
                      <input type="text" class="form-control" v-model="supplier.telephone">
                    </div>
                  </div>

                </div><!-- .row -->

                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label>Website</label>
                      <input type="text" class="form-control" v-model="supplier.website">
                    </div>
                  </div>
                </div><!-- .row -->

                <div class="row">
                  <div class="col text-right">
                    <button class="btn btn-primary" @click="updateSupplier">Save</button>
                  </div>
                </div>

              </div><!-- #add-new-supplier -->
            </div><!-- .card -->
          </div>

        </div><!-- .col -->

      </div><!-- .row -->

    </div><!-- .container -->

  </div>


</template>

<script>
export default {
  name: "EditSupplier",
  data() {
    return {
      supplier: {
        supplier_name: "",
        address: "",
        email: "",
        telephone: "",
        website: "",
      },

      supplierId: undefined
    }
  },

  computed: {},

  mounted() {
    this.supplierId = document.getElementById("supplier-id").value;
    this.fetchSupplier();
  },

  methods: {

    fetchSupplier() {

      const url = `${getSiteURL()}/api/get/supplier.php`;
      $.get(url, {id: this.supplierId})
          .then(r => {

            console.log(r);

            this.supplier = r.supplier;
          })
          .fail(e => {
            console.log(e.responseJSON.message);
          });

    },

    updateSupplier() {

      const data = {
        id: this.supplierId,
        supplier_name: this.supplier.supplier_name,
        address: this.supplier.address,
        telephone: this.supplier.telephone,
        email: this.supplier.email,
        website: this.supplier.website,
      }

      $.post(`${getSiteURL()}/api/update/supplier.php`, data)
          .done(r => {

            redirect(`${getSiteURL()}/bookstore/supplier/manage.php`);

          })
          .fail(e => {
            alert(e.responseJSON.message);
          });

    },


  },

}
</script>

<style scoped>

</style>
