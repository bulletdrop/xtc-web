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

$(document).ready(function() {
    $("#register").click(function(){
        if ($("email").val() == "" || $("#username").val() == "" || $("#password").val() == "" || $("#confirmPassword").val() == "")
        {
            showSwal('error', 'Please enter your email, username and password');
            return;
        }

        if ($("#password").val() != $("#confirmPassword").val())
        {
            showSwal('error', 'Passwords do not match');
            return;
        }

        data = {
            username: $("#username").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            confirmPassword: $("#confirmPassword").val()
        };

        $("#register").prop("disabled", true);
        $("#register").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...');
        $.post("/api/auth/register", data,
        function(json){
            if (json.status == "password_change_required")
            {
                window.location.href = json.message;
                return;
            }

            if (json.status == "error")
            {
                showSwal('error', json.message);

            }
            else
            {
                showSwal('success', json.message);
                Cookies.remove('session_token');
                Cookies.set('session_token', json.token);
                window.location.href = "/panel/home";
            }

            $("#register").prop("disabled", false);
            $("#register").html('Register');
        });
    });
});
