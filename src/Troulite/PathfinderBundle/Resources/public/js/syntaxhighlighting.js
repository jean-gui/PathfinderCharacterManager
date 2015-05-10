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
