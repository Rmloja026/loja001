<?php
require_once("api/db.php");

echo "<h1>Forçando configuração de PIX Copia e Cola</h1>";

// 1. Forçar modo copia_cola na tabela pix
$r1 = mysqli_query($conn, "UPDATE pix SET pix_modo='copia_cola' WHERE id='1'");
if ($r1) echo "<p style='color:green;'>1. Modo PIX alterado para 'copia_cola' com sucesso!</p>";
else echo "<p style='color:red;'>1. Erro ao alterar modo PIX: " . mysqli_error($conn) . "</p>";

// 2. Forçar ativação de TODAS as tabelas PIX
$r2 = mysqli_query($conn, "UPDATE pix_tabelas SET ativa=1");
if ($r2) echo "<p style='color:green;'>2. Todas as tabelas PIX foram ATIVADAS com sucesso!</p>";
else echo "<p style='color:red;'>2. Erro ao ativar tabelas: " . mysqli_error($conn) . "</p>";

// 3. Checar quantos códigos estão disponíveis
$r3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM pix_tabela_codigos WHERE status_pagamento='DISPONIVEL'");
if ($r3) {
    $row = mysqli_fetch_assoc($r3);
    echo "<p style='color:blue;'>3. Códigos totais disponíveis no banco: " . $row['total'] . "</p>";
}

// 4. Mostrar os valores exatos dos códigos cadastrados
$r4 = mysqli_query($conn, "SELECT DISTINCT valor, COUNT(*) as qtd FROM pix_tabela_codigos WHERE status_pagamento='DISPONIVEL' GROUP BY valor");
if ($r4) {
    echo "<h3>Valores de PIX disponíveis na sua tabela:</h3><ul>";
    while ($row = mysqli_fetch_assoc($r4)) {
        echo "<li>R$ " . number_format($row['valor'], 2, ',', '.') . " (Quantidade: " . $row['qtd'] . ")</li>";
    }
    echo "</ul>";
}

echo "<p>Tudo pronto. O seu sistema AGORA está forçado a usar Copia e Cola e a tabela está ativa. Volte no site e faça um teste de compra.</p>";
?>
