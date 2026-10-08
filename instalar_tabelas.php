<?php
require_once("api/db.php");

echo "<h1>Criador de Tabelas Ausentes</h1>";

$queries = [
    "CREATE TABLE IF NOT EXISTS `produto` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `codigo` varchar(100) DEFAULT NULL,
      `tipo_produto` varchar(50) DEFAULT 'generico',
      `categoria` varchar(100) DEFAULT 'Geral',
      `nome` varchar(255) DEFAULT NULL,
      `valor` varchar(20) DEFAULT NULL,
      `valor_original` varchar(20) DEFAULT NULL,
      `img` varchar(255) DEFAULT NULL,
      `img1` varchar(255) DEFAULT NULL,
      `img2` varchar(255) DEFAULT NULL,
      `img3` varchar(255) DEFAULT NULL,
      `img4` varchar(255) DEFAULT NULL,
      `img5` varchar(255) DEFAULT NULL,
      `img6` varchar(255) DEFAULT NULL,
      `oferta` varchar(10) DEFAULT '0',
      `desconto` varchar(10) DEFAULT '0',
      `descricao` text DEFAULT NULL,
      `caracteristicas` text DEFAULT NULL,
      `reviews` longtext DEFAULT NULL,
      `variacoes` longtext DEFAULT NULL,
      `venda` varchar(10) DEFAULT '0',
      `cliques` varchar(10) DEFAULT '0',
      `pix_copia_e_cola` text DEFAULT NULL,
      `status` varchar(50) DEFAULT 'ativo',
      `destaque_catalogo` tinyint(1) DEFAULT 0,
      `ordem` int(11) NOT NULL DEFAULT 999,
      `produtos_relacionados` varchar(255) DEFAULT '',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `produto_pix_codigos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `produto_codigo` varchar(100) NOT NULL,
      `pix_codigo` text NOT NULL,
      `status` varchar(20) NOT NULL DEFAULT 'disponivel',
      `data_cadastro` timestamp NULL DEFAULT current_timestamp(),
      `data_uso` datetime DEFAULT NULL,
      `cliente_ip` varchar(100) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `vendas_confirmadas` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `produto_codigo` varchar(100) NOT NULL,
      `cliente_ip` varchar(100) NOT NULL,
      `transaction_id` varchar(128) NOT NULL,
      `valor` varchar(20) NOT NULL DEFAULT '0',
      `data_venda` timestamp NULL DEFAULT current_timestamp(),
      `status` varchar(20) NOT NULL DEFAULT 'PAID',
      `gateway` varchar(30) NOT NULL DEFAULT 'mercadopago',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `acesso` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `login` varchar(100) DEFAULT NULL,
      `senha` varchar(100) DEFAULT NULL,
      `acesso` varchar(100) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `apis` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `pixel` varchar(255) DEFAULT NULL,
      `token_wpp` varchar(255) DEFAULT NULL,
      `instancia_wpp` varchar(255) DEFAULT NULL,
      `msg_wpp` text DEFAULT NULL,
      `status_wpp` varchar(20) DEFAULT 'inativo',
      `smtp_host` varchar(255) DEFAULT NULL,
      `smtp_user` varchar(255) DEFAULT NULL,
      `smtp_pass` varchar(255) DEFAULT NULL,
      `smtp_port` varchar(10) DEFAULT NULL,
      `smtp_ativo` tinyint(1) DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `config` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(255) DEFAULT NULL,
      `logo` varchar(255) DEFAULT NULL,
      `favicon` varchar(255) DEFAULT NULL,
      `cor` varchar(50) DEFAULT NULL,
      `tema` varchar(50) DEFAULT 'escuro',
      `app_mobile_ativo` tinyint(1) DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `bloqueados` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `ip` varchar(50) DEFAULT NULL,
      `motivo` varchar(255) DEFAULT NULL,
      `data` datetime DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `catalogo_banners` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `imagem` varchar(255) DEFAULT NULL,
      `link` varchar(255) DEFAULT NULL,
      `ordem` int(11) DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `facebook_pixel` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `pixel_id` varchar(255) DEFAULT NULL,
      `ativo` tinyint(1) DEFAULT 1,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `gateways_config` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(100) NOT NULL,
      `status` enum('ativo','inativo') DEFAULT 'inativo',
      `taxa_pct` decimal(10,2) DEFAULT 0.00,
      `taxa_fixa` decimal(10,2) DEFAULT 0.00,
      `api_key` varchar(255) DEFAULT '',
      `secret_key` varchar(255) DEFAULT '',
      `webhook_secret` varchar(255) DEFAULT '',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `pix_tabelas` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(255) NOT NULL,
      `criado_em` datetime DEFAULT current_timestamp(),
      `ativa` tinyint(1) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `pix_tabela_codigos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `tabela_id` int(11) NOT NULL,
      `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
      `codigo` text NOT NULL,
      `status_pagamento` varchar(20) NOT NULL DEFAULT 'DISPONIVEL',
      `reservado_em` datetime DEFAULT NULL,
      `reservado_pedido_ref` varchar(100) DEFAULT NULL,
      `pago_em` datetime DEFAULT NULL,
      `criado_em` timestamp NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `pix_codigos_multiplos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `tabela_id` int(11) DEFAULT NULL,
      `codigo` text DEFAULT NULL,
      `status` enum('disponivel','reservado','pago') DEFAULT 'disponivel',
      `data_uso` datetime DEFAULT NULL,
      `valor` decimal(10,2) DEFAULT 0.00,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "<p style='color:green;'>Sucesso na query</p>";
    } else {
        echo "<p style='color:red;'>Erro: " . mysqli_error($conn) . "</p>";
    }
}

// Inserções padrão para tabelas críticas se vazias
$chk_acesso = mysqli_query($conn, "SELECT id FROM acesso LIMIT 1");
if (mysqli_num_rows($chk_acesso) == 0) {
    mysqli_query($conn, "INSERT INTO acesso (login, senha, acesso) VALUES ('thefake', '12345', 'ativo')");
    echo "<p>Usuário admin criado: thefake / 12345</p>";
}

$chk_config = mysqli_query($conn, "SELECT id FROM config LIMIT 1");
if (mysqli_num_rows($chk_config) == 0) {
    mysqli_query($conn, "INSERT INTO config (nome, tema) VALUES ('Loja Oficial', 'escuro')");
    echo "<p>Configurações padrão inseridas.</p>";
}

$chk_apis = mysqli_query($conn, "SELECT id FROM apis LIMIT 1");
if (mysqli_num_rows($chk_apis) == 0) {
    mysqli_query($conn, "INSERT INTO apis (pixel) VALUES ('')");
    echo "<p>APIs padrão inseridas.</p>";
}

echo "<h2>Tabelas verificadas e atualizadas!</h2>";
echo "<p>Por favor, exclua este arquivo por segurança.</p>";
?>
