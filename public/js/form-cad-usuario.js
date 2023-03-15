$(function(){
    $('#formCadUsuario').submit(function(){
        if($('#nome').val().trim().length === 0 || $('#login').val().trim().length === 0 || $('#senha').val().trim().length === 0){
            alert("Preencha todos os campos");
        } else{
            let dados = new FormData(this);
            const controllerUrl = "../controller/UsuarioController.class.php";
            $.ajax({
                url: controllerUrl,
                type: "POST",
                data: dados,
                processData: false,
                cache: false,
                contentType: false,
                dataType: "JSON",
                success: successCadUsario,
                error: erroCadUsuario
            });
        }
        return false;
    });
});

function successCadUsario(data) {
    if(data.status_code === 0){
        console.log("Erro: " + data.message);
        //colocar aqui um modal de alerta de insucesso
    } else{
        console.log("Sucesso: " + data.message);
        //colocar aqui um modal de alerta de sucesso
    }
}

function erroCadUsuario(request, status, error) {
    console.log(request.responseText);
    //colocar aqui um modal de alerta de erro
}