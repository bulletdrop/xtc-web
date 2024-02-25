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
    if (Cookies.get('session_token') != undefined)
    {
        data = {
            token:Cookies.get('session_token')
        }

        $.post("/api/auth/session/verify", data,
            function(json){
                if (json.status == "success")
                {
                    window.location.href = "/panel/home";
                }
                else{
                    Cookies.remove('session_token');
                }
            }
        );
    }

    $("#login").click(function(){
        if ($("#username").val() == "" || $("#password").val() == "")
        {
            showSwal('error', 'Please enter your email, username and password');
            return;
        }

        data = {
            username: $("#username").val(),
            password: $("#password").val()
        };

        $("#login").prop("disabled", true);
        $("#login").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...');
        $.post("/api/auth/login", data,
        function(json){
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

            $("#login").prop("disabled", false);
            $("#login").html('Login');
        });
    });
});
