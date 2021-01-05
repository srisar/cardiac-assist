<template>

  <div>

    <div class="container-fluid">
      <div class="row">

        <div class="col">


          <div class="card">
            <div class="card-header">Book purchases</div>
            <div class="card-body">

              <div class="alert alert-light">

                <div class="form-row">

                  <div class="col col-lg-3">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Start</div>
                      </div>
                      <input type="date" class="form-control" v-model="filters.startDate">
                    </div>
                  </div>

                  <div class="col col-lg-3">

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">End</div>
                      </div>
                      <input type="date" class="form-control" v-model="filters.endDate">
                    </div>

                  </div>

                  <div class="col col-lg-3">

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Suppliers</div>
                      </div>
                      <select class="form-control" v-model="filters.supplier_id">
                        <option value="0">All</option>
                        <option v-for="item in filters.suppliersList" :value="item.id">{{ item.supplier_name }}</option>
                      </select>
                    </div>

                  </div>

                  <div class="col col-lg-3">
                    <button class="btn btn-primary" @click="onClickFilter">Filter</button>
                  </div>

                </div><!-- row -->

              </div>

              <table class="table table-bordered table-sm">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Book</th>
                  <th>Supplier</th>
                  <th class="text-right">Quantity</th>
                  <th class="text-right">Unit Price</th>
                  <th class="text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in bookPurchases">
                  <td>{{ item.purchase_date }}</td>
                  <td>{{ item.book.book_title }}</td>
                  <td>{{ item.supplier.supplier_name }}</td>
                  <td class="text-right">{{ item.quantity }}</td>
                  <td class="text-right">{{ getPriceLabel(item.unit_price) }}</td>
                  <td class="text-right">{{ getTotalPriceLabel(item.quantity, item.unit_price) }}</td>
                </tr>
                <tr>
                  <td colspan="5"></td>
                  <td class="text-right font-weight-bold">{{ getPriceLabel(totalSum) }}</td>
                </tr>
                </tbody>
              </table>

            </div>
          </div>

        </div><!-- col -->

      </div>
    </div><!-- container -->

  </div><!-- template -->

</template>

<script>

import {DateTime} from "luxon";

const _ = require('lodash');

export default {
  name: "ViewAllBookPurchases",

  data() {
    return {
      bookPurchases: {},

      filters: {
        startDate: DateTime.local().minus({week: 1}).toISODate(),
        endDate: DateTime.local().toISODate(),
        supplier_id: "0",
        suppliersList: [],
      },

      calculations: {
        tableTotal: 0,
      }

    }
  },

  computed: {

    totalSum: function () {
      let total = 0;
      if (!_.isEmpty(this.bookPurchases)) {
        for (const item of this.bookPurchases) {
          let lineTotal = _.toNumber(item.quantity) * _.toNumber(item.unit_price);
          total += lineTotal;
        }
      }

      return total;
    },

  },

  mounted() {
    this._fetchBookPurchases();
    this._fetchSuppliers();
  },

  methods: {
    _fetchBookPurchases() {

      $.get(`${getSiteURL()}/api/get/book-purchases.php`, {
        supplier_id: this.filters.supplier_id,
        start_date: this.filters.startDate,
        end_date: this.filters.endDate
      }).done(r => {
        this.bookPurchases = r.data;
      }).fail(e => {
        console.log(e);
      });
    },

    _fetchSuppliers: function () {
      $.get(`${getSiteURL()}/api/get/suppliers.php`)
          .done(r => {
            this.filters.suppliersList = r.data;
          })
          .fail(e => {
            console.log(e.responseJSON.message);
          });
    },


    onClickFilter: function () {
      this._fetchBookPurchases();
    },

    /*
    * PRIVATE METHODS
    * */
    getPriceLabel: function (price) {
      return `${price.toFixed(2)} BHD`
    },

    getTotalPriceLabel: function (quantity, price) {
      const total = _.toNumber(quantity) * _.toNumber(price);
      return `${total.toFixed(2)} BHD`;
    }


  },
}
</script>

<style scoped>

</style>