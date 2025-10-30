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

                if(result==true){
                    $.post('/HarvestHub/user/farmer/management/delete_product.php', {
                        object_id: id,
                    }, function(data){
                        alert('Product Deleted');
                        location.reload();
                    }).fail(function() {
                        alert('Unable to delete.');
                    });
                }
            }
        });

        return false;
    });
});