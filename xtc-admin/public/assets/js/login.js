// npm package: sweetalert2
// github link: https://github.com/sweetalert2/sweetalert2

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

$("#login-button").click(function(){
    if ($("#username").val() == "" || $("#password").val() == "")
    {
        showSwal('error', 'Please enter your username and password');
        return;
    }

    $("#login-button").prop("disabled", true);
    $("#login-button").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...');
    $.post("/api/auth/login",
    {
        username: $("#username").val(),
        password: $("#password").val()
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
            Cookies.remove('session_token');
            Cookies.set('session_token', json.token);
            window.location.href = "/dashboard";
        }
    });
});
