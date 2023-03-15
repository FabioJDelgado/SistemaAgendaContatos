
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

function successLogin(response){
    if(response.status_code == 0){
        console.log(response.message);
    } else{
        const controllerUrl = "../util/autenticacao.php";
        $.ajax({
            url: controllerUrl,
            type: "POST",
            data: {idUsuario: response[0].idUsuario, nome: response[0].nome, foto: response[0].foto},   
            success: successSession,
            error: errorSession
        });
    }
}

function errorLogin(response){
    console.log(response);
    //colocar aqui um modal de alerta de erro no login
}

function successSession(response){
    let session = JSON.parse(response);
    if(session.status_code == 1){
        window.location.href = "../view/boas-vindas.php";
    } else{
        console.log(session);
        //colocar aqui um modal de alerta de insucesso
    }    
}

function errorSession(response){
    console.log(response);
    //colocar aqui um modal de alerta de erro
}