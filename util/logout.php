<?php
    session_start();
    session_destroy();
    header('Location: http://localhost/sisag/view/login.php');
?>