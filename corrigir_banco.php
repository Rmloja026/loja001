<?php
require_once("api/db.php");

echo "<h1>Corrigindo Tabelas do Banco de Dados</h1>";

// 1. Apagar tabelas que foram criadas erradas
mysqli_query($conn, "DROP TABLE IF EXISTS `config`");
mysqli_query($conn, "DROP TABLE IF EXISTS `apis`");

$queries = [
    "CREATE TABLE `config` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE `apis` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `zap` varchar(255) DEFAULT '',
      `email` varchar(255) DEFAULT '',
      `htmlemail` text DEFAULT NULL,
      `texto1email` text DEFAULT NULL,
      `textozap` text DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "INSERT IGNORE INTO `config` (`id`, `nome`, `cor`, `cor_botao`, `cor_icones`, `img`, `numero`, `zap`, `zap_cotacao`, `zap_flutuante_ativo`, `texto`, `endereco`, `cnpj`) VALUES
    (1, 'Mercado Livre', '#ffdd00', '#3483fa', '#000000', 'logo.png', '5511999999999', '5511999999999', '', 0, 'Olá, vim pelo site!', '', '');",

    "INSERT IGNORE INTO `apis` (`id`, `zap`, `email`, `htmlemail`, `texto1email`, `textozap`) VALUES
    (1, '', '', NULL, NULL, NULL);"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "<p style='color:green;'>Sucesso: " . substr($q, 0, 50) . "...</p>";
    } else {
        echo "<p style='color:red;'>Erro: " . mysqli_error($conn) . "</p>";
    }
}

echo "<h2>Correção Concluída!</h2>";
echo "<p>Agora a página do produto (produto.php) deve voltar ao normal e sem avisos de 'zap' ou 'texto'.</p>";
?>
