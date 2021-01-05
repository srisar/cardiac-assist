const mix = require('laravel-mix');

mix.options({
    terser: {
        extractComments: false,
    }
});

mix.js('vue/homepage/home.app.js', 'public/bookstore/homepage/').vue();

mix.js('vue/supplier/add/add-supplier.js', 'public/bookstore/supplier/').vue();
mix.js('vue/supplier/edit/edit-supplier.js', 'public/bookstore/supplier/').vue();
mix.js('vue/supplier/manage/manage-suppliers.js', 'public/bookstore/supplier/').vue();

mix.js('vue/users/manage/manage-users.js', 'public/bookstore/users/').vue();

mix.js('vue/subjects/manage-subjects.js', 'public/bookstore/subjects/').vue();
mix.js('vue/books/manage-books.js', 'public/bookstore/books/').vue();

mix.js('vue/books-purchase/add/add-book-purchase.js', 'public/bookstore/books-purchase/').vue();
mix.js('vue/books-purchase/view-all/view-all-book-purchases.js', 'public/bookstore/books-purchase/').vue();
