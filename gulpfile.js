var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = true;

elixir(function(mix) {
    mix.sass('app.scss');
    // mix.scripts([
    //   'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js'
    // ], 'public/js/vendor.js', './')
    var bowerDir = './resources/assets/bower/';
    // mix.scripts(['babel-polyfill/dist/polyfill.min.js'], 'public/js/babel-polyfill.js', './node_modules');
    mix.scripts([
            'jquery/dist/jquery.min.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'bluebird/js/browser/bluebird.min.js',
            'rivets/dist/rivets.bundled.min.js'
            ], 'public/js/all.js', bowerDir);

    console.log(mix.babel);
    // mix.babel(['request.js'], 'public/js/lib.js')
    // mix.babel(['lobby.js'], 'public/js/lobby.js')
    mix.browserify(['main.js'], 'public/js/app.js', null, {debug:true})
});
