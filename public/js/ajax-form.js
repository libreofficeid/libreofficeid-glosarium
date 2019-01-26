// klik tombol dengan class modalMd -> tampilkan data ke modal
$(document).on('click','.modalMd', function(event){
    event.preventDefault();
    ajaxLoad($(this).attr('value'),$(this).attr('value'));
});

function ajaxLoad(location,judul) {
    $.ajax({
        url: location,
        type: 'GET',
        contentType: false,
        success: function (result) {
            $("#modalMdContent").html(result);
            $("#modalMdTitle").html(result);
        },
        error: function(xhr, status, error){
            alert(xhr.responseText);
        }
    });
}