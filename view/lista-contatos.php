<?php
    include_once '../config/GlobalConfig.php';

    session_start();
    if(!isset($_SESSION['idUsuario']) || !isset($_SESSION['nomeUsuario'])) {
        header('Location: http://localhost/sisag/view/login.php');
    }
    $userNome = $_SESSION['nomeUsuario'];
    $userFoto = $_SESSION['fotoUsuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" href=<?php echo '"'.GlobalConfig::$DEFAULT_DIR.'/'.GlobalConfig::$ASSETS_DIR.'/'.'favicon.ico"'; ?> >   

    <link rel="stylesheet" href="../public/css/geral.css">
    <link rel="stylesheet" href="../public/css/lista-contatos.css">
    <link rel="stylesheet" href="../public/css/modais.css">

    <!-- Bootstrap CDN CSS -->    
    <?php echo GlobalConfig::$BOOTSTRAP_CSS_CDN ?>
    <?php echo GlobalConfig::$FONTAWESOME_CSS_CDN ?>

    <title>SisAg - Sistema de Agenda</title>
</head>
<body class="fundo-tela">
    <div class="box-interno">
        <div>
            <!-- Header include -->
            <?php include_once './header.php'?>
        </div>
        <hr id="hrListaContatos">
        <h5 class="text-center" id="semContatos"></h5>
        <table class="table" id="tblContatos" hidden>
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody id="tbListaContatos">
            </tbody>
        </table>
    </div>

    <!-- Modal editar include -->
    <?php include_once  './modal-editar-contato.php'?>
    <?php include_once  './modal-decisao-exclusao.php'?>
    <?php include_once  './modal-erro.php'?>
    <?php include_once  './modal-sucesso.php'?>

    <!-- Footer include -->
    <?php include_once  './footer.php'?>

    <script src="../public/js/lista-contatos.js"></script>
    <script src="../public/js/modal-sucesso.js"></script>
</body>
</html>
