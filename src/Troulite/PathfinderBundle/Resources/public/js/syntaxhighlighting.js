$(".code-json").each(function (index, element) {
    CodeMirror.fromTextArea(element, {
        "mode": "application/json",
        "lineNumbers": true,
        "lineWrapping": true,
        "autoCloseBrackets": true,
        "theme": "base16-dark",
        "matchBrackets": true,
        "lint": true,
        gutters: ["CodeMirror-lint-markers"]
    });
});

$(window).on('add.mopa-collection-item', function (event, $collection, $row) {
    $(".code-json", $row).each(function (index, element) {
        CodeMirror.fromTextArea(element, {
            "mode": "application/json",
            "lineNumbers": true,
            "lineWrapping": true,
            "autoCloseBrackets": true,
            "theme": "base16-dark",
            "matchBrackets": true,
            "lint": true,
            gutters: ["CodeMirror-lint-markers"]
        });
    });
});
