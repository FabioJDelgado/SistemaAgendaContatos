//funcao para cadastrar um novo usuario
$(function(){
    $('#formCadUsuario').submit(function(){
        //verifica se os campos foram preenchidos
        if($('#nome').val().trim().length === 0 || $('#login').val().trim().length === 0 || $('#senha').val().trim().length === 0 || $('#senhaRe').val().trim().length === 0){
            $("#msgErro").html('Preencha os campos necessários.');
            $("#modalErro").modal("show");

        //verifica se as senhas conferem
        } else if($('#senha').val() !== $('#senhaRe').val()){
            $("#msgErro").html('As senhas não conferem.');
            $("#modalErro").modal("show");

        //se os campos foram preenchidos e os dados estao corretos, envia os dados para o controller
        } else {
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

//funcao para tratar o retorno do cadastro de usuario
function successCadUsario(data) {
    //se o status_code for 0, exibe a mensagem de erro
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar cadastrar o usuário.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");

    //se o status_code for 1, exibe a mensagem de sucesso
    } else{
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

//funcao para tratar o erro do cadastro de usuario
function erroCadUsuario(request, status, error) {
    $("#msgErro").html('Ocorreu um erro no cadastro do usuário.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}