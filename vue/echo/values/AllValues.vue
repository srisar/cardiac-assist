<template>

  <div class="">

    <div class="container">
      <div class="row">
        <div class="col">

          <MitralValveValues class="mb-3" id="mitral"/>
          <AorticValveValues class="mb-3" id="aortic"/>
          <PulmonicValveValues class="mb-3" id="pulmonic"/>
          <TricuspidValues class="mb-3" id="tricuspid"/>

        </div><!-- col -->
      </div><!-- row -->
    </div>

  </div><!-- template -->

</template>

<script>

import MitralValveValues from "./MitralValveValues";
import AorticValveValues from "./AorticValveValues";
import PulmonicValveValues from "./PulmonicValveValues";
import TricuspidValues from "./TricuspidValues";

export default {
  name: "AllValues",

  components: { PulmonicValveValues, MitralValveValues, AorticValveValues, TricuspidValues }

}
</script>

<style scoped>

</style>
