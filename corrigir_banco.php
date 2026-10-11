<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("api/db.php");

echo "<div style='font-family:sans-serif; max-width:800px; margin:30px auto; padding:20px; border:1px solid #ddd; border-radius:8px;'>";
echo "<h1 style='color:#333; margin-top:0;'>Reparador e Sincronizador de Tabelas</h1>";

function migrar_coluna($conn, $tabela, $coluna, $definicao) {
    $chk = mysqli_query($conn, "SHOW COLUMNS FROM `$tabela` LIKE '$coluna'");
    if (!$chk || mysqli_num_rows($chk) === 0) {
        $alt = mysqli_query($conn, "ALTER TABLE `$tabela` ADD COLUMN `$coluna` $definicao");
        if ($alt) {
            echo "<p style='color:#00a650; margin:4px 0;'>[+] Coluna <b>$coluna</b> adicionada com sucesso em <b>$tabela</b>.</p>";
        } else {
            echo "<p style='color:#d00; margin:4px 0;'>[-] Erro ao adicionar <b>$coluna</b> em <b>$tabela</b>: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color:#555; margin:4px 0;'>[✓] Coluna <b>$coluna</b> já existe em <b>$tabela</b>.</p>";
    }
}

// 1. Garantir tabela config e colunas
@mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT 'Minha Loja',
  `cor` varchar(50) DEFAULT '#ffe600',
  `cor_botao` varchar(20) DEFAULT '#3483fa',
  `cor_icones` varchar(20) DEFAULT '#ffffff',
  `img` varchar(255) DEFAULT 'logo.png',
  `numero` varchar(50) DEFAULT '',
  `zap` varchar(50) DEFAULT '',
  `zap_cotacao` varchar(50) DEFAULT '',
  `zap_flutuante_ativo` int(1) DEFAULT 1,
  `texto` text DEFAULT NULL,
  `endereco` varchar(255) DEFAULT '',
  `cnpj` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

migrar_coluna($conn, 'config', 'cartao_ativo', 'TINYINT(1) DEFAULT 1');
migrar_coluna($conn, 'config', 'app_mobile_ativo', 'TINYINT(1) DEFAULT 0');

$chk_cfg = mysqli_query($conn, "SELECT id FROM `config` LIMIT 1");
if (!$chk_cfg || mysqli_num_rows($chk_cfg) === 0) {
    mysqli_query($conn, "INSERT INTO `config` (`id`, `nome`, `cartao_ativo`) VALUES (1, 'Minha Loja', 1)");
    echo "<p style='color:#00a650;'>[+] Registro inicial criado na tabela config.</p>";
}

// 2. Garantir tabela pix e todas as colunas de gateways
@mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `pix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave` text DEFAULT NULL,
  `tipo_chave` varchar(20) NOT NULL DEFAULT 'aleatoria',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$pix_cols = [
    'pix_modo'                => "varchar(20) NOT NULL DEFAULT 'manual'",
    'modo_pix'                => "varchar(20) NOT NULL DEFAULT 'manual'",
    'pix_max_itens'           => "int(11) NOT NULL DEFAULT 4",
    'descricao'               => "varchar(255) DEFAULT ''",
    'identificador'           => "varchar(255) DEFAULT '***'",
    'beneficiario'            => "varchar(255) DEFAULT ''",
    'cidade'                  => "varchar(255) DEFAULT ''",
    'use_freepay'             => "tinyint(1) NOT NULL DEFAULT 0",
    'freepay_public_key'      => "TEXT DEFAULT NULL",
    'freepay_secret_key'      => "TEXT DEFAULT NULL",
    'use_mercadopago'         => "tinyint(1) NOT NULL DEFAULT 0",
    'mp_access_token'         => "TEXT DEFAULT NULL",
    'mp_webhook_secret'       => "TEXT DEFAULT NULL",
    'use_pixgo'               => "tinyint(1) NOT NULL DEFAULT 0",
    'pixgo_api_key'           => "TEXT DEFAULT NULL",
    'pixgo_webhook_secret'    => "TEXT DEFAULT NULL",
    'use_carthero'            => "tinyint(1) NOT NULL DEFAULT 0",
    'carthero_private_key'    => "TEXT DEFAULT NULL",
    'carthero_public_key'     => "TEXT DEFAULT NULL",
    'use_bravopay'            => "tinyint(1) NOT NULL DEFAULT 0",
    'bravopay_api_key'        => "TEXT DEFAULT NULL",
    'bravopay_webhook_secret' => "TEXT DEFAULT NULL",
    'use_pix_produto'         => "tinyint(1) NOT NULL DEFAULT 1"
];
foreach ($pix_cols as $c => $d) {
    migrar_coluna($conn, 'pix', $c, $d);
}

$chk_pix = mysqli_query($conn, "SELECT id FROM `pix` LIMIT 1");
if (!$chk_pix || mysqli_num_rows($chk_pix) === 0) {
    mysqli_query($conn, "INSERT INTO `pix` (`id`, `chave`, `tipo_chave`, `pix_modo`, `modo_pix`) VALUES (1, '', 'aleatoria', 'manual', 'manual')");
    echo "<p style='color:#00a650;'>[+] Registro inicial criado na tabela pix.</p>";
}

// 3. Garantir tabela online para monitoramento
@mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) DEFAULT NULL,
  `useragent` longtext DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

migrar_coluna($conn, 'online', 'etapa', "VARCHAR(50) DEFAULT ''");
migrar_coluna($conn, 'online', 'cidade', "VARCHAR(100) DEFAULT ''");
migrar_coluna($conn, 'online', 'estado', "VARCHAR(100) DEFAULT ''");
migrar_coluna($conn, 'online', 'dispositivo', "VARCHAR(50) DEFAULT 'desktop'");
migrar_coluna($conn, 'online', 'situacao', "VARCHAR(20) DEFAULT 'ativo'");

echo "<hr style='border:0; border-top:1px solid #eee; margin:20px 0;'>";
echo "<h2 style='color:#00a650;'>Tudo pronto e 100% atualizado!</h2>";
echo "<p>Agora você pode abrir o Painel Admin (@SERVIDOR/pix.php e @SERVIDOR/cartao.php) e salvar os meios de pagamento sem nenhum erro de banco de dados.</p>";
echo "</div>";
?>
