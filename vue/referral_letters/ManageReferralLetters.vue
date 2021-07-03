<template>

  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-4 mb-3">
          <!-- list -->

          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header d-flex justify-content-between">
              <div>Referral Letters</div>
              <div>
                <router-link class="btn btn-tiny btn-outline-success" to="/add">
                  <img src="/assets/images/actions/add.svg" class="icon-16" alt=""> Add
                </router-link>
              </div>
            </div>

            <div class="card-body">

              <table class="table table-sm table-bordered table-hover">

                <tbody>
                <tr v-for="item in lettersList" :key="item.id">
                  <td class="text-left">
                    <router-link :to="'/edit/' + item.id">{{ item.title }}</router-link>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>

          </div><!-- card -->

          <div class="card mb-3 shadow shadow-sm">
            <div class="card-header">Help</div>
            <div class="card-body">

              <p class="font-weight-bold">The following template tags can be used to automatically insert
                dynamic values when adding these letters to patient visits.</p>
              <p>{DATE}</p>
              <p>{DR_NAME}, {DR_ADDRESS}</p>
              <p>{PATIENT_NAME}, {PRONOUN}, {PRONOUN|START}, {PRONOUN|POSSESSIVE}</p>
              <p>{TREATMENT}, {DIAGNOSES}, {SYMPTOMS}, {DISEASE}</p>

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
