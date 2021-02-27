<template>

  <div>

    <div class="form-row">

      <div class="col">
        <div class="form-group">
          <label>TC</label>
          <input type="text" class="form-control" v-model="visitLipids.tc">
        </div>
      </div><!-- col -->

      <div class="col">
        <div class="form-group">
          <label>LDL</label>
          <input type="text" class="form-control" v-model="visitLipids.ldl">
        </div>
      </div><!-- col -->

      <div class="col">
        <div class="form-group">
          <label>HDL</label>
          <input type="text" class="form-control" v-model="visitLipids.hdl">
        </div>
      </div><!-- col -->

      <div class="col">
        <div class="form-group">
          <label>TG</label>
          <input type="text" class="form-control" v-model="visitLipids.tg">
        </div>
      </div><!-- col -->

      <div class="col">
        <div class="form-group">
          <label>NHC</label>
          <input type="text" class="form-control" v-model="visitLipids.nhc">
        </div>
      </div><!-- col -->

    </div><!-- row -->

    <div class="form-row">
      <div class="col text-center">
        <button class="btn btn-success" @click="onUpdate">Update</button>
      </div>
    </div>


  </div><!-- template -->

</template>

<script>
export default {
  name: "VisitLipids",

  data() {
    return {
      exist: false,

      visitLipids: {
        id      : undefined,
        visit_id: undefined,
        tc      : 0,
        ldl     : 0,
        hdl     : 0,
        tg      : 0,
        nhc     : 0
      },

    }
  },

  computed: {
    //
    visit: function () { return this.$store.getters.getVisit; },

  },

  mounted() {

    /*
   * Check if visit lipids exist, otherwise add a new one
   * */
    this._checkIfExist()
        .then(r => {
          if ( !this.exist ) {
            this._addNew()
                .then(r => {
                  this.visitLipids = r.data;
                });
          } else {
            this.visitLipids = r.data[0];
          }
        });

  },


  methods: {
    //

    onUpdate: function () {
      const params = {
        id : this.visitLipids.id,
        tc : this.visitLipids.tc,
        ldl: this.visitLipids.ldl,
        hdl: this.visitLipids.hdl,
        tg : this.visitLipids.tg,
        nhc: this.visitLipids.nhc,
      };

      $.post(`${getSiteURL()}/api/update/visit-lipids.php`, params)
          .done(r => {
            alert("Lipid details updated");
          })
          .fail(e => {
            console.log(e);
            alert("Failed to update lipid details");
          });
    },


    _checkIfExist: function () {

      const params = { visit_id: this.visit.id, };

      return new Promise((resolve, reject) => {
        $.get(`${getSiteURL()}/api/get/visit-lipids.php`, params)
            .done(r => {
              this.exist = !_.isEmpty(r.data);
              resolve(r);
            })
            .fail(e => {
              reject(e);
            });
      });

    }, /* check if visit lipids already exist in db */

    _addNew: function () {

      return new Promise((resolve, reject) => {

        const params = {
          visit_id: this.visit.id, tc: 0, ldl: 0, hdl: 0, tg: 0, nhc: 0,
        };

        $.post(`${getSiteURL()}/api/save/visit-lipids.php`, params)
            .done(r => {
              this.exist = true;
              resolve(r);
            })
            .fail(e => {
              reject(e);
            });
      });
    }, /* add new */

  },
}
</script>

<style scoped>

</style>
