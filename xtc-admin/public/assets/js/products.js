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
                $.post("/api/products/delete",
                {
                    id: delId
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
                        $("#product-row-" + delId).remove();
                    }
                });

              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons.fire(
                  'Cancelled',
                  'The product is safe :)',
                  'error'
                )
              }
            })
        }
    }
});

$("#button-add-product").click(function(){
    if ($("#product-name").val() == "")
    {
        showSwal('error', 'Please enter a name for the product');
        return;
    }

    let product_name = $("#product-name").val();
    let file_name = $("#file-name").val();
    $("#button-add-product").prop("disabled", true);
    $.post("/api/products/store",
    {
        product_name: $("#product-name").val(),
        file_name: $("#file-name").val()
    },
    function(json){
        if (json.status == "error")
        {
            $("#addProductModal").modal("hide");
            showSwal('error', json.message);
            $("#button-add-product").prop("disabled", false);
        }
        else
        {
            $("#addProductModal").modal("hide");
            $("#product-name").val("");
            $("#button-add-product").prop("disabled", false);
            let trow = '<tr><td>' + json.id + '</td><td>' + product_name + '</td><td>' + file_name + '</td><td><button class="btn btn-danger">Delete</button></td></tr>';
            $('#productTable > tbody:first').append(trow);
            showSwal('mixin', json.message);
        }
    });
});

function deleteProduct(id)
{
    delId = id;
    showSwal('passing-parameter-execute-cancel', "");
}
