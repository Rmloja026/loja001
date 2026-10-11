<?php
$db_paths = [
    __DIR__ . '/db.php',
    dirname(__DIR__) . '/api/db.php',
    ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/api/db.php'
];
foreach ($db_paths as $p) {
    if (!empty($p) && file_exists($p)) {
        require_once($p);
        break;
    }
}

$status = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : 1;

if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'error' => 'Sem conexão com banco']);
    exit;
}

// Garantir tabela apis
@mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `apis` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `zap` VARCHAR(255) DEFAULT '',
    `email` VARCHAR(255) DEFAULT '',
    `htmlemail` TEXT,
    `texto1email` VARCHAR(255) DEFAULT '',
    `textozap` TEXT,
    `smtp_ativo` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Garantir coluna smtp_ativo com segurança (compatível com MySQL 5.7)
if (function_exists('safe_add_column')) {
    safe_add_column($conn, 'apis', 'smtp_ativo', 'TINYINT(1) DEFAULT 1');
} else {
    $chk = @mysqli_query($conn, "SHOW COLUMNS FROM `apis` LIKE 'smtp_ativo'");
    if (!$chk || mysqli_num_rows($chk) === 0) {
        @mysqli_query($conn, "ALTER TABLE `apis` ADD COLUMN `smtp_ativo` TINYINT(1) DEFAULT 1");
    }
}

// Garantir registro na tabela
$chk_rows = @mysqli_query($conn, "SELECT id FROM apis LIMIT 1");
if (!$chk_rows || mysqli_num_rows($chk_rows) === 0) {
    @mysqli_query($conn, "INSERT INTO apis (id, smtp_ativo) VALUES (1, $status)");
} else {
    @mysqli_query($conn, "UPDATE apis SET smtp_ativo = $status");
}

if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false || isset($_REQUEST['json'])) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => true, 'smtp_ativo' => $status]);
    exit;
}

if ($status === 1) {
    echo "<h2 style='color:green;'>SMTP ATIVADO COM SUCESSO!</h2><p>O site agora VAI enviar os e-mails.</p>";
} else {
    echo "<h2 style='color:red;'>SMTP DESATIVADO COM SUCESSO!</h2><p>O site NÃO vai mais enviar os e-mails.</p>";
}

