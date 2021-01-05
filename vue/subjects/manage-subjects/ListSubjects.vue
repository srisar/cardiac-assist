<template>
  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">All Subjects</div>
      <div class="card-body">

        <table class="table table-bordered table-sm table-striped">
          <thead>
          <tr>
            <th>Subject</th>
            <th class="text-center table-row-options">Options</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="subject in subjects">
            <td>{{ subject.subject_name }}</td>
            <td class="text-center">
              <button class="btn btn-tiny btn-warning" @click="openEditModal(subject)"><i class="bi bi-pencil-fill"></i></button>
            </td>
          </tr>
          </tbody>
        </table>

      </div>

    </div><!--card-->


    <!--EDIT MODAL-->
    <div class="modal fade" id="editSubjectModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit: {{ selectedSubject.subject_name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label>Subject</label>
              <input type="text" class="form-control" v-model="selectedSubject.subject_name">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>

<script>

export default {
  name: "ListSubjects",
  props: ['eventBus'],

  data: function () {
    return {
      subjects: null,
      selectedSubject: {
        subject_name: "",
        id: ""
      },
    };
  },

  computed: {
    //

  },

  mounted: function () {
    //
    this.fetchAllSubjects();

    this.eventBus.$on('subject-saved', () => {
      this.fetchAllSubjects();
    });

    // to open edit modal


  },

  methods: {
    //
    fetchAllSubjects: function () {

      $.get(`${getSiteURL()}/api/get/subjects.php`)
          .done(response => {
            this.subjects = response.data;
          })
          .fail(error => {
            console.log(error.responseJSON);
          });

    },

    openEditModal: function (selectedSubject) {
      this.selectedSubject = selectedSubject;
      $("#editSubjectModal").modal('show');
    },

  }
}
</script>

<style scoped>

</style>
