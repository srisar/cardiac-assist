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
mix.js('vue/patients/add/add.app.js', 'public/app/patients/').vue();

mix.js('vue/symptoms/manage/manage.app.js', 'public/app/symptoms/').vue();
mix.js('vue/symptoms/view/view.app.js', 'public/app/symptoms/').vue();

mix.js('vue/diseases/manage/manage.app.js', 'public/app/diseases/').vue();
mix.js('vue/diseases/view/view.app.js', 'public/app/diseases/').vue();

mix.js('vue/investigations/manage/manage.app.js', 'public/app/investigations/').vue();
mix.js('vue/investigations/view/view.app.js', 'public/app/investigations/').vue();

mix.js('vue/visits/manage.app.js', 'public/app/visits/').vue();

