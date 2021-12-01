<template>

  <div class="form-group">
    <input type="text" class="form-control"
           placeholder="Type to search..."
           v-model.trim="searchQuery"
           @keydown.down="onDown($event)"
           @keydown.up="onUp($event)"
           @keydown.enter="onSelect">

    <div class="position-absolute w-100 bg-secondary rounded autofill-dropdown">
      <!-- search results -->
      <div class="p-1" v-if="searchResults.length > 0">

        <div class="cursor-pointer" v-for="(item, index) in searchResults">
          <div class="p-2 rounded text-white form-control-dropdown cursor-pointer"
               :class="{'selected' : searchSelectedResult === index}"
               @click="onSelect">
            {{ item[ fieldName ] }}
          </div>
        </div>
      </div><!-- search results -->

      <!-- no results found -->
      <div class="p-2 text-white" v-if="validQuery && searchResults.length === 0">
        Searching...
      </div>

    </div>


  </div>


</template>

<script>
import _ from 'lodash';

export default {
  name: 'AutoCompleteTextBox',

  props: {

    searchDispatchName: {
      type: String,
    },

    fieldName: {
      type: String,
    },

    addDispatchName: {
      type: String,
    },


    /* for v-model */
    value: {
      type: Object,
    },
  },

  data() {
    return {

      searchQuery: '',
      searchResults: [],
      searchSelectedResult: 0,


    };
  },

  computed: {

    validQuery: function () {
      return this.searchQuery !== '';
    },

  },

  watch: {
    searchQuery( newVal, oldVal ) {
      this.onSearch();
    },
  },

  methods: {
    onSearch: _.debounce( async function () {

      if ( this.searchQuery )

        this.searchSelectedResult = 0;
      try {
        this.searchResults = await this.$store.dispatch( this.searchDispatchName, this.searchQuery );


        if ( this.searchQuery.length > 0 ) {
          const lastItem = {};
          lastItem[ this.fieldName ] = this.searchQuery + ' - save this item';
          this.searchResults.push( lastItem );
        }

      } catch ( e ) {

      }

    }, 300 ),


    async onAdd() {

      if ( this.validQuery && this.searchResults.length === 0 ) {
        try {

          const param = {};
          param[ this.fieldName ] = this.searchQuery;

          await this.$store.dispatch( this.addDispatchName, param );
        } catch ( e ) {

        }
      }

    },

    onDown( event ) {
      event.preventDefault();
      if ( this.searchSelectedResult < this.searchResults.length - 1 ) {
        this.searchSelectedResult++;
      }
      return false;
    },

    onUp( event ) {
      event.preventDefault();
      if ( this.searchSelectedResult !== 0 ) {
        this.searchSelectedResult--;
      }
      return false;
    },


    async onSelect() {


      /* adding a new one */
      if ( this.validQuery && this.searchSelectedResult === this.searchResults.length - 1 ) {
        try {

          const param = {};
          param[ this.fieldName ] = this.searchQuery;

          await this.$store.dispatch( this.addDispatchName, param );

          this.searchResults = await this.$store.dispatch( this.searchDispatchName, this.searchQuery );

          this.$emit( 'input', this.searchResults[ this.searchSelectedResult ] );
          this.searchQuery = '';

        } catch ( e ) {

        }

      } else {
        /* choosing existing one from dropdown */
        this.$emit( 'input', this.searchResults[ this.searchSelectedResult ] );
        this.searchQuery = '';
      }

    },

  },

  mounted() {
    //
  },

};
</script>

<style scoped lang="scss">

$color-selected : #1e2024;

.selected {
  background-color : $color-selected;
}

.autofill-dropdown {
  margin-top : 5px;
  z-index    : 99999;
}

.cursor-pointer {
  cursor : pointer;
}

.form-control-dropdown:hover {
  background-color : $color-selected;
}

</style>
