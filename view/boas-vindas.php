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
        
        <h5 class="text-center">Sistema de Agenda</h5>
        
    </div>

    <!-- Footer include -->
    <?php include_once  './footer.php'?>

</body>
</html>
