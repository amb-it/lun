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
});