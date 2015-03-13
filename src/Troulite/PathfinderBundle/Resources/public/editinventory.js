var collectionHolder = jQuery('#troulite_pathfinderbundle_inventory_inventory');

var $addItemLink = jQuery('<a href="#" class="add_tag_link">Add</a>'
)
;
var $newLinkLi = jQuery('<div></div>').append($addItemLink);

jQuery(document).ready(function () {
    collectionHolder.append($newLinkLi);

    $addItemLink.on('click', function (e) {
        e.preventDefault();
        addItemForm(collectionHolder, $newLinkLi);
    });

    collectionHolder.find('div.form-group').each(function () {
        addItemFormDeleteLink($(this));
    });
});

function addItemForm(collectionHolder, $newLinkLi) {
    var prototype = collectionHolder.attr('data-prototype');
    var $newForm = prototype.replace(/__name__/g, collectionHolder.children().length);
    $newLinkLi.before($newForm);
}

function addItemFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">Delete</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function (e) {
        e.preventDefault();
        $tagFormLi.remove();
    });
}