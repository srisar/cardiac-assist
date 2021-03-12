<template>

  <div class="">

    <div class="container">
      <div class="row">
        <div class="col">

          <MitralValveValues class="mb-3" id="mitral"/>
          <AorticValveValues class="mb-3" id="aortic"/>
          <PulmonicValveValues class="mb-3" id="pulmonic"/>
          <TricuspidValues class="mb-3" id="tricuspid"/>
          <AortaValues class="mb-3" id="aorta"/>
          <LeftAtriumValues class="mb-3" id="left-atrium"/>
          <RightAtriumValues class="mb-3" id="right-atrium"/>
          <LeftVentricleValues class="mb-3" id="left-ventricle"/>
          <RightVentricleValues class="mb-3" id="right-ventricle"/>
          <PericardiumValues class="mb-3" id="pericardium"/>
          <DopplerValues class="mb-3" id="doppler"/>

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
import AortaValues from "./AortaValues";
import LeftAtriumValues from "./LeftAtriumValues";
import RightAtriumValues from "./RightAtriumValues";
import LeftVentricleValues from "./LeftVentricleValues";
import RightVentricleValues from "./RightVentricleValues";
import PericardiumValues from "./PericardiumValues";
import DopplerValues from "./DopplerValues";

export default {
  name: "AllValues",

  components: {
    PulmonicValveValues,
    MitralValveValues,
    AorticValveValues,
    TricuspidValues,
    AortaValues,
    LeftVentricleValues,
    LeftAtriumValues,
    RightVentricleValues,
    RightAtriumValues,
    PericardiumValues,
    DopplerValues
  }

}
</script>

<style scoped>

</style>
