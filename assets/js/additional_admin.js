import CodeMirror from "codemirror";

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $('.CodeMirror').each(function (index, element) {
        element.CodeMirror.refresh();
    });
});

var select2_options = {
    theme: "bootstrap4",
    minimumResultsForSearch: 5
};

$(".select2").select2(select2_options);

document.addEventListener('ea.collection.item-added', function (e) {
    $('select.select2:not(.select2-hidden-accessible)').select2(select2_options);
    $('textarea.code-json').each(function (index, el) {
        if (el.offsetParent !== null) {
            CodeMirror.fromTextArea(el, {
                "mode": "application/json",
                "lineNumbers": true,
                "lineWrapping": true,
                "autoCloseBrackets": true,
                "theme": "darcula",
                "matchBrackets": true,
                "lint": true,
                gutters: ["CodeMirror-lint-markers"]
            });
        }
    });
});
