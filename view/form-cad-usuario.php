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
    <link rel="stylesheet" href="../public/css/cad-usuario.css">

    <!-- Bootstrap CDN CSS -->    
    <?php echo GlobalConfig::$BOOTSTRAP_CSS_CDN ?>

    <title>SisAg - Sistema de Agenda</title>
</head>
<body class="fundo-tela">

    <div class="box-cad-usuario">
        <div class="text-center">
            <img src="../public/assets/sisag-logo.png" alt="" width="110" height="110">
            <h5>SisAg</h5>
        </div>
        <form class="form-cad-usuario" id="formCadUsuario">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required="true">
            </div>
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" id="login" name="login" required="true">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required="true">
            </div>
            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control input-file" id="foto" name="foto" required="true" accept="image/png,image/jpeg,image/jpg">
            </div>
            <input hidden type="text" name="_acao" value="cadastrar">
            <button type="submit" class="btn btn-primary" id="btnCadastrar">Cadastrar</button>
            <div class="a-cadastro">
                <spam>Já possui cadastro?</spam>
                <a href="./login.php" class="btn btn-link" id="btnCadastro">Logar</a>
            </div>
        </form>
    </div>

    <!-- Footer include -->
    <?php include_once  './footer.php'?>

    <script src="../public/js/form-cad-usuario.js"></script>
</body>
</html>
