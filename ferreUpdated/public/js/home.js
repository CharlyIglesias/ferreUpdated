function sendToQuotation(){
    name     = $('#recipient-name').val();
    telefono = $('#recipient-telefono').val();
    message  = $('#message-text').val();
    email    = $('#recipient-email').val();

    var errors = false;
        if(name == ''){
            showToastr('warning', 'Error:', 'Ingresa un nombre válido.')
            errors = true;
        }
        if(telefono == '' || telefono.length != 10){
            showToastr('warning', 'Error:', 'Ingresa un número télefonico válido.')
            errors = true;
        }
        if(message == ''){
            showToastr('warning', 'Error:', 'Ingresa un mensaje válido.')
            errors = true;
        }
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        }else{
            showToastr('warning', 'Error:', 'Ingresa un email válido.')
            errors = true;
        }
        if(errors == false){
            $.get(receiveQuoteUrl, {name: name, telefono: telefono, message: message, email: email} ,function(data){
                if(data["error"] == "false"){
                    showToastr('warning', '¡Oops!', "Hubo un error, por favor intentalo nuevamente.");
                }else{
                    showToastr('success', 'Solicitud enviada correctamente.');
                    $('#recipient-name').val('');
                    $('#recipient-telefono').val('');
                    $('#message-text').val('');
                    $('#recipient-email').val('');
                }
            });
            
        }
}

function sendMessage(){
    name        = $('#inputName').val();
    asunto      = $('#inputAsunto').val();
    description = $('#inputDescription').val();
    email       = $('#inputEmail').val();

    var errors = false;
        if(name == ''){
            showToastr('warning', 'Error:', 'Ingresa un nombre válido.')
            errors = true;
        }
        if(asunto == ''){
            showToastr('warning', 'Error:', 'Ingresa un asunto válido.')
            errors = true;
        }
        if(description == ''){
            showToastr('warning', 'Error:', 'Ingresa un mensaje válido.')
            errors = true;
        }
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        }else{
            showToastr('warning', 'Error:', 'Ingresa un email válido.')
            errors = true;
        }
        if(errors == false){
            $.get(sendMessageUrl, {name: name, asunto: asunto, description: description, email: email} ,function(data){
                if(data["error"] == "false"){
                    showToastr('warning', '¡Oops!', 'Hubo un error, por favor intentalo nuevamente.');
                }else{
                    showToastr('success', 'Mensaje enviado correctamente.');
                    $('#inputName').val('');
                    $('#inputAsunto').val('');
                    $('#inputDescription').val('');
                    $('#inputEmail').val('');
                }
            });
        }
}