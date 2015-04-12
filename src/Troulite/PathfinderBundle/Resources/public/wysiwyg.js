var contentParams = {
    inlineMode: true,
    alwaysVisible: true,
    theme: 'froala-pathfinder',
    buttons: ["bold", "italic", "underline", "strikeThrough", "subscript", "superscript", "fontFamily", "fontSize", "color",
        "sep", "formatBlock", "blockStyle", "align", "insertOrderedList", "insertUnorderedList", "outdent", "indent",
        "sep", "createLink", "insertHorizontalRule", "table", "undo", "redo", "removeFormat", "selectAll", "html"]
};

var titleParams = {
    inlineMode: true,
    allowedTags: ["i", "b", "em", "small", "span", "strong", "sub", "sup"],
    buttons: ["bold", "italic", "underline", "strikeThrough", "subscript", "superscript", "selectAll", "createLink",
        "undo", "removeFormat", "redo", "html"],
    alwaysVisible: true,
    paragraphy: false,
    theme: 'froala-pathfinder'
};

$('.froala-view textarea[id$="_content"]').editable(contentParams);

$(window).on('add.mopa-collection-item', function (event, $collection, $row) {
    $('textarea[id$="_content"]', $row).editable(contentParams);
});

$('.froala-view textarea[id$="_title"]').editable(titleParams);

$(window).on('add.mopa-collection-item', function (event, $collection, $row) {
    $('textarea[id$="_title"]', $row).editable(titleParams);
});

var classDefParams = {
    inlineMode: false,
    alwaysVisible: true,
    buttons: ["bold", "italic", "underline", "strikeThrough", "subscript", "superscript", "fontFamily", "fontSize", "color",
        "sep", "formatBlock", "blockStyle", "align", "insertOrderedList", "insertUnorderedList", "outdent", "indent",
        "sep", "createLink", "insertHorizontalRule", "table", "undo", "redo", "removeFormat", "html"],
    theme: 'froala-pathfinder'
};

$('form[name="troulite_pathfinderbundle_classdefinition"] textarea[id$="Description"]').editable(classDefParams);

$(window).on('add.mopa-collection-item', function (event, $collection, $row) {
    $('textarea[id$="Description"]', $row).editable(classDefParams);
});