
let formLogin = $("#formLogin").on("submit", validateForm);

function validateForm(event){
    if($(login).val().trim().length== 0 || $(senha).val().trim().length === 0){
        alert("Preencha os campos");
        event.preventDefault();
        return;
    }
    logar(event);
}

function logar(event){
    const controllerUrl = "../controller/UsuarioController.class.php";
    event.preventDefault();
    $.ajax({
        url: controllerUrl,
        type: "POST",
        data: $(formLogin).serialize(),
        dataType: "JSON",    
        success: successLogin,
        error: errorLogin
    });
};

function successLogin(request){
    if(request.status_code == 0){
        $("#msgErro").html(request.message);
        $("#modalErro").modal("show");
    } else{
        const controllerUrl = "../util/autenticacao.php";
        $.ajax({
            url: controllerUrl,
            type: "POST",
            data: {idUsuario: request[0].idUsuario, nome: request[0].nome, foto: request[0].foto},   
            success: successSession,
            error: errorSession
        });
    }
}

function errorLogin(request, status, error){
    $("#msgErro").html('Ocorreu um erro ao tentar efetuar o login.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}

function successSession(data){
    let session = JSON.parse(data);
    if(session.status_code == 1){
        window.location.href = "../view/boas-vindas.php";
    } else{
        $("#msgErro").html('Ocorreu um erro ao tentar iniciar a sessão.<br>Mensagem: ' + session.message);
        $("#modalErro").modal("show");
    }    
}

function errorSession(request, status, error){
    $("#msgErro").html('Ocorreu um erro ao iniciar a sessão.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}