<?php
    include_once '../config/GlobalConfig.php';
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
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/modais.css">

    <!-- Bootstrap CDN CSS -->    
    <?php echo GlobalConfig::$BOOTSTRAP_CSS_CDN ?>

    <title>SisAg - Sistema de Agenda</title>
</head>
<body class="fundo-tela">
    <div class="box-login">
        <div class="text-center">
            <img src="../public/assets/sisag-logo.png" alt="" width="110" height="110">
            <h5>SisAg</h5>
        </div>
        <form class="form-login" id="formLogin">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" id="login" name="login" required="true">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required="true">
            </div>
            <input hidden type="text" name="_acao" value="logar">
            <button type="submit" class="btn btn-primary" id="btnLogar">Entrar</button>
            <a href="./form-cad-usuario.php" class="a-cadastro" id="btnCadastro">Cadastre-se</a>
        </form>
    </div>

    <?php include_once  './modal-erro.php'?>
    <?php include_once  './modal-sucesso.php'?>

    <!-- Footer include -->
    <?php include_once  './footer.php'?>
    
    <script src="../public/js/login.js"></script>
    <script src="../public/js/modal-sucesso.js"></script>
</body>
</html>
