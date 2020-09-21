/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';
import 'bootstrap';
import bsCustomFileInput from 'bs-custom-file-input';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

require('@fortawesome/fontawesome-free/css/all.css');

bsCustomFileInput.init();

$('.mypopover').popover({
    placement: 'auto',
    html: true,
    container: 'body'
});
