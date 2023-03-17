//chama funcao de listar os contatos e coloca mascara no campo de telefone
$(document).ready(function () { 
    listaContatos();

    $("#telefoneAtt").mask("(00) 00000-0000");
});

//funcao para listar os contatos
function listaContatos() {
    const urlController = "../controller/ContatoController.class.php";
    $.ajax({
        url: urlController,
        type: "GET",
        data: {_acao: "listar"},
        dataType: "json",
        success: successListaContatos,
        error: erroListaContatos
    });
}

//funcao para tratar o retorno da listagem de contatos
function successListaContatos(data) {
    //se o status_code for 0, exibe a mensagem de erro
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar listar os contatos.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");

    //se o status_code for 1, lista os contatos
    } else{
        //try catch para tratar erros de execucao
        try {
            //verifica se o retorno é um array
            if (Array.isArray(data)) {
                const size = data.length;

                //se o array tiver tamanho maior que 0, lista os contatos
                if (size > 0) {
                    $('#hrListaContatos').attr('hidden', true);
                    $('#semContatos').attr('hidden', false);
                    $('#tblContatos').attr('hidden', false);
                    data.forEach(element => {
                        montaContatosTabela(element);
                    });

                //se o array tiver tamanho igual a 0, exibe mensagem de que não existem contatos cadastrados
                } else {
                    $("#semContatos").html('Opss! Não existem contatos cadastrados');
                }               
            
            //se o retorno não for um array, exibe a mensagem de erro
            } else {
                $("#msgErro").html('Ocorreu um erro ao tentar recuperar os contatos.<br>Mensagem: ' + data.message);
                $("#modalErro").modal("show");
            }
        } catch(e) {  
            $("#msgErro").html('Ocorreu um erro ao tentar listar os os contatos.<br>Mensagem: ' + e.message);
            $("#modalErro").modal("show");                   
        }
    }
}

//funcao para tratar o erro da listagem de contatos
function erroListaContatos(request, status, error) {
    $("#msgErro").html('Ocorreu um erro na recuperação dos contatos.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}

//funcao para montar a tabela de contatos
function montaContatosTabela(element){
    
    //cria a linha da tabela com template string
    let linha = `<tr>
                    <td><img class="img-tb-contato" src="${element.foto}" alt=""></td>
                    <td>${element.nome}</td>
                    <td>${element.telefone}</td>
                    <td>${element.email}</td>
                    <td>
                        <button class="btn btn-info" onclick="editarContato('${element.nome}', '${element.telefone}', '${element.email}', '${element.foto}', ${element.idContato})"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-danger" onclick="decisaoExcluirContato(${element.idContato})"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>`;

    //adiciona a linha na tabela
    $("#tbListaContatos").append(linha);

    linha = "";
}

//funcao para abrir o modal de confirmacao de exclusao de contato
function decisaoExcluirContato(id){
    $("#idContatoDel").val(id);
    $("#modalDecisaoExclusao").modal("show");
}

//funcao para excluir o contato
function excluirContato(){
    $("#modalDecisaoExclusao").modal("hide");
    let idContato = $("#idContatoDel").val();
    const urlController = "../controller/ContatoController.class.php";
    $.ajax({
        url: urlController,
        type: "POST",
        data: {_acao: "deletar", idContato: idContato},
        dataType: "json",
        success: successDeleteContato,
        error: erroDeleteContato
    });
}

//funcao para tratar o retorno da exclusao de contato
function successDeleteContato(data) {
    //se o status_code for 0, exibe a mensagem de erro
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar deletar o contato.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");

    //se o status_code for 1, exibe a mensagem de sucesso
    } else{
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

//funcao para tratar o erro da exclusao de contato
function erroDeleteContato(request, status, error) {
    $("#msgErro").html('Ocorreu um erro ao deletar o contato.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}

//funcao para abrir o modal de edicao de contato
function editarContato(nome, telefone, email, foto, idContato){
    $("#nomeAtt").val(nome);
    $("#telefoneAtt").val(telefone);
    $("#emailAtt").val(email);
    $("#fotoAtualAtt").attr("src", foto);
    $("#idContatoAtt").val(idContato);

    $("#modalEditarContato").modal("show");
}

//funcao para atualizar o contato
$(function(){
    $('#formAtualizaContato').submit(function(){
        //verifica se os campos foram preenchidos
        if($('#nomeAtt').val().trim().length === 0 || $('#telefoneAtt').val().trim().length === 0 || $('#emailAtt').val().trim().length === 0){
            alert("Preencha todos os campos");

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
                success: successAttContato,
                error: erroAttContato
            });
        }
        return false;
    });
});

//funcao para tratar o retorno da edicao de contato
function successAttContato(data) {
    //se o status_code for 0, exibe a mensagem de erro
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar editar o contato.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");
    
    //se o status_code for 1, exibe a mensagem de sucesso
    } else{
        $("#modalEditarContato").modal("hide");
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

//funcao para tratar o erro da edicao de contato
function erroAttContato(request, status, error) {
    $("#msgErro").html('Ocorreu um erro na edição do contato.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}