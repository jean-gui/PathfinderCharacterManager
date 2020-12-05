import {Controller} from 'stimulus';
import $ from 'jquery';

import 'select2/dist/css/select2.min.css';
import '@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css';

import Select2 from "select2"

export default class extends Controller {
    get select() {
        return $(this.element);
    }

    connect() {
        let select2_options = {
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

        this.select.select2(select2_options);
    }

    disconnect() {
        this.select.select2('destroy');
    }
}