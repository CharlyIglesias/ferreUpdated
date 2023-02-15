$(document).ready(function(){
    if(typeof window.location.href.split("#")[1] !== 'undefined'){
        var divId = window.location.href.split("#")[1];
        window.history.replaceState(null, null, window.location.pathname);
        myFunction2(divId, true);
    }
    $("#inputBusqueda").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            buscarProducto();    
        }
    });
});
    
function myFunction2(id, comesFromOtherPage = false){
    const speed = 1000;
    var targetElement = null;
    if(comesFromOtherPage){
        targetElement = document.getElementById(id);
    }else{
        targetElement = document.getElementById(id.id);
    }
    $('html, body').animate({ scrollTop: $(targetElement).offset().top - $("#nav").height() }, speed);
    // document.getElementById(targetElement.id).scrollIntoView(false)
}

$(".only-numbers-input").keypress(function( event ) {
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
});

function buscarProducto(){
    $('#buscarBtn').addClass('pressedBuscarBtn');

    var searchedText = $('#inputBusqueda').val();
    window.location.href = "/productos?search="+searchedText;
}


