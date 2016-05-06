var elixir = require('laravel-elixir');

var bower = './resources/assets/bower/';

elixir(function (mix) {
    mix
        .sass('bootstrap.scss', 'public/assets/bootstrap.css')

        .scripts([
            'jquery/dist/jquery.min.js',
            'moment/min/moment.min.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
            'js-cookie/src/js.cookie.js'
        ], './public/assets/vendor.js', bower)

        .styles([
            'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
            'font-awesome/css/font-awesome.min.css'
        ], './public/assets/vendor.css', bower)

        .copy(
            bower + 'font-awesome/fonts',
            './public/fonts'
        );
});
