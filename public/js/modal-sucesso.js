//funcao para fechar o modal de sucesso, redirecionar para a pagina de login ou recarregar a pagina
$("#btnModalSucesso").click(function(){
    $("#modalSucesso").modal("hide");
    if(window.location.href === "http://localhost/sisag/view/form-cad-usuario.php"){
        window.location.href = "http://localhost/sisag/view/login.php";
    } else{
        window.location.reload();
    }
});