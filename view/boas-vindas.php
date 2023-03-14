<?php
    include_once '../config/GlobalConfig.php';

    session_start();
    if(!isset($_SESSION['idUsuario']) || !isset($_SESSION['nomeUsuario'])) {
        header('Location: http://localhost/sisag/view/login.php');
    }
    $userName = $_SESSION['nomeUsuario'];
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

    <!-- Bootstrap CDN CSS -->    
    <?php echo GlobalConfig::$BOOTSTRAP_CSS_CDN ?>

    <title>SisAg - Sistema de Agenda</title>
</head>
<body class="fundo-tela">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Bem vindo, <?php echo $userName; ?>!</h1>
            </div>
        </div>
    </div>


    <!-- Jquery -->
    <?php echo GlobalConfig::$JQUERY_CDN ?>
    
    <!-- Bootstrap Js -->
    <?php echo GlobalConfig::$BOOTSTRAP_JS_CDN ?>

    <!-- Fontawesome Js -->
    <?php echo GlobalConfig::$FONTAWESOME_CDN ?>

    <!-- Pooper -->
    <?php echo GlobalConfig::$POOPER_JS_CDN ?>
</body>
</html>