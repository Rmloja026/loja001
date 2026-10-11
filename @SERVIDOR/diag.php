<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_dir = __DIR__;
$parent_dir = dirname(__DIR__);

// Ação de copiar automaticamente se solicitada
$msg_acao = "";
if (isset($_POST['acao']) && $_POST['acao'] === 'copiar_api' && isset($_POST['origem'])) {
    $origem = realpath($_POST['origem']);
    $destino = $parent_dir . '/api';
    if ($origem && is_dir($origem)) {
        if (!is_dir($destino)) {
            @mkdir($destino, 0755, true);
        }
        $copiados = 0;
        foreach (scandir($origem) as $item) {
            if ($item === '.' || $item === '..') continue;
            if (is_file("$origem/$item")) {
                if (@copy("$origem/$item", "$destino/$item")) {
                    $copiados++;
                }
            }
        }
        $msg_acao = "<div style='background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px; font-weight:bold;'>
            [SUCESSO] Pasta 'api' copiada para a raiz com sucesso ($copiados arquivos)! <a href='index.php'>Clique aqui para abrir o Painel</a>
        </div>";
    }
}

// 1. Procurar db.php recursivamente
function buscar_db_php($dir, &$encontrados, $max_depth = 3, $depth = 0) {
    if ($depth > $max_depth || !is_dir($dir)) return;
    $itens = @scandir($dir);
    if (!$itens) return;
    foreach ($itens as $item) {
        if ($item === '.' || $item === '..') continue;
        $caminho = $dir . '/' . $item;
        if (is_file($caminho) && $item === 'db.php') {
            $encontrados[] = $caminho;
        } elseif (is_dir($caminho) && $item !== 'vendor' && $item !== '.git' && $item !== 'node_modules') {
            buscar_db_php($caminho, $encontrados, $max_depth, $depth + 1);
        }
    }
}

$db_encontrados = [];
buscar_db_php($parent_dir, $db_encontrados);

// 2. Itens na raiz do site
$itens_raiz = @scandir($parent_dir) ?: [];

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Diagnóstico do Servidor</title>";
echo "<style>body{font-family:sans-serif; background:#0f172a; color:#e2e8f0; padding:30px;} .card{background:#1e293b; padding:25px; border-radius:12px; max-width:850px; margin:0 auto; box-shadow:0 10px 25px rgba(0,0,0,0.5);} h1{color:#38bdf8; margin-top:0;} pre{background:#090d16; padding:12px; border-radius:6px; color:#a5f3fc; overflow-x:auto;} .badge-ok{background:#22c55e; color:#052e16; padding:4px 8px; border-radius:4px; font-weight:bold;} .badge-err{background:#ef4444; color:#fff; padding:4px 8px; border-radius:4px; font-weight:bold;} .btn{background:#38bdf8; color:#0f172a; font-weight:bold; padding:10px 18px; border:none; border-radius:6px; cursor:pointer;} </style></head><body>";

echo "<div class='card'>";
echo "<h1>🔍 Diagnóstico de Arquivos no Servidor</h1>";
echo $msg_acao;

echo "<p><b>Pasta atual do painel:</b> <code>$current_dir</code></p>";
echo "<p><b>Pasta raiz do site:</b> <code>$parent_dir</code></p>";

// Status do api/db.php na raiz
$esperado = $parent_dir . '/api/db.php';
if (file_exists($esperado)) {
    echo "<p><span class='badge-ok'>OK</span> O arquivo <code>api/db.php</code> EXISTE na raiz do site! <a href='index.php' style='color:#38bdf8;'>Tentar entrar no painel</a></p>";
} else {
    echo "<p><span class='badge-err'>NÃO ENCONTRADO</span> O arquivo <code>api/db.php</code> NÃO EXISTE em <code>$esperado</code>.</p>";
}

echo "<hr style='border-color:#334155; margin:20px 0;'>";

// Busca profunda de db.php
echo "<h3>Resultado da Busca por <code>db.php</code>:</h3>";
if (!empty($db_encontrados)) {
    echo "<p style='color:#4ade80;'>Foram encontrados os seguintes arquivos <code>db.php</code> no servidor:</p><ul>";
    foreach ($db_encontrados as $found) {
        echo "<li style='margin-bottom:10px;'><code>$found</code>";
        if (dirname($found) !== $parent_dir . '/api') {
            echo " <form method='POST' style='display:inline; margin-left:10px;'>
                <input type='hidden' name='acao' value='copiar_api'>
                <input type='hidden' name='origem' value='" . htmlspecialchars(dirname($found)) . "'>
                <button type='submit' class='btn'>Copiar pasta API para a raiz</button>
            </form>";
        }
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:#f87171;'>O arquivo <code>db.php</code> não foi localizado em nenhuma pasta dentro de <code>$parent_dir</code>. Você precisa enviar a pasta <b>api</b> via aaPanel.</p>";
}

echo "<hr style='border-color:#334155; margin:20px 0;'>";

// Listagem da raiz
echo "<h3>Pastas e Arquivos encontrados na raiz (<code>$parent_dir</code>):</h3><ul>";
foreach ($itens_raiz as $it) {
    if ($it === '.' || $it === '..') continue;
    $tipo = is_dir("$parent_dir/$it") ? "📁 [PASTA]" : "📄 [ARQUIVO]";
    $estilo = ($it === 'api' || $it === '@SERVIDOR') ? "color:#38bdf8; font-weight:bold;" : "";
    echo "<li style='$estilo'>$tipo $it</li>";
}
echo "</ul>";

echo "<hr style='border-color:#334155; margin:20px 0;'>";
echo "<p><a href='index.php' style='color:#38bdf8; font-weight:bold;'>← Voltar para o Login do Painel</a></p>";
echo "</div></body></html>";
