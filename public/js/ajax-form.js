// klik tombol dengan class modalMd -> tampilkan data ke modal
$(document).on('click','.modalMd', function(event){
    event.preventDefault();
    ajaxLoad($(this).attr('value'),$(this).attr('title'));
});
// klik tombol simpan/update di modalMd
$(document).on('click','#btnSubmit',function(event){
    event.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: $(this).parents('form').attr('action'),
        method: "post",
        data: $(this).parents('form').serializeArray(),
        success: function (result) {
            if (result.errors) {
                $('.alert-danger').html('');
                $.each(result.errors, function(key, value){
                    $('.alert-danger').show();
                    $('.alert-danger').append('<li>'+value+'</li>');
                });
            }
            else{
                $('.alert-danger').hide();
                $('#modalMd').modal('hide');
                toastr.success(result.status);
                // $('.alert-success').html(result.status);
                setTimeout(() => {
                    location.reload(true);
                }, 3000);
            }
        },
        error: function(xhr, status, error){
            alert(xhr.responseText);
        }
    });
})

function ajaxLoad(location,judul) {
    $("#modalMdContent").html("");
    $("#modalMdTitle").html("");
    $.ajax({
        url: location,
        type: 'GET',
        contentType: false,
        success: function (result) {
            $("#modalMdContent").html(result);
            $("#modalMdTitle").html(judul);
        },
        error: function(xhr, status, error){
            alert(xhr.responseText);
        }
    });
}