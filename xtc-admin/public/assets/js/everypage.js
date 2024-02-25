$(function() {
    $.get("/api/auth/currentAdmin?token=" + Cookies.get('session_token'), function(data, status){
        $("#profile_picture_1").attr("src",data.admin.profile_picture_url);
        $("#profile_picture_2").attr("src",data.admin.profile_picture_url);
        $("#username_p").empty();
        $("#username_p").append(data.admin.username);
    });
});

function logOut(){
    Cookies.remove('session_token');
    window.location.href = "/login";
}
