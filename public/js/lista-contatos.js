$(document).ready(function () { 
    listaContatos();

    $("#telefoneAtt").mask("(00) 00000-0000");
});

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

function successListaContatos(data) {
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar listar os contatos.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");
    } else{
        try {
            if (Array.isArray(data)) {
                const size = data.length;
                if (size > 0) {
                    $('#hrListaContatos').attr('hidden', true);
                    $('#semContatos').attr('hidden', false);
                    $('#tblContatos').attr('hidden', false);
                    data.forEach(element => {
                        montaContatosTabela(element);
                    });
                } else {
                    //mensagem de não existem contatos cadastrados
                    $("#semContatos").html('Opss! Não existem contatos cadastrados');
                }                
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

function erroListaContatos(request, status, error) {
    $("#msgErro").html('Ocorreu um erro na recuperação dos contatos.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}

function montaContatosTabela(element){
    
    //cria a linha da tabela com template string
    let linha = `<tr>
                    <td><img src="${element.foto}" alt="" width="55" height="55"></td>
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

function retornaNomeImagen(foto) {
    var fileName = foto.split("\\");
    return fileName[fileName.length - 1];
}

function editarContato(nome, telefone, email, foto, idContato){
    $("#nomeAtt").val(nome);
    $("#telefoneAtt").val(telefone);
    $("#emailAtt").val(email);
    $("#fotoAtualAtt").attr("src", foto);
    $("#idContatoAtt").val(idContato);

    $("#modalEditarContato").modal("show");
}

function decisaoExcluirContato(id){
    $("#idContatoDel").val(id);
    $("#modalDecisaoExclusao").modal("show");
}

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

function successDeleteContato(data) {
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar deletar o contato.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");
    } else{
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

function erroDeleteContato(request, status, error) {
    $("#msgErro").html('Ocorreu um erro ao deletar o contato.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}

$(function(){
    $('#formAtualizaContato').submit(function(){
        if($('#nomeAtt').val().trim().length === 0 || $('#telefoneAtt').val().trim().length === 0 || $('#emailAtt').val().trim().length === 0){
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
                success: successAttContato,
                error: erroAttContato
            });
        }
        return false;
    });
});

function successAttContato(data) {
    if(data.status_code === 0){
        $("#msgErro").html('Ocorreu um erro ao tentar editar o contato.<br>Mensagem: ' + data.message);
        $("#modalErro").modal("show");
    } else{
        $("#modalEditarContato").modal("hide");
        $("#msgSucesso").html(data.message);
        $("#modalSucesso").modal("show");
    }
}

function erroAttContato(request, status, error) {
    $("#msgErro").html('Ocorreu um erro na edição do contato.<br>Mensagem: ' + error + '<br>Status ' + request.status + ': ' + request.statusText);
    $("#modalErro").modal("show");
}