<template>

  <div>

    <div class="card shadow shadow-sm">
      <div class="card-header">Books</div>
      <div class="card-body">

        <div v-if="books">
          <table class="table table-bordered table-sm">
            <thead>
            <tr>
              <th>Book</th>
              <th>Subject</th>
              <th class="table-row-options">Options</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in books">
              <td>{{ item.book_title }}</td>
              <td>{{ item.subject.subject_name }}</td>
              <td class="text-center">
                <button class="btn btn-tiny btn-warning" @click="onClickOpenEditModal(item)"><i class="bi bi-pencil-fill"></i></button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>


    <!--EDIT MODAL-->
    <div class="modal fade" id="modalEditBook" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" v-if="selectedBook">Edit: {{ selectedBook.book_title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" v-if="selectedBook">

            <div class="form-group">
              <label>Book title</label>
              <input type="text" class="form-control" v-model.trim="selectedBook.book_title">
            </div>

            <div class="form-group">
              <label>Subject</label>
              <select v-model="selectedBook.subject_id" class="form-control">
                <option value="-1" disabled>SELECT</option>
                <option v-for="(item, index) in subjectsList" :value="item.id" :key="index">{{ item.subject_name }}</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="onClickUpdateBook">Save changes</button>
          </div>
        </div>
      </div>
    </div>


  </div><!-- template -->

</template>

<script>
export default {
  name: "BooksList",
  props: ['eventBus', 'subjectsList'],

  data() {
    return {
      books: [],
      selectedBook: null
    }
  },

  computed: {},

  watch: {},

  mounted() {

    this._fetchBooks();

    this.eventBus.$on('book-saved', () => {
      this._fetchBooks()
    });

  },

  methods: {

    _fetchBooks: function () {

      $.get(`${getSiteURL()}/api/get/books.php`)
          .done(r => {

            this.books = r.data;

          })
          .fail(e => {
            console.log(e.responseJSON);
          })

    },

    onClickOpenEditModal: function (selectedBook) {
      this.selectedBook = selectedBook;
      $("#modalEditBook").modal('show');

    },

    onClickUpdateBook: function () {

      $.post(`${getSiteURL()}/api/update/book.php`, {
        book_title: this.selectedBook.book_title,
        subject_id: this.selectedBook.subject_id,
        id: this.selectedBook.id
      }).done(r => {

        this._fetchBooks();
        $("#modalEditBook").modal('hide');

      }).fail(e => {
        console.log(e.responseJSON.message);
      })

    }

  },

}
</script>

<style scoped>

</style>
