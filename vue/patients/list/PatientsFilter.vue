<template>

  <div class="card shadow shadow-sm">
    <div class="card-body">

      <div class="row">

        <div class="col">
          <div class="input-group">
            <input type="text" class="form-control"
                   v-model.trim="query"
                   @keyup.enter="onSearch()"
                   placeholder="Search for names, addresses and phones">
            <div class="input-group-append">
              <button class="btn btn-primary" @click="onSearch()">Search</button>
            </div>
          </div>
        </div>

      </div><!-- row -->

    </div>
  </div><!-- card -->

</template>

<script>

export default {
  name: "PatientsFilter",

  data() {
    return {

      query: "",

    }
  },

  computed: {
    //
  },

  mounted() {

    this.query = this.$route.params.keyword;

  },

  methods: {

    onSearch() {

      if (!_.isEmpty(this.query) && this.$route.params.keyword !== this.query) {
        this.$router.push("/search/" + this.query);
      }

    }

  },

}
</script>

<style scoped>

</style>
