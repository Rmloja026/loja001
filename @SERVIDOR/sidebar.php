<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidenav border-0 border-radius-xl my-3 fixed-start ms-3 bg-dark-sidebar" id="sidenav-main" style="display: flex; flex-direction: column; overflow: hidden; z-index: 1050; padding: 0;">
  
  <div style="flex-shrink: 0; background: inherit; position: relative; z-index: 2; border-bottom: 1px solid rgba(255,255,255,0.1);">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="dashboard.php" style="display: block; padding: 20px; text-decoration: none;">
      <span class="ms-1 font-weight-bold text-white" style="font-size: 1.2rem;">🚀 Dashboard</span>
    </a>
  </div>

  <div style="flex: 1; overflow-y: auto; padding: 15px 0;">
    <ul class="navbar-nav" style="list-style: none; padding: 0; margin: 0; display: block;">
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'cadastros.php') ? 'active bg-blue-accent' : ''; ?>" href="cadastros.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">assignment_ind</i></div>
          <span class="nav-link-text ms-1">Cadastros</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'produtos.php') ? 'active bg-blue-accent' : ''; ?>" href="produtos.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">local_grocery_store</i></div>
          <span class="nav-link-text ms-1">Produtos</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'add_produto.php' || $currentPage == 'edit_produto.php') ? 'active bg-blue-accent' : ''; ?>" href="add_produto.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">add_circle</i></div>
          <span class="nav-link-text ms-1">Adicionar Produto</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'estatisticas.php') ? 'active bg-blue-accent' : ''; ?>" href="estatisticas.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">insert_chart</i></div>
          <span class="nav-link-text ms-1">Estatísticas</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'bloqueados.php') ? 'active bg-blue-accent' : ''; ?>" href="bloqueados.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">key</i></div>
          <span class="nav-link-text ms-1">Bloqueados</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'administrador.php') ? 'active bg-blue-accent' : ''; ?>" href="administrador.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">person</i></div>
          <span class="nav-link-text ms-1">Administrador</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'pix.php') ? 'active bg-blue-accent' : ''; ?>" href="pix.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">paid</i></div>
          <span class="nav-link-text ms-1">Config Pix</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'config.php') ? 'active bg-blue-accent' : ''; ?>" href="config.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">storefront</i></div>
          <span class="nav-link-text ms-1">Config Loja</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'apis.php') ? 'active bg-blue-accent' : ''; ?>" href="apis.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">notification_important</i></div>
          <span class="nav-link-text ms-1">Config Apis</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'pixel.php') ? 'active bg-blue-accent' : ''; ?>" href="pixel.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">track_changes</i></div>
          <span class="nav-link-text ms-1">Pixel Facebook</span>
        </a>
      </li>

      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white <?php echo ($currentPage == 'config_catalogo.php') ? 'active bg-blue-accent' : ''; ?>" href="config_catalogo.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">view_carousel</i></div>
          <span class="nav-link-text ms-1">Configurar Catálogo</span>
        </a>
      </li>

      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white" href="../catalogo.php" target="_blank" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">storefront</i></div>
          <span class="nav-link-text ms-1">Ver Catálogo</span>
        </a>
      </li>
      
      <li class="nav-item" style="margin: 5px 10px;">
        <a class="nav-link text-white" href="sair.php" style="display: flex; align-items: center; padding: 12px 15px; border-radius: 6px; text-decoration: none;">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">login</i></div>
          <span class="nav-link-text ms-1">Sair</span>
        </a>
      </li>
      
    </ul>
  </div>
  
  <div class="w-100 mt-auto" style="flex-shrink: 0; padding: 20px;">
    <a class="btn bg-blue-accent w-100" href="https://api.whatsapp.com/send?phone=5513996514973&text=Oi%20SKIP-DSN" target="_blank" type="button" style="border: none; color: white; background: var(--accent-primary); border-radius: 8px; padding: 10px 0; margin: 0;">Falar com SKIP-DSN</a>
  </div>
</aside>
