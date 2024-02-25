let delId = 0;

$(function() {
    showSwal = function(type, message) {
        'use strict';


        if (type === 'passing-parameter-execute-cancel')
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
                window.location.href = "/licenses/delete?lid=" + delId;

              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'The license is safe :)',
                  'error'
                )
              }
            })
        }
    }
});

function deleteLicense(id)
{
    delId = id;
    showSwal('passing-parameter-execute-cancel', "");
}
