const mix = require( 'laravel-mix' );
const path = require( 'path' );

mix.options( {
    terser: {
        extractComments: false,
    },
} );

mix.alias( {
    '@': path.join( __dirname, '/vue' ),
} );

mix.webpackConfig( {
    watchOptions: {
        ignored: /node_modules/,
    },
} );


mix.browserSync( 'localhost' );
mix.disableSuccessNotifications();

mix.sass( 'public/assets/css/app.scss', 'public/assets/css/app.css' );

mix.js( 'vue/users/manage/manage-users.js', 'public/app/users/' ).vue();

mix.js( 'vue/homepage/home.app.js', 'public/app/homepage/' ).vue();

/*
* Patients views
* */
mix.js( 'vue/patients/edit/edit.app.js', 'public/app/patients/' ).vue();
mix.js( 'vue/patients/list/list.app.js', 'public/app/patients/' ).vue();
mix.js( 'vue/patients/add/add.app.js', 'public/app/patients/' ).vue();

mix.js( 'vue/symptoms/manage/manage.app.js', 'public/app/symptoms/' ).vue();

mix.js( 'vue/diseases/manage/manage.app.js', 'public/app/diseases/' ).vue();

mix.js( 'vue/drugs/manage.app.js', 'public/app/drugs/' ).vue();
mix.js( 'vue/problems/manage.app.js', 'public/app/problems/' ).vue();

mix.js( 'vue/referral_letters/manage.app.js', 'public/app/referral-letters/' ).vue();

mix.js( 'vue/investigations/manage/manage.app.js', 'public/app/investigations/' ).vue();

mix.js( 'vue/visits/manage.app.js', 'public/app/visits/' ).vue();

mix.js( 'vue/echo/remarks/remarks.app.js', 'public/app/echo/' ).vue();

