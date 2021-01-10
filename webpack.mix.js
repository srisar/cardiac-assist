const mix = require('laravel-mix');

mix.options({
    terser: {
        extractComments: false,
    }
});


mix.sass('public/assets/css/app.scss', 'public/assets/css/app.css');

mix.js('vue/users/manage/manage-users.js', 'public/app/users/').vue();

mix.js('vue/homepage/home.app.js', 'public/app/homepage/').vue();

/*
* Patients views
* */
mix.js('vue/patients/edit/edit.app.js', 'public/app/patients/').vue();
mix.js('vue/patients/list/list.app.js', 'public/app/patients/').vue();

mix.js('vue/symptoms/manage.app.js', 'public/app/symptoms/').vue();
mix.js('vue/diseases/manage.app.js', 'public/app/diseases/').vue();

