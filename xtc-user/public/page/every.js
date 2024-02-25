$(document).ready(function() {
    data = {
        token:Cookies.get('session_token')
    }

    $.post("/api/auth/session/verify", data,
        function(json){
            if (json.status != "success")
            {
                window.location.href = "/auth/login";
            }
        }
    );

    $("#logout").click(function(){
        $.get( "/api/auth/session/logout", function( data ) {
            Cookies.remove('session_token');
            window.location.href = "/auth/login";
        });
    });
});



