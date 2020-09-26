$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $('.CodeMirror').each(function (index, element) {
        element.CodeMirror.refresh();
    });
});
