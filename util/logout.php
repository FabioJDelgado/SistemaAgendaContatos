<?php
    //termina a sessao e redireciona para a pagina de login
    session_start();
    session_destroy();
    header('Location: http://localhost/sisag/view/login.php');
?>