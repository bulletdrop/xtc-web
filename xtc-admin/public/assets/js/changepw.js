$(function() {
    showSwal = function(type, message) {
    'use strict';
        if (type === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: message
            })
        }
    }
});

function changePW() {
    if ($("#new_password").val() != $("#conf_new_password").val()) {
        showSwal('error', 'The passwords dont match');
        return;
    }

    $("#changePW").prop("disabled", true);
    $("#changePW").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Changing password...');

    $.post("/api/auth/changePassword",
    {
        username: GetURLParameter('username'),
        password: $("#cur_password").val(),
        newPassword: $("#new_password").val()
    },
    function(json){
        if (json.status == "password_change_required")
        {
            window.location.href = json.message;
            return;
        }
        if (json.status == "error")
        {
            showSwal('error', json.message);
            $("#login-button").prop("disabled", false);
            $("#login-button").html('Login');
        }
        else
        {
            window.location.href = "/login";
        }
    });

};

function GetURLParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return decodeURIComponent(sParameterName[1]);
        }
    }
}
