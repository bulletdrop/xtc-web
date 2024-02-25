
$( "#has_to_change_password_div" ).hide( "fast", function() {});

$("#has_to_change_password").change(function() {
    if(this.checked)
        $( "#has_to_change_password_div" ).show( "fast", function() {});

    else
        $( "#has_to_change_password_div" ).hide( "fast", function() {});
});
