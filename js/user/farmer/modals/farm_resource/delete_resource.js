$(document).on('click', '.delete-resource', function(e) {
     // prevent default link behavior

    var id = $(this).data('delete-id');

    bootbox.confirm({
        message: "<h4>Are you sure remove this resource?</h4>",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: 'No',
                className: 'btn-secondary'
            }
        },
        callback: function (result) {
            if(result){
                $.post('/HarvestHub/user/farmer/farm/template/delete_resource.php', {
                    id: id
                })
                .done(function(data){
                    // SweetAlert success
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'The resource has been successfully deleted.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // reload the page after Swal closes
                        location.reload();
                    });
                })
                .fail(function() {
                    // SweetAlert error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Unable to delete the resource.',
                    });
                });
            }
        }

    });
});
