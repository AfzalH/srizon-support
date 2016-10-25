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

elixir(function (mix) {
    mix.styles(['bootstrap.min.css','select2.css','AdminLTE.min.css','skins/skin-blue.min.css','magnific-popup.css','app.css','dev.css'],'support/css');
    mix.scripts(['jQuery-2.1.4.min.js','jquery-ui.min.js','bootstrap.js','select2.js','lte.js','link-submit.js','jsvalidation.min.js','magnific-popup.js','magnific-popup-triggers.js','float-label.js','dev.js'],'support/js')
});
