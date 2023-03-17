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
    <link rel="stylesheet" href="../public/css/cad-contato.css">
    <link rel="stylesheet" href="../public/css/modais.css">
    <link rel="stylesheet" href="../public/css/header.css">

    <!-- Bootstrap CDN CSS -->    
    <?php echo GlobalConfig::$BOOTSTRAP_CSS_CDN ?>

    <title>SisAg - Sistema de Agenda</title>
</head>
<body class="fundo-tela">
    <div class="box-interno">
        <div>
            <!-- Header include -->
            <?php include_once './header.php'?>
        </div>
        <hr>
        <form class="form-cad-contato" id="formCadContato">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required="true">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required="true">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required="true">
            </div>
            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control input-file" id="foto" name="foto" required="true" accept="image/png,image/jpeg,image/jpg">
            </div>
            <input hidden type="text" name="_acao" value="cadastrar">
            <button type="submit" class="btn btn-primary" id="btnCadastrar">Cadastrar</button>
        </form>
    </div>

    <?php include_once  './modal-erro.php'?>
    <?php include_once  './modal-sucesso.php'?>

    <!-- Footer include -->
    <?php include_once  './footer.php'?>

    <script src="../public/js/form-cad-contato.js"></script>
    <script src="../public/js/modal-sucesso.js"></script>
</body>
</html>
