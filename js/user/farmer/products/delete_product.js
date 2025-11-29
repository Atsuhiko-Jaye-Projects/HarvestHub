document.addEventListener('DOMContentLoaded', function(){
    
    $(document).on('click', '.delete-object', function(){

        var id = $(this).data('delete-id');

        bootbox.confirm({
            message: "<h4>Are you sure remove this product?</h4>",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-primary'
                }
            },
        callback: function (result) {
            if(result){
                $.post('/HarvestHub/user/farmer/management/delete_product.php', {
                    object_id: id
                })
                .done(function(data){
                    // SweetAlert success
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'The Posted product has been successfully deleted.',
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
                        text: 'Unable to delete the product.',
                    });
                });
            }
        }

        });

        return false;
    });
});

