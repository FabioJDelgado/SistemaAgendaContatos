<?php

    session_start();

    $_SESSION['idUsuario'] = $_POST['idUsuario'];
    $_SESSION['nomeUsuario'] = $_POST['nome'];

    echo json_encode(array('status_code' => 1));
?>