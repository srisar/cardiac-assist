<template>

  <div>

    <div class="container container-sm">

      <div class="form-row">
        <!-- start: sidebar -->
        <div class="col-12 col-md-3">
          <SidebarGroup/>
        </div><!-- col -->

        <div class="col-md-9">
          <transition name="fade" mode="out-in">
            <router-view></router-view>
          </transition>
        </div><!-- col -->

      </div><!-- row -->

    </div><!-- container -->

  </div>

</template>

<script>
import SidebarGroup from "./components/SidebarGroup";

export default {
  name: "AppView",
  components: {SidebarGroup},

  data() {
    return {
      hasSidebar: true,
    }
  },

  computed: {

    // hasSidebar() {
    //   return this.$store.state.view.hasSidebar;
    // }
  },


  beforeCreate() {

    this.hasSidebar = this.$store.state.view.hasSidebar;

    const visitId = document.getElementById('php_visit_id').value;

    /* 1. fetch visit details */
    this.$store.commit('updateVisitId', parseInt(visitId));
    this.$store.dispatch('fetchVisit', parseInt(visitId));
  },


  mounted() {


  },

}
</script>

<style>

@media (max-width: 768px) {

  .btn-group a, .btn-group button {
    font-size: 0.7em !important;
  }

}


.router-link-exact-active {
  font-weight: bold;
  color: #28a745;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

</style>
