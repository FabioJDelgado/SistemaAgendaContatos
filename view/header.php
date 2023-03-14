<nav class="site-header sticky-top py-1">
  <div class="container d-flex flex-column flex-md-row justify-content-between">
    <div class="div-header">
        <div>
            <img src="../public/assets/sisag-logo.png" alt="" width="55" height="55">
            <h5>SisAg</h5>
        </div>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Cadastrar Contato</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Listar Contatos</a>
            </li>
            </li>
        </ul>
    </div>
    <div>
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
            <img src="<?php echo $userFoto ?>" alt="" width="55" height="55">
        </a>
        <div class="dropdown-menu">
            <span><?php echo $userNome ?></span>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../util/logout.php">Sair</a>
        </div>
    </div>
  </div>
</nav>