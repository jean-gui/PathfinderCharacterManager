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

if (("Notification" in window) && Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
        if (!('permission' in Notification)) {
            Notification.permission = permission;
        }
    });
}

import 'select2';
import 'select2/dist/css/select2.min.css';
import '@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css';

var select2_options = {
    theme: "bootstrap4",
    minimumResultsForSearch: 5,
    templateResult: function (feat) {
        if (typeof select2_descriptions == 'undefined') return feat.text;

        var descs = select2_descriptions[$(feat.element).parent().attr("id")];
        if (feat.id && descs[feat.id]) {
            return $("<span>" + feat.text + "<br/><small>" + descs[feat.id] + "</small></span>");
        } else {
            return feat.text;
        }
    },
    templateSelection: function (feat) {
        if (typeof select2_descriptions == 'undefined') return feat.text;

        var descs = select2_descriptions[$(feat.element).parent().attr("id")];
        if (descs[feat.id]) {
            return $("<span>" + feat.text + " <small>(" + descs[feat.id] + ")</small></span>");
        } else {
            return feat.text;
        }
    }
};

$("select").select2(select2_options);
