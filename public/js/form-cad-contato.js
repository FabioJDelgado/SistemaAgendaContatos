//funcao para mascarar o campo telefone
$(document).ready(function () { 
    $('#telefone').mask('(00) 00000-0000');
});

//funcao para cadastrar o contato
$(function(){
    $('#formCadContato').submit(function(){
        //verifica se os campos foram preenchidos
        if($('#nome').val().trim().length === 0 || $('#telefone').val().trim().length === 0 || $('#email').val().trim().length === 0){
            $("#msgErro").html('Preencha os campos necessários.');
            $("#modalErro").modal("show");

        //se os campos foram preenchidos, envia os dados para o controller
        } else{
            let dados = new FormData(this);
            const controllerUrl = "../controller/ContatoController.class.php";
            $.ajax({
                url: controllerUrl,
                type: "POST",
                data: dados,
                processData: false,
                cache: false,
                contentType: false,
                dataType: "JSON",
                success: successCadContato,
                error: erroCadContato
            });
        }
        return false;
    });
});

//funcao para tratar o retorno do cadastro de contato
function successCadContato(data) {
    //se o status_code for 0, exibe a mensagem de erro
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar cadastrar o contato.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");

    //se o status_code for 1, exibe a mensagem de sucesso
    } else{
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

//funcao para tratar o erro do cadastro de contato
function erroCadContato(request, status, error) {
    $("#msgErro").html('Ocorreu um erro no cadastro do contato.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}