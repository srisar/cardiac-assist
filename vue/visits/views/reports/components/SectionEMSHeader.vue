<template>

  <div class="ems-header mb-3" v-if="isVisible">
    <div class="d-flex align-items-center">
      <div class="mr-3">
        <img src="/assets/images/ems-logo.png" style="width: 100px" alt="">
      </div>

      <div>
        <div class="font-weight-bold">No.121, New Kalmunai Road</div>
        <div class="font-weight-bold">Kallady, Batticaloa</div>
        <div class="">Phone: 065 222 8812, 065 222 8800</div>
        <div>Email: ems.hospital.batticaloa@gmail.com</div>
      </div>

    </div>
  </div>

</template>

<script>
export default {
  name: "SectionEMSHeader",

  props: {
    isVisible: {
      type: Boolean,
      value: false,
    }
  }
}
</script>

<style scoped>


</style>