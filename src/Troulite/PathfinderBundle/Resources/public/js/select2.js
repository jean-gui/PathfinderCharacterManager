var select2_options = {
    theme: "bootstrap",
    minimumResultsForSearch: 20,
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

$(window).on('add.mopa-collection-item', function (event, $collection, $row) {
    $('select', $row).select2(select2_options);
});