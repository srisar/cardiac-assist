<template>

  <div>

    <div class="container">
      <div class="row justify-content-center mb-4">

        <div class="col-12 col-md-6">

          <div class="card shadow shadow-sm">
            <div class="card-header">Add a new book</div>
            <div class="card-body">

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label>Book name</label>
                    <input type="text" class="form-control" v-model.trim="bookToSave.bookName">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Subject</label>
                    <select v-model="bookToSave.subjectId" class="form-control">
                      <option value="-1" disabled>SELECT</option>
                      <option v-for="(item, index) in subjectsList" :value="item.id" :key="index">{{ item.subject_name }}</option>
                    </select>
                  </div>

                </div>
              </div><!-- row -->

              <div class="text-center">
                <button class="btn btn-primary" :disabled="!isFormValid" @click="onClickSaveBook">Save</button>
              </div>

            </div><!-- card-body -->
          </div><!-- card -->

        </div><!-- col -->

      </div><!-- row -->

      <div class="row justify-content-center">
        <div class="col col-md-10">

          <BooksList :event-bus="eventBus" :subjects-list="subjectsList"></BooksList>

        </div>
      </div>

    </div><!-- container -->

  </div><!-- root -->

</template>

<script>

import BooksList from "./BooksList";
import Vue from "vue";

export default {
  name: "ManageBooks",

  components: {BooksList,},

  data() {
    return {
      bookToSave: {
        bookName: "",
        subjectId: "-1"
      },

      subjectsList: [],

      fetchBooks: true,

      eventBus: new Vue({}),

    }
  },

  mounted() {
    this._fetchSubjects();
  },

  computed: {

    isFormValid: function () {
      if (this.bookToSave.bookName === "") return false;
      return this.bookToSave.subjectId !== "-1";
    },

  },

  methods: {

    _fetchSubjects: function () {
      $.get(`${getSiteURL()}/api/get/subjects.php`)
          .done(r => {
            this.subjectsList = r.data;
          })
          .fail(e => {
            console.log(e.responseJSON.message);
          });
    },


    onClickSaveBook: function () {

      $.post(`${getSiteURL()}/api/save/book.php`, {
        book_title: this.bookToSave.bookName,
        subject_id: this.bookToSave.subjectId
      }).done(r => {

        this.eventBus.$emit('book-saved');

      }).fail(e => {
        alert(e.responseJSON.message);
      });

    }

  },

}
</script>

<style scoped>

</style>
