/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

require('bootstrap');

// any CSS you require will output into a single scss file (app.scss in this case)
require('../scss/app.scss');
require('bootstrap/scss/bootstrap.scss');
require('@fortawesome/fontawesome-free/css/all.min.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$(document).ready(function() {
});
