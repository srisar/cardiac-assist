<template>

  <div>

    <div class="container">

      <div class="row justify-content-center">
        <div class="col-6">


          <div class="card shadow shadow-sm">
            <div class="card-header">Add a book purchase</div>
            <div class="card-body">

              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <label>Purchase Date</label>
                    <input type="date" class="form-control" v-model="bookPurchase.purchaseDate">
                  </div>

                </div><!-- col -->

                <div class="col">

                  <div class="form-group">
                    <label>Supplier</label>
                    <select v-model="bookPurchase.supplierId" class="form-control">
                      <option value="-1" disabled>SELECT</option>
                      <option v-for="(item, index) in suppliersList" :value="item.id" :key="index">{{ item.supplier_name }}</option>
                    </select>
                  </div>

                </div><!-- col -->

              </div><!-- row -->

              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <label>Book Name</label>
                    <input type="text" class="form-control" :value="selectedBookLabel" readonly placeholder="Click to select a book" @click="onClickOpenSearchBookModal">
                  </div>


                </div><!-- col -->
              </div><!-- row -->

              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <label>Unit Price</label>
                    <input type="number" class="form-control" v-model="bookPurchase.unitPrice">
                  </div>

                </div><!-- col -->

                <div class="col">

                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" v-model="bookPurchase.quantity">
                  </div>

                </div><!-- col -->

                <div class="col">

                  <div class="form-group">
                    <label>Total amount</label>
                    <input type="text" readonly class="form-control" :value="totalPrice">
                  </div>

                </div><!-- col -->


              </div><!-- row -->
              <hr>
              <div class="row">
                <div class="col text-center">
                  <button class="btn btn-primary" :disabled="!isFormValid" @click="onClickSaveBookPurchase">Save</button>
                </div>
              </div>

            </div>
          </div>


        </div><!-- col -->
      </div><!-- row -->

    </div>


    <!-- SELECT BOOK MODAL-->
    <div class="modal fade" id="modalSelectBook" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select a book</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <input type="text" class="form-control" v-model="bookSearchQuery" @input="searchBooks" placeholder="Search for books...">
            </div>

            <div v-if="bookSearchResults">
              <table class="table table-sm table-bordered">
                <thead>
                <tr>
                  <th>Book</th>
                  <th>Subject</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in bookSearchResults">
                  <td>{{ item.book_title }}</td>
                  <td>{{ item.subject_name }}</td>
                  <td class="text-center">
                    <button class="btn btn-tiny btn-success" @click="selectBook(item)"><i class="bi bi-check2-circle"></i></button>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <div v-else class="text-center">No results found</div>

          </div>
        </div>
      </div>
    </div>


  </div><!-- template -->

</template>

<script>

import {DateTime} from 'luxon';

const _ = require('lodash');

export default {
  name: "AddBookPurchase",

  data() {
    return {
      bookPurchase: {
        purchaseDate: DateTime.local().toISODate(),
        supplierId: "-1",
        quantity: "1",
        unitPrice: "1",
      },

      suppliersList: [],
      subjectsList: [],

      bookSearchQuery: "",
      bookSearchResults: null,
      selectedBook: null,
    }
  },

  computed: {
    totalPrice() {
      const value = (this.bookPurchase.unitPrice * this.bookPurchase.quantity).toFixed(2);
      return `${value} BHD`;
    },

    selectedBookLabel: function () {
      if (!_.isEmpty(this.selectedBook)) {
        return `${this.selectedBook.book_title} (${this.selectedBook.subject_name})`;
      }
      return "Click to select a book";
    },

    isFormValid: function () {

      return this.bookPurchase.supplierId !== "-1" && this.selectedBook !== null;


    },

  },

  mounted() {

    this._fetchSuppliers();
    this._fetchSubjects();
  },

  methods: {

    _fetchSuppliers: function () {
      $.get(`${getSiteURL()}/api/get/suppliers.php`)
          .done(r => {
            this.suppliersList = r.data;
          })
          .fail(e => {
            console.log(e.responseJSON.message);
          });
    },

    _fetchSubjects: function () {
      $.get(`${getSiteURL()}/api/get/subjects.php`)
          .done(r => {
            this.subjectsList = r.data;
          })
          .fail(e => {
            console.log(e.responseJSON.message);
          });
    },


    onClickOpenSearchBookModal: function () {
      $("#modalSelectBook").modal('show');
    },

    searchBooks: _.debounce(function () {

      console.log("searching for " + this.bookSearchQuery);

      $.get(`${getSiteURL()}/api/search/books.php`, {
        query: this.bookSearchQuery
      }).done(r => {

        this.bookSearchResults = r.data;


      }).fail(e => {
        console.log(e);
      });
    }, 500),

    selectBook: function (book) {
      this.selectedBook = book;
      $("#modalSelectBook").modal('hide');
    },

    onClickSaveBookPurchase: function () {

      const data = {
        purchase_date: this.bookPurchase.purchaseDate,
        supplier_id: this.bookPurchase.supplierId,
        book_id: this.selectedBook.id,
        unit_price: this.bookPurchase.unitPrice,
        quantity: this.bookPurchase.quantity
      };

      console.log(data);

      $.post(`${getSiteURL()}/api/save/book-purchase.php`, data)
          .done(r => {

            alert('success');

          })
          .fail(e => {
            alert(e.responseJSON.message);
          });

    },


  },

}
</script>

<style scoped>

</style>
