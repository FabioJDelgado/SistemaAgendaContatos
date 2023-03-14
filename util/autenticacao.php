<?php

    session_start();

    $_SESSION['idUsuario'] = $_POST['idUsuario'];
    $_SESSION['nomeUsuario'] = $_POST['nome'];
    $_SESSION['fotoUsuario'] = $_POST['foto'];

    echo json_encode(array('status_code' => 1));
?>