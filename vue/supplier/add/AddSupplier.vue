<template>

  <div>

    <div class="container">

      <div class="row justify-content-center">

        <div class="col-12 col-md-8">

          <div class="card shadow shadow-sm">
            <div class="card-header">Add a new supplier</div>
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
                    <button class="btn btn-primary" @click="saveSupplier">Save</button>
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
  name: "AddSupplier",
  data() {
    return {
      supplier: {
        supplier_name: "",
        address: "",
        email: "",
        telephone: "",
        website: "",
      }
    }
  },
  computed: {},
  mounted() {
  },
  methods: {

    saveSupplier() {

      const url = `${getSiteURL()}/api/save/supplier.php`;
      $.post(url, {
        supplier_name: this.supplier.supplier_name,
        address: this.supplier.address,
        email: this.supplier.email,
        telephone: this.supplier.telephone,
        website: this.supplier.website,
      }).then(response => {

        console.log(response);

      }).fail(error => {
        alert(error.responseJSON.message);
      })

    },

  },
}
</script>

<style scoped>

</style>
