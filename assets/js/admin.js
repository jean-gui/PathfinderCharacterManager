import $ from 'jquery';

import '../css/admin.scss'
import '@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css';

import CodeMirror from 'codemirror/lib/codemirror.js';
import 'codemirror/mode/javascript/javascript';
import 'codemirror/lib/codemirror.css';
import 'codemirror/theme/darcula.css';

function isHidden(el) {
    return (el.offsetParent === null);
}

$(".code-json textarea, textarea.code-json").each(function (index, element) {
    CodeMirror.fromTextArea(element, {
        "mode": "application/json",
        "lineNumbers": true,
        "lineWrapping": true,
        "autoCloseBrackets": true,
        "theme": "darcula",
        "matchBrackets": true,
        "lint": true,
        gutters: ["CodeMirror-lint-markers"]
    });
});

// for some reason this only works if the code is in another file
import './additional_admin.js';
