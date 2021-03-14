<template>

  <div>

    <EchoMitralValveValues/>
    <EchoAorticValveValues/>
    <EchoTricuspidValues/>
    <EchoPulmonicValveValues/>
    <EchoAortaValues/>
    <EchoLeftAtriumValues/>
    <EchoRightAtriumValues/>
    <EchoLeftVentricleValues/>
    <EchoRightVentricleValues/>
    <EchoPericardiumValues/>
    <EchoDopplerValues/>

  </div><!-- template -->

</template>

<script>
import EchoMitralValveValues from "./echo_reports/EchoMitralValveValues";
import EchoAortaValues from "./echo_reports/EchoAortaValues";
import EchoAorticValveValues from "./echo_reports/EchoAorticValveValues";
import EchoDopplerValues from "./echo_reports/EchoDopplerValues";
import EchoLeftAtriumValues from "./echo_reports/EchoLeftAtriumValues";
import EchoLeftVentricleValues from "./echo_reports/EchoLeftVentricleValues";
import EchoPericardiumValues from "./echo_reports/EchoPericardiumValues";
import EchoRightAtriumValues from "./echo_reports/EchoRightAtriumValues";
import EchoRightVentricleValues from "./echo_reports/EchoRightVentricleValues";
import EchoTricuspidValues from "./echo_reports/EchoTricuspidValues";
import EchoPulmonicValveValues from "./echo_reports/EchoPulmonicValveValues";

export default {
  name      : "VisitEchoReports",
  components: {
    EchoPulmonicValveValues,
    EchoMitralValveValues,
    EchoAortaValues,
    EchoAorticValveValues,
    EchoDopplerValues,
    EchoLeftVentricleValues,
    EchoLeftAtriumValues,
    EchoRightVentricleValues,
    EchoRightAtriumValues,
    EchoPericardiumValues,
    EchoTricuspidValues,
  },
  data() {
    return {
      //
    }
  },

  computed: {
    //
  },

  mounted() {
    //
  },

  methods: {
    //
  },
}
</script>

<style>

.report-section {

}

.report-section__title {
  font-size: 1em;
  font-weight: bold;
}

</style>
