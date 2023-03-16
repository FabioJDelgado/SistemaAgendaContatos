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
        $("#msgErro").html('Ocorreu um erro ao tentar cadastrar o usuário.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");
    } else{
        console.log("Sucesso: " + data.message);
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

function erroCadUsuario(request, status, error) {
    $("#msgErro").html('Ocorreu um erro no cadastro do usuário.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}