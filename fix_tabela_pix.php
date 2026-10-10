<?php
require_once("api/db.php");

echo "<h1>Corrigindo Tabela de Códigos PIX</h1>";

$table = "pix_tabela_codigos";

// Check if reservado_em exists
$check1 = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE 'reservado_em'");
if (mysqli_num_rows($check1) == 0) {
    mysqli_query($conn, "ALTER TABLE `$table` ADD COLUMN `reservado_em` datetime DEFAULT NULL");
    echo "<p>Coluna reservado_em criada.</p>";
} else {
    echo "<p>Coluna reservado_em já existe.</p>";
}

// Check if reservado_pedido_ref exists
$check2 = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE 'reservado_pedido_ref'");
if (mysqli_num_rows($check2) == 0) {
    mysqli_query($conn, "ALTER TABLE `$table` ADD COLUMN `reservado_pedido_ref` varchar(100) DEFAULT NULL");
    echo "<p>Coluna reservado_pedido_ref criada.</p>";
} else {
    echo "<p>Coluna reservado_pedido_ref já existe.</p>";
}

echo "<p>Tudo pronto. As colunas necessárias para o modo RESERVADO foram garantidas no banco.</p>";
?>
