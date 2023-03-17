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
    <link rel="stylesheet" href="../public/css/modais.css">

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
                <label for="senhaRe">Repita a senha</label>
                <input type="password" class="form-control" id="senhaRe" name="senhaRe" required="true">
            </div>
            <div class="form-group">
                <label for="foto">Foto</label>
                <div class="input-file">
                    <input type="file" class="form-control" id="foto" name="foto" required="true" accept="image/png,image/jpeg,image/jpg">
                </div>    
            </div>
            <input hidden type="text" name="_acao" value="cadastrar">
            <button type="submit" class="btn btn-primary" id="btnCadastrar">Cadastrar</button>
            <label class="a-cadastro">Já possui cadastro? <a href="./login.php" id="btnCadastro">Logar</a></label>     
        </form>
    </div>

    <?php include_once  './modal-erro.php'?>
    <?php include_once  './modal-sucesso.php'?>

    <!-- Footer include -->
    <?php include_once  './footer.php'?>
    
    <script src="../public/js/form-cad-usuario.js"></script>
    <script src="../public/js/modal-sucesso.js"></script>
</body>
</html>
