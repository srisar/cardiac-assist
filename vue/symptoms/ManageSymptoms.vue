<template>

  <div>

    <div class="container-fluid">

      <div class="col-12 col-md-6">
        <RichEditor v-model="symptomToAdd.value"></RichEditor>
      </div><!-- col -->

    </div><!-- container -->

  </div><!-- template -->

</template>

<script>
import RichEditor from "../_common/components/RichEditor";

export default {
  name: "ManageSymptoms",
  components: {RichEditor,},

  data() {
    return {
      symptomToAdd: {
        value: "Hello world!",
      }
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

<style scoped>

</style>
