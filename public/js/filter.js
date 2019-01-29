function filter(component){
    var karakter = $(component).data('karakter');
    $(".navigasi").removeClass('active');
    if (karakter == "semua") {
        $(".characters").show();
        $(component).addClass('active');
    }
    else{
        $(".characters").hide();
        $("#"+karakter).show();
        $(component).addClass('active');
    }
}