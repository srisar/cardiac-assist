<template>

  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-4">
          <!-- list drugs -->

          <div class="card shadow shadow-sm">
            <div class="card-header d-flex justify-content-between">
              <div>Referral Letters</div>
              <div>
                <router-link class="btn btn-tiny btn-success" to="/add">Add</router-link>
              </div>
            </div>

            <div class="card-body">


              <div class="mb-3">

                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Filter drugs" v-model="filterText">
                </div>

              </div>


              <table class="table table-sm table-bordered table-hover">

                <tbody>
                <tr v-for="item in lettersList" :key="item.id">
                  <td class="text-left">
                    <router-link :to="'/edit/' + item.id">{{ item.letter_model }}</router-link>
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
  name: "ManageReferralLetters",
  components: {},
  data() {
    return {

      filterText: "",

    }
  },

  computed: {

    lettersList() {
      return this.$store.getters.getLetters;
    },

  },

  async mounted() {

    try {

      await this.$store.dispatch("letters_fetchAll");

    } catch (e) {
      console.log(e);
    }

  },


}
</script>

<style scoped>

</style>
