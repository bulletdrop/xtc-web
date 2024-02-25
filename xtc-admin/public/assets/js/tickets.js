let delId = 0;

$(function() {
    showSwal = function(type, message) {
        'use strict';
        if (type === 'error')
        {
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: message
            });
        }
        else if (type === 'mixin')
        {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })

            Toast.fire({
                icon: 'success',
                title: message
            })
        }

        else if (type === 'passing-parameter-execute-cancel')
        {
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger me-2'
              },
              buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonClass: 'me-2',
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                console.log(delId);
                $.post("/api/tickets/delete",
                {
                    tid: delId
                },
                function(json){
                    console.log(json)
                    if (json.status == "error")
                    {
                        showSwal('error', json.message);
                    }
                    else
                    {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            json.message,
                            'success'
                        )
                        $("#ticket-row-" + delId).remove();
                    }
                });

              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'The ticket is safe :)',
                  'error'
                )
              }
            })
        }
    }
});

function deleteTicket(id)
{
    delId = id;
    showSwal('passing-parameter-execute-cancel', "");
}
