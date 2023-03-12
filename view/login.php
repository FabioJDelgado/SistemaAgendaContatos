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

    <!-- Bootstrap CDN CSS -->    
    <?php echo GlobalConfig::$BOOTSTRAP_CSS_CDN ?>

    <title>SisAg - Sistema de Agenda</title>
</head>
<body>

    <div>

    </div>
    
    <!-- Bootstrap Js -->
    <?php echo GlobalConfig::$BOOTSTRAP_JS_CDN ?>

    <!-- Fontawesome Js -->
    <?php echo GlobalConfig::$FONTAWESOME_CDN ?>

    <!-- Jquery -->
    <?php echo GlobalConfig::$JQUERY_CDN ?>

    <!-- Pooper -->
    <?php echo GlobalConfig::$POOPER_JS_CDN ?>
</body>
</html>
