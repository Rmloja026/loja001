<?php
require_once(__DIR__ . '/api/db.php');

$query_check_categoria = "SHOW COLUMNS FROM `produto` LIKE 'categoria'";
$result_cat = mysqli_query($conn, $query_check_categoria);

if(mysqli_num_rows($result_cat) == 0){
    $query_add_cat = "ALTER TABLE `produto` ADD `categoria` VARCHAR(255) DEFAULT 'Geral'";
    if(mysqli_query($conn, $query_add_cat)){
        echo "Coluna 'categoria' adicionada com sucesso.<br>";
    } else {
        echo "Erro ao adicionar 'categoria': " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Coluna 'categoria' já existe.<br>";
}

$query_check_rel = "SHOW COLUMNS FROM `produto` LIKE 'produtos_relacionados'";
$result_rel = mysqli_query($conn, $query_check_rel);

if(mysqli_num_rows($result_rel) == 0){
    $query_add_rel = "ALTER TABLE `produto` ADD `produtos_relacionados` VARCHAR(255) DEFAULT ''";
    if(mysqli_query($conn, $query_add_rel)){
        echo "Coluna 'produtos_relacionados' adicionada com sucesso.<br>";
    } else {
        echo "Erro ao adicionar 'produtos_relacionados': " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Coluna 'produtos_relacionados' já existe.<br>";
}

$queries = [
    "ALTER TABLE `pix` ADD COLUMN `bravopay_api_key` VARCHAR(255) DEFAULT ''",
    "ALTER TABLE `pix` ADD COLUMN `bravopay_webhook_secret` VARCHAR(255) DEFAULT ''",
    "ALTER TABLE `pix` ADD COLUMN `use_bravopay` TINYINT(1) DEFAULT 0",
    "ALTER TABLE `produto` ADD COLUMN `valor_original` VARCHAR(100) DEFAULT ''",
    "ALTER TABLE `produto` ADD COLUMN `variacoes` LONGTEXT DEFAULT NULL",
    "ALTER TABLE `produto` ADD COLUMN `force_tabela_pix` TINYINT(1) DEFAULT 0",
    "ALTER TABLE `produto` ADD COLUMN `status` VARCHAR(50) DEFAULT 'ativo'"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "Sucesso: $q <br>";
    } else {
        $err = mysqli_error($conn);
        if (strpos($err, 'Duplicate column') === false) {
            echo "Erro: $err em $q <br>";
        }
    }
}


echo "Finalizado.";
?>
