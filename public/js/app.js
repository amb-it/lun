$( document ).ready( function() {
    $( '#multiselect' ).multiselect();

    $( "#address" ).autocomplete({
        source: "/autocomplete-address",
        minLength: 2,
        select: function( event, ui ) {
            $( '#street_id' ).val(ui.item.street_id);
            $( '#house' ).val(ui.item.house);
        }
    });

    $( "#statistics" ).on('click', function () {
        if (document.cookie.indexOf('statistics') !== -1) {
            document.cookie = "statistics=true; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
        } else {
            document.cookie = "statistics=true;";
        }
        location.reload();
    });
});