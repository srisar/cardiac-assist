<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">
        Echocardiography
      </div>

      <div class="card-body">

        <!-- section: Left Ventricle -->
        <div class="card mb-3">
          <div class="card-header">Left Ventricle</div>
          <div class="card-body">

            <div class="form-row">

              <div class="col-3 mb-2">
                IVS Diastolic Thickness (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_ivs_diastolic_thickness">
              </div>
              <div class="col-3 mb-2">
                LVID Diastole (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvid_diastole">
              </div>
              <div class="col-3 mb-2">
                PW Diastolic Thickness (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pw_diastolic_thickness">
              </div>

              <div class="col-3 mb-2">
                LVEF (%)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvef">
              </div>

              <div class="col-3 mb-2">
                Fractional Shortening
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_fractional_shortening">
              </div>
              <div class="col-3 mb-2">
                LVID Systole (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvid_systole">
              </div>
              <div class="col-3 mb-2">
                LVEF (%)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvef">
              </div>
            </div>

            <hr>
            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_diastolic_dysfunction" v-model="visitEcho.has_diastolic_dysfunction">
                <label class="form-check-label" for="chk_diastolic_dysfunction">Diastolic Dysfunction</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.has_diastolic_dysfunction">
              <div class="col-3 mb-2">
                A
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_a">
              </div>
              <div class="col-3 mb-2">
                E
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_e">
              </div>
              <div class="col-3 mb-2">
                E'
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_dd_e_bar">
              </div>

              <div class="w-100 mb-2"></div>
              <div class="col-3 mb-2">
                E/A
                <input type="number" class="form-control form-control-sm" :value="eOverA">
              </div>
              <div class="col-3 mb-2">
                E/E'
                <input type="number" class="form-control form-control-sm" :value="eOverEBar">
              </div>

            </div>

            <hr>

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_show_advanced" v-model="visitEcho.show_advanced">
                <label class="form-check-label" for="chk_show_advanced">Advanced</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.show_advanced">

              <div class="col-3 mb-2">
                Stroke Volume (ml)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_stroke_volume">
              </div>
              <div class="col-3 mb-2">
                Cardiac Output (l/min)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_cardiac_output">
              </div>
              <div class="col-3 mb-2">
                HR (beat/min)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_hr">
              </div>
              <div class="col-3 mb-2">
                BP (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_bp">
              </div>

              <div class="col-3 mb-2">
                Cardiac Index (l/min/m²)
                <input type="number" class="form-control form-control-sm" :value="cardiacIndex">
              </div>
            </div>


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.LEFT_VENTRICLE">
                    <option v-for="(item, key) in allEchoRemarks.LEFT_VENTRICLE" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('LEFT_VENTRICLE')" :disabled="hasRemarks('LEFT_VENTRICLE')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('LEFT_VENTRICLE')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.LEFT_VENTRICLE">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Left Ventricle -->


        <!-- section: Left Atrium -->
        <div class="card mb-3">
          <div class="card-header">Left Atrium</div>
          <div class="card-body">

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_is_left_atrium_dilated" v-model="visitEcho.is_left_atrium_dilated">
                <label class="form-check-label" for="chk_is_left_atrium_dilated">Is dilated</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.is_left_atrium_dilated">
              <div class="col-3 mb-2">
                LA Systolic Diameter <br> (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_la_systolic_diameter">
              </div>
              <div class="col-3 mb-2">
                LA Area<br>(mm²)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_la_area">
              </div>
            </div>

            <hr>

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_has_asd" v-model="visitEcho.has_asd">
                <label class="form-check-label" for="chk_has_asd">Has ASD</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.has_asd">
              <div class="col-3 mb-2">
                ASD Size (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_asd_size">
              </div>
            </div>


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.LEFT_ATRIUM">
                    <option v-for="(item, key) in allEchoRemarks.LEFT_ATRIUM" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('LEFT_ATRIUM')" :disabled="hasRemarks('LEFT_ATRIUM')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('LEFT_ATRIUM')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.LEFT_ATRIUM">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Left Atrium -->


        <!-- section: Mitral Valve -->
        <div class="card mb-3">
          <div class="card-header">Mitral Valve</div>
          <div class="card-body">

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_has_mitral_stenosis" v-model="visitEcho.has_mitral_stenosis">
                <label class="form-check-label" for="chk_has_mitral_stenosis">Has Mitral Stenosis</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.has_mitral_stenosis">
              <div class="col-3 mb-2">
                Mitral Pressure 1/2 T (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mitral_pressure">
              </div>
              <div class="col-3 mb-2">
                Mean Mitral Gradient (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mean_mitral_gradient">
              </div>
              <div class="col-3 mb-2">
                Doppler Mitral Valve Area (mm²)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_doppler_mitral_valve_area">
              </div>
              <div class="col-3 mb-2">
                Trace Mitral Valve Area (mm²)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_trace_mitral_valve_area">
              </div>
              <div class="col-3 mb-2">
                MV Score
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mv_score">
              </div>
            </div>

            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.MITRAL_VALVE">
                    <option v-for="(item, key) in allEchoRemarks.MITRAL_VALVE" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('MITRAL_VALVE')" :disabled="hasRemarks('MITRAL_VALVE')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('MITRAL_VALVE')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.MITRAL_VALVE">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Mitral Valve -->

        <!-- section: Aortic Valve -->
        <div class="card mb-3">
          <div class="card-header">Aortic Valve</div>
          <div class="card-body">

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_is_diseased_aortic_valve" v-model="visitEcho.is_diseased_aortic_valve">
                <label class="form-check-label" for="chk_is_diseased_aortic_valve">Diseased</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.is_diseased_aortic_valve">
              <div class="col-3 mb-2">
                Peak Aortic Gradient (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_aortic_gradient">
              </div>
              <div class="col-3 mb-2">
                Mean Aortic Gradient (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mean_aortic_gradient">
              </div>
              <div class="col-3 mb-2">
                Aortic Valve Area (mm²)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_valve_area">
              </div>
              <div class="col-3 mb-2">
                Peak Aortic Velocity (cm/s)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_aortic_velocity">
              </div>

              <div class="col-3 mb-2">
                Peak Aortic Velocity (cm/s)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_aortic_velocity">
              </div>

              <div class="col-3 mb-2">
                Peak LVOT Velocity (cm/s)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_lvot_velocity">
              </div>
              <div class="col-3 mb-2">
                Aortic/LVOT Velocity (cm/s)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_lvot_velocity">
              </div>
              <div class="col-3 mb-2">
                ARPHT <br> (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_arpht">
              </div>

              <div class="col-3 mb-2">
                LVOT Diameter (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_lvot_diameter">
              </div>

            </div>


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.AORTIC_VALVE">
                    <option v-for="(item, key) in allEchoRemarks.AORTIC_VALVE" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('AORTIC_VALVE')" :disabled="hasRemarks('AORTIC_VALVE')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('AORTIC_VALVE')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.AORTIC_VALVE">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Aortic Valve -->


        <!-- section: Aorta -->
        <div class="card mb-3">
          <div class="card-header">Aorta</div>
          <div class="card-body">

            <div class="form-row">
              <div class="col-3 mb-2">
                Root (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_root">
              </div>
              <div class="col-3 mb-2">
                Annulus (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_annulus">
              </div>

              <div class="col-3 mb-2">
                ST Junction (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_st_junction">
              </div>

              <div class="col-3 mb-2">
                Proximal Aorta (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_proximal">
              </div>

              <div class="col-3 mb-2">
                Aortic Arch (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aorta_aortic_arch">
              </div>
            </div>

            <hr>

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_is_diseased_aorta" v-model="visitEcho.is_diseased_aorta">
                <label class="form-check-label" for="chk_is_diseased_aorta">Diseased</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.is_diseased_aorta">
              <div class="col-3 mb-2">
                Aortic Root Diameter (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_aortic_root_diameter">
              </div>
            </div>

            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.AORTA">
                    <option v-for="(item, key) in allEchoRemarks.AORTA" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('AORTA')" :disabled="hasRemarks('AORTA')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('AORTA')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.AORTA">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Aorta -->


        <!-- section: Right Ventricle / Pulmonary Artery -->
        <div class="card mb-3">
          <div class="card-header">Right Ventricle / Pulmonary Artery</div>
          <div class="card-body">

            <div class="form-row">

              <div class="col-3 mb-2">
                TAPSE <br> (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_tapse">
              </div>

              <div class="col-3 mb-2">
                Peak Tricuspid Velocity (cm/s)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_peak_tricuspid_velocity">
              </div>

              <div class="col-3 mb-2">
                Est. RVSP <br> (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_rvsp">
              </div>

              <div class="col-3 mb-2">
                Est. CVP <br> (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_cvp">
              </div>

              <div class="col-3 mb-2">
                Est. PASP (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_pasp">
              </div>

              <div class="col-3 mb-2">
                Est. CVP (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_est_cvp">
              </div>

              <div class="col-3 mb-2">
                MPA (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_mpa">
              </div>

              <div class="col-3 mb-2">
                RVOT1 (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvot1">
              </div>

              <div class="col-3 mb-2">
                RVOT2 (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvot2">
              </div>

              <div class="col-3 mb-2">
                RVOTAT (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvotat">
              </div>

              <div class="col-3 mb-2">
                RVID (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rvid">
              </div>

            </div>

            <hr>

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_has_vsd" v-model="visitEcho.has_vsd">
                <label class="form-check-label" for="chk_has_vsd">VSD</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.has_vsd">
              <div class="col-3 mb-2">
                Size (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rv_size">
              </div>
              <div class="col-3 mb-2">
                IVG (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_rv_ivg">
              </div>
            </div>


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.RIGHT_VENTRICLE">
                    <option v-for="(item, key) in allEchoRemarks.RIGHT_VENTRICLE" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('RIGHT_VENTRICLE')" :disabled="hasRemarks('RIGHT_VENTRICLE')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('RIGHT_VENTRICLE')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.RIGHT_VENTRICLE">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Right Ventricle / Pulmonary Artery -->

        <!-- section: Right Atrium -->
        <div class="card mb-3">
          <div class="card-header">Right Atrium</div>
          <div class="card-body">

            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.RIGHT_ATRIUM">
                    <option v-for="(item, key) in allEchoRemarks.RIGHT_ATRIUM" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('RIGHT_ATRIUM')" :disabled="hasRemarks('RIGHT_ATRIUM')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('RIGHT_ATRIUM')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.RIGHT_ATRIUM">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Right Atrium -->


        <!-- section: Pulmonic Valve -->
        <div class="card mb-3">
          <div class="card-header">Pulmonic Valve</div>
          <div class="card-body">

            <div class="mb-3">
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="chk_has_ps" v-model="visitEcho.has_ps">
                <label class="form-check-label" for="chk_has_ps">PS</label>
              </div>
            </div>

            <div class="form-row" v-if="visitEcho.has_ps">
              <div class="col-3 mb-2">
                PS (mmHg)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pv_pg">
              </div>
              <div class="col-3 mb-2">
                PV Annulus (mm)
                <input type="number" class="form-control form-control-sm" v-model.number="visitEcho.param_pv_annulus">
              </div>
            </div>


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.PULMONIC_VALVE">
                    <option v-for="(item, key) in allEchoRemarks.PULMONIC_VALVE" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('PULMONIC_VALVE')" :disabled="hasRemarks('PULMONIC_VALVE')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('PULMONIC_VALVE')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.PULMONIC_VALVE">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Pulmonic Valve -->


        <!-- section: Tricuspid -->
        <div class="card mb-3">
          <div class="card-header">Tricuspid</div>
          <div class="card-body">


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.TRICUSPID">
                    <option v-for="(item, key) in allEchoRemarks.TRICUSPID" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('TRICUSPID')" :disabled="hasRemarks('TRICUSPID')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('TRICUSPID')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.TRICUSPID">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Tricuspid -->

        <!-- section: Pericardium -->
        <div class="card mb-3">
          <div class="card-header">Pericardium</div>
          <div class="card-body">

            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.PERICARDIUM">
                    <option v-for="(item, key) in allEchoRemarks.PERICARDIUM" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('PERICARDIUM')" :disabled="hasRemarks('PERICARDIUM')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('PERICARDIUM')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.PERICARDIUM">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Pericardium -->


        <!-- section: Conclusions -->
        <div class="card mb-3">
          <div class="card-header">Conclusions</div>
          <div class="card-body">


            <!-- add remarks -->
            <div class="alert alert-secondary p-1 m-0">

              <div class="font-weight-bold mb-2">Remarks</div>

              <div class="mb-3">
                <div class="input-group input-group-sm">

                  <select class="custom-select" v-model="selectedRemarks.CONCLUSION">
                    <option v-for="(item, key) in allEchoRemarks.CONCLUSION" :value="key">{{ item.value }}</option>
                  </select>

                  <div class="input-group-append">
                    <button class="btn btn-primary" @click="onInsert('CONCLUSION')" :disabled="hasRemarks('CONCLUSION')">Insert</button>
                    <button class="btn btn-success" @click="onOpenAddModal('CONCLUSION')">Add</button>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-sm table-hover m-0">
                <tbody>
                <tr v-for="item in visitEchoRemarks.CONCLUSION">
                  <td style="white-space: pre-line">{{ item.value }}</td>
                  <td style="width: 30px">
                    <button class="btn btn-tiny btn-danger" @click="onDelete(item)">Remove</button>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
            <!-- add remarks -->

          </div>
        </div>
        <!-- section: Conclusions -->


        <div class="text-center">
          <button class="btn btn-success" @click="onUpdate()">Update</button>
        </div>


      </div><!-- card-body -->

    </div><!-- card -->


    <ModalWindow :visible="modalAddVisible" @close="modalAddVisible = false">
      <template v-slot:title>Add new remark for {{ echoRemarkToAdd.typeLabel }}</template>
      <slot>

        <div class="form-group">
          <label>Type</label>
          <input type="text" class="form-control" readonly v-model="echoRemarkToAdd.typeLabel">
        </div>

        <div class="form-group">
          <label>Value</label>
          <textarea class="form-control" rows="3" v-model.trim="echoRemarkToAdd.value"></textarea>
        </div>

        <div class="text-center">
          <button class="btn btn-success" @click="onAddRemark()" :disabled="echoRemarkToAdd.value === ''">Add</button>
        </div>

      </slot>
    </ModalWindow>

  </div>


</template>

<script>
import {errorMessageBox, successMessageBox} from "../../../_common/bootbox_dialogs";
import ModalWindow from "../../../_common/components/ModalWindow";

export default {
  name: "VisitEchoViewV2",
  components: { ModalWindow },
  data() {
    return {

      modalAddVisible: false,

      echoRemarkToAdd: {
        value: "",
        type: "",
        typeLabel: "",
      },

      selectedRemarks: {
        'LEFT_VENTRICLE': 0,
        'LEFT_ATRIUM': 0,
        'MITRAL_VALVE': 0,
        'AORTIC_VALVE': 0,
        'AORTA': 0,
        'RIGHT_VENTRICLE': 0,
        'RIGHT_ATRIUM': 0,
        'PULMONIC_VALVE': 0,
        'TRICUSPID': 0,
        'PERICARDIUM': 0,
        'CONCLUSION': 0,
      },

      echoRemarksTypes: {
        'LEFT_VENTRICLE': 'Left Ventricle',
        'LEFT_ATRIUM': 'Left Atrium',
        'MITRAL_VALVE': 'Mitral Valve',
        'AORTIC_VALVE': 'Aortic Valve',
        'AORTA': 'Aorta',
        'RIGHT_VENTRICLE': 'Right Ventricle / Pulmonary Artery',
        'RIGHT_ATRIUM': 'Right Atrium',
        'PULMONIC_VALVE': 'Pulmonic Valve',
        'TRICUSPID': 'Tricuspid',
        'PERICARDIUM': 'Pericardium',
        'CONCLUSION': 'Conclusion',
      },


    };
  },

  computed: {

    visitEcho() {
      return this.$store.getters.getVisitEcho;
    },

    visitId() {
      return this.$store.getters.getVisitId;
    },

    allEchoRemarks: function () {
      return this.$store.getters.getEchoRemarks
    },

    visitEchoRemarks: function () {
      return this.$store.getters.getVisitEchoRemarks
    },

    eOverA() {
      if ( this.visitEcho.param_dd_a === 0 ) return 0;
      return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_a ).toFixed( 2 );
    },

    eOverEBar() {
      if ( this.visitEcho.param_dd_e_bar === 0 ) return 0;
      return ( this.visitEcho.param_dd_e / this.visitEcho.param_dd_e_bar ).toFixed( 2 );
    },

    cardiacIndex() {
      if ( this.visitEcho.param_cardiac_output === 0 ) return 0;
      return this.visitEcho.param_cardiac_output / this.visitEcho.visit.bsa;
    }

  },


  async mounted() {
    try {

      await this.$store.dispatch( "visitEcho_fetch", this.visitId );
      // this.loaded = true;

    } catch ( e ) {
      errorMessageBox( "Failed to fetch echo details" );
    }

    /* fetch all echo remarks */
    try {

      await this.$store.dispatch( "echo_fetchAllRemarks" );
      await this.$store.dispatch( "echo_fetchAllVisitRemarks", this.visitId );

    } catch ( e ) {
      errorMessageBox( "Failed to fetch remarks" );
    }


  },


  methods: {

    async onUpdate() {

      try {

        await this.$store.dispatch( "visitEcho_update", this.visitEcho );
        successMessageBox( "Echocardiogram details updated" );
      } catch ( e ) {
        errorMessageBox( "Failed to update echocardiogram details" );
      }

    }, /* update */


    async onAddRemark() {
      try {

        const params = {
          type: this.echoRemarkToAdd.type,
          value: this.echoRemarkToAdd.value,
        };

        await this.$store.dispatch( "echo_addEchoRemark", params );
        await this.$store.dispatch( "echo_fetchAllRemarks" );

        this.modalAddVisible = false;

      } catch ( e ) {
        errorMessageBox( "Failed to add new echo remark item" );
      }
    },

    async onInsert( type ) {

      try {

        const index = this.selectedRemarks[ type ];
        const item = this.allEchoRemarks[ type ][ index ];

        const params = {
          visit_id: this.visitId,
          echo_value_id: item.id
        };

        await this.$store.dispatch( "echo_addVisitRemark", params );

      } catch ( e ) {
        errorMessageBox( "Failed to insert the remark" );
      }

      /* fetch all visit echo remarks again */
      try {
        await this.$store.dispatch( "echo_fetchAllVisitRemarks", this.visitId );
      } catch ( e ) {
        errorMessageBox( "Failed to fetch remarks" );
      }

    },

    async onDelete( item ) {

      try {
        await this.$store.dispatch( "echo_deleteVisitRemark", item.id );

      } catch ( e ) {
        errorMessageBox( "Failed to delete selected remark item" );
      }

      try {
        await this.$store.dispatch( "echo_fetchAllVisitRemarks", this.visitId );
      } catch ( e ) {
        errorMessageBox( "Failed to fetch remarks" );
      }

    },

    /*
     * On opening add modal
     * */
    onOpenAddModal( type ) {
      this.echoRemarkToAdd.type = type;
      this.echoRemarkToAdd.typeLabel = this.echoRemarksTypes[ type ];
      this.modalAddVisible = true;
    },

    /*
     * check if theres items in the echo remarks
     * */
    hasRemarks( group ) {
      return !!_.isEmpty( this.allEchoRemarks[ group ] );
    }

  },

}
</script>

<style scoped>

</style>
