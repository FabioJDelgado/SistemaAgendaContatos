$(document).ready(function () { 
    $('#telefone').mask('(00) 00000-0000');
});

$(function(){
    $('#formCadContato').submit(function(){
        if($('#nome').val().trim().length === 0 || $('#telefone').val().trim().length === 0 || $('#email').val().trim().length === 0){
            alert("Preencha todos os campos");
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

function successCadContato(data) {
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar cadastrar o contato.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");
    } else{
        console.log("Sucesso: " + data.message);
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

function erroCadContato(request, status, error) {
    $("#msgErro").html('Ocorreu um erro no cadastro do contato.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}