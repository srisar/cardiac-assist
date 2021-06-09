<template>
  <div>

    <div class="container">

      <div class="form-row">

        <div class="col-12 col-md-4">
          <ListInvestigations/>
        </div>

        <div class="col-12 col-md-8 mb-2">
          <router-view></router-view>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div><!-- template -->
</template>

<script>

import SaveInvestigation from "./components/SaveInvestigation";
import ListInvestigations from "./components/ListInvestigations";
import EditInvestigation from "./components/EditInvestigation";

export default {
  name: "ManageInvestigations",
  components: {SaveInvestigation, ListInvestigations, EditInvestigation},

}
</script>

<style scoped>

</style>
