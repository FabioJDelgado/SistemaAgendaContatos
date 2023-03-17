<nav class="site-header sticky-top py-1">
  <div class="container d-flex flex-column flex-md-row justify-content-between">
    <div class="div-header">
        <div class="div-menu">
            <div>
                <a class="nav-link" href="./boas-vindas.php">
                    <img src="../public/assets/sisag-logo.png" alt="" width="55" height="55">
                    <h5>SisAg</h5>
                </a>
            </div>
            <div class="div-acoes">
                <a class="nav-link" href="./form-cad-contato.php">Cadastrar Contato</a>
                <a class="nav-link" href="./lista-contatos.php">Listar Contatos</a>
            </div>
        </div>
        <div>
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <img src="<?php echo $userFoto ?>" alt="" width="55" height="55">
            </a>
            <div class="dropdown-menu">
                <span class="dropdown-item"><?php echo $userNome ?></span>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../util/logout.php">Sair</a>
            </div>
        </div>
    </div>
  </div>
</nav>