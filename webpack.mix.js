let mix = require('webpack-mix');

// mix.autoload({
//     jquery: ['$', 'window.jQuery']
// });

mix.js('src/js/app.js', 'public/js');
mix.js('vue/system/users/manage_users.js', 'public/vue/system/users');


mix.js('vue/visits/add/add_visit.js', 'public/vue/visits/add');
mix.js('vue/symptoms/manage_symptoms.js', 'public/vue/symptoms');
mix.js('vue/diseases/manage_diseases.js', 'public/vue/diseases');

// mix.js('src/js/vue/symptoms/manage_symptoms.js', 'public/vue/symptoms');
// mix.js('src/js/vue/diseases/manage_diseases.js', 'public/vue/diseases');

mix.sass('src/scss/app.scss', 'public/css').sourceMaps();


mix.combine([
    'src/js/libs/jquery-3.5.1.min.js',
    'src/js/libs/bootstrap.min.js',
    'src/js/libs/moment.min.js',
    'src/js/libs/datatables.min.js',
    'src/js/libs/daterangepicker.min.js',
    'src/js/libs/popper.min.js',
    'src/js/libs/toastr.min.js',
    'src/js/libs/jquery.autocomplete.js',
    'src/js/libs/axios.min.js',
    'src/js/libs/lodash.js',
    'src/js/common/helper.js',
    'src/js/common/messages.js',
    'src/js/common/toasts.js',
    'src/js/common/forms.js'

], 'public/js/libs/all.js');