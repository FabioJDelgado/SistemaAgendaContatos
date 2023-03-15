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
        console.log("Erro: " + data.message);
        //colocar aqui um modal de alerta de insucesso
    } else{
        console.log("Sucesso: " + data.message);
        //colocar aqui um modal de alerta de sucesso
        //por no modal um botão para dar reload na pagina
    }
}

function erroCadContato(request, status, error) {
    console.log(request.responseText);
    //colocar aqui um modal de alerta de erro
}