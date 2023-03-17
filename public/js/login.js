
//captura acao de submit do formulario
let formLogin = $("#formLogin").on("submit", validateForm);

//valida os campos do formulario
function validateForm(event){
    if($(login).val().trim().length== 0 || $(senha).val().trim().length === 0){
        $("#msgErro").html('Preencha os campos necessários.');
        $("#modalErro").modal("show");
        event.preventDefault();
        return;
    }
    logar(event);
}

//funcao para efetuar o login
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

//funcao para tratar o retorno do login
function successLogin(request){
    //se o status_code for 0, exibe a mensagem de erro
    if(request.status_code == 0){
        $("#msgErro").html(request.message);
        $("#modalErro").modal("show");

    //se o status_code for 1, inicia a sessao
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

//funcao para tratar o erro do login
function errorLogin(request, status, error){
    $("#msgErro").html('Ocorreu um erro ao tentar efetuar o login.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}

//funcao para tratar retorno da sessao
function successSession(data){
    let session = JSON.parse(data);
    
    //se o status_code for 1, redireciona para a pagina de boas vindas
    if(session.status_code == 1){
        window.location.href = "../view/boas-vindas.php";

    //se o status_code for 0, exibe a mensagem de erro
    } else{
        $("#msgErro").html('Ocorreu um erro ao tentar iniciar a sessão.<br>Mensagem: ' + session.message);
        $("#modalErro").modal("show");
    }    
}

//funcao para tratar o erro ao iniciar a sessao
function errorSession(request, status, error){
    $("#msgErro").html('Ocorreu um erro ao iniciar a sessão.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}