
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
    console.log(response);
}

function errorLogin(response){
    console.log(response);
}