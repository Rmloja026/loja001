<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once(__DIR__ . '/../api/db.php');
if(!isset($_SESSION['login'], $_SESSION['senha'], $_SESSION['tempo']) || $_SESSION['tempo'] < time()){
    header('Location: index.php?access=fail&id='.time());
    exit;
}

$chk_col = @mysqli_query($conn, "SHOW COLUMNS FROM config LIKE 'cartao_ativo'");
if (!$chk_col || mysqli_num_rows($chk_col) === 0) {
    @mysqli_query($conn, "ALTER TABLE config ADD COLUMN `cartao_ativo` TINYINT(1) DEFAULT 1");
}

$sql_config = mysqli_query($conn, "SELECT * FROM config ORDER BY id ASC LIMIT 1");
$row_config = $sql_config ? mysqli_fetch_array($sql_config) : [];
$lojinha = $row_config["nome"] ?? "Loja";
$cartao_ativo = isset($row_config["cartao_ativo"]) ? (int)$row_config["cartao_ativo"] : 1;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>Configuração de Cartão - <?php echo $lojinha; ?></title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
  <link id="pagestyle" href="./assets/css/black-theme.css?v=3.0.4" rel="stylesheet" />
  <link href="./assets/css/fix-labels.css" rel="stylesheet" />
  <style>
    .welcome-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      animation: fadeIn 0.5s ease;
    }
    .welcome-bar h2 {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--text-primary);
      letter-spacing: -0.02em;
    }
    .welcome-bar p {
      font-size: 0.8125rem;
      color: var(--text-muted);
      margin-top: 4px;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-200">
  <?php include 'sidebar.php'; ?>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Página</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Cartão</li>
          </ol>
          <h6 class="font-weight-bolder mb-0"><?php echo $lojinha; ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center ms-3">
              <a href="sair.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sair</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="welcome-bar">
        <div>
          <h2><i class="material-icons" style="vertical-align:bottom; font-size:28px;">credit_card</i> Cartão de Crédito</h2>
          <p>Ative ou desative o Cartão de Crédito no checkout da sua loja.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Opção Cartão de Crédito</h6>
            </div>
            <div class="card-body pt-4 p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                  <div class="d-flex flex-column">
                    <h6 class="mb-3 text-sm">Status do Cartão no Checkout</h6>
                    <span class="mb-2 text-xs">Ativando esta opção, a escolha de Cartão de Crédito ficará visível e disponível para seus clientes. Se desativar, somente o PIX aparecerá.</span>
                    <div class="form-check form-switch mt-3">
                      <input class="form-check-input" type="checkbox" id="cartao_ativo" <?php echo ($cartao_ativo == 1 ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="cartao_ativo">Ativar Cartão de Crédito</label>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <footer class="footer py-4">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>document.write(new Date().getFullYear())</script>,
                Desenvolvido com <i class="fa fa-heart"></i> por
                <a href="#" class="font-weight-bold" target="_blank">SKIP-DSN</a>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  
  <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toastSuccessMsg">
          Salvo com sucesso!
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    <div id="toastError" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toastErrorMsg">
          Erro ao salvar.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script>
  function showSuccess(msg) {
    document.getElementById('toastSuccessMsg').innerText = msg;
    var t = new bootstrap.Toast(document.getElementById('toastSuccess'));
    t.show();
  }
  function showError(msg) {
    document.getElementById('toastErrorMsg').innerText = msg;
    var t = new bootstrap.Toast(document.getElementById('toastError'));
    t.show();
  }
  
  function apiAdm(dados, callback) {
      var payload = btoa(unescape(encodeURIComponent(JSON.stringify(dados))));
      payload = payload.split("").reverse().join("");
      $.post("api_adm/index.php", { p: payload }, function(res) {
        try {
          var r = (typeof res === 'object') ? res : JSON.parse(res);
          if (callback) callback(r);
        } catch(e) {
          if (callback) callback({ok:false, error: 'Erro no parse do JSON.'});
        }
      }).fail(function() {
        if (callback) callback({ok:false, error: 'Erro de comunicação.'});
      });
  }

  $('#cartao_ativo').on('change', function() {
      var ativo = $(this).is(':checked') ? 1 : 0;
      apiAdm({ painel: 'cartao_config', ativo: ativo }, function(r) {
          if(r && r.ok) {
              showSuccess('Configuração de cartão salva com sucesso!');
          } else {
              showError(r.error || 'Erro ao salvar configuração.');
              // revert
              $('#cartao_ativo').prop('checked', !ativo);
          }
      });
  });

  var iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
  var iconSidenav = document.getElementById('iconSidenav');
  var sidenav = document.getElementById('sidenav-main');
  var body = document.getElementsByTagName('body')[0];
  var className = 'g-sidenav-pinned';

  if (iconNavbarSidenav) {
    iconNavbarSidenav.addEventListener("click", toggleSidenav);
  }
  if (iconSidenav) {
    iconSidenav.addEventListener("click", toggleSidenav);
  }

  function toggleSidenav() {
    if (body.classList.contains(className)) {
      body.classList.remove(className);
      setTimeout(function() {
        sidenav.classList.remove('bg-white');
      }, 100);
      sidenav.classList.remove('bg-transparent');
    } else {
      body.classList.add(className);
      sidenav.classList.add('bg-white');
      sidenav.classList.remove('bg-transparent');
      iconSidenav.classList.remove('d-none');
    }
  }
  </script>
</body>
</html>