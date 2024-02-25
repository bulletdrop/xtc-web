$(function() {
    showSwal = function(type, message) {
    'use strict';
        if (type === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: message
            })
        }else if (type === 'mixin') {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });

            Toast.fire({
              icon: 'success',
              title: 'Activated licenses successfully'
            })
        }
    }
});

$(document).ready(function() {
    $("#redeem").click(function(){
        var licenseKey = $("#licensekey").val();
        if (licenseKey.length < 1)
        {
            showSwal('error', 'Please enter a license key');
            return;
        }
        data = {
            key: licenseKey
        }

        $.post("/api/license/redeem", data,
        function(json){
            if (json.status != "success")
            {
                if (json.message == "Invalid session")
                {
                    window.location.href = "/auth/login";
                    return;
                }
                else
                    showSwal('error', json.message);
            }
            else
            {
                if (json.status == "success"){
                    $.getJSON('/api/license/fetch', function(data) {
                        $("#licenses-table tr").remove();
                        for (var i = 0; i < data.licenses.length; i++) {
                            var tr = '<tr>';
                            tr += '<td>' + data.licenses[i].product_name + '</td>';
                            tr += '<td>' + data.licenses[i].days_left + '</td>';
                            if (data.licenses[i].freezed != null){
                                tr += '<td><span class="badge bg-danger">Yes</span></td>';
                            }
                            else{
                                tr += '<td><span class="badge bg-success">No</span></td>';
                            }

                            tr += '</tr>';
                            $("#licenses-table").find('tbody').append(tr);
                            console.log(data.licenses[i].lid)
                        }
                    });
                    showSwal('mixin', 'Activated licenses successfully');
                }
            }
            $("#licensekey").val('');
        }
        );
    });
});
