/**
 * Created by jean-gui on 26/07/14.
 */

$(document).ready(function () {
    $('.mypopover').popover({
        placement: function (tip, element) {
            var offset = $(element).offset();
            height = $(document).outerHeight();
            width = $(document).outerWidth();
            vert = 0.5 * height - offset.top;
            vertPlacement = vert > 0 ? 'bottom' : 'top';
            horiz = 0.5 * width - offset.left;
            horizPlacement = horiz > 0 ? 'right' : 'left';
            placement = Math.abs(horiz) > Math.abs(vert) ? horizPlacement : vertPlacement;
            return placement;
        },
        html: true,
        container: 'body'
    });
});