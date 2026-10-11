<?php
// Ferramenta de localização de pastas do painel no servidor
error_reporting(E_ALL);
ini_set('display_errors', 1);

$root = __DIR__;
$itens = @scandir($root) ?: [];

// Procurar onde está o painel administrativo
$painel_encontrado = [];
function procurar_painel($dir, &$encontrados, $max_depth = 3, $depth = 0) {
    if ($depth > $max_depth || !is_dir($dir)) return;
    $files = @scandir($dir);
    if (!$files) return;
    foreach ($files as $f) {
        if ($f === '.' || $f === '..' || $f === '.git' || $f === 'vendor') continue;
        $full = $dir . '/' . $f;
        if (is_dir($full)) {
            // Se tem dashboard.php ou api_adm dentro, é a pasta do painel!
            if (file_exists($full . '/dashboard.php') || file_exists($full . '/api_adm')) {
                $encontrados[] = $full;
            } else {
                procurar_painel($full, $encontrados, $max_depth, $depth + 1);
            }
        }
    }
}

procurar_painel($root, $painel_encontrado);

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Localizador de Pastas</title>";
echo "<style>body{font-family:sans-serif; background:#0f172a; color:#f8fafc; padding:30px; line-height:1.6;} .box{background:#1e293b; padding:25px; border-radius:10px; max-width:800px; margin:0 auto; box-shadow:0 10px 25px rgba(0,0,0,0.5);} h1{color:#38bdf8; margin-top:0;} .item{padding:6px 12px; margin:4px 0; background:#334155; border-radius:6px; display:inline-block; font-family:monospace; margin-right:8px;} .btn{display:inline-block; background:#22c55e; color:#fff; font-weight:bold; padding:10px 18px; border-radius:6px; text-decoration:none; margin-top:10px;} .alert{background:#f59e0b; color:#78350f; padding:15px; border-radius:8px; font-weight:bold; margin-bottom:15px;}</style></head><body>";
echo "<div class='box'>";
echo "<h1>🔍 Localizador de Pastas do Site</h1>";
echo "<p><b>Diretório Raiz atual:</b> <code>" . htmlspecialchars($root) . "</code></p>";

echo "<h3>Pastas e Arquivos encontrados na Raiz:</h3><div>";
foreach ($itens as $it) {
    if ($it === '.' || $it === '..') continue;
    $is_dir = is_dir($root . '/' . $it);
    $color = $is_dir ? '#38bdf8' : '#cbd5e1';
    echo "<span class='item' style='color:$color;'>" . ($is_dir ? "📁 " : "📄 ") . htmlspecialchars($it) . "</span>";
}
echo "</div><br>";

echo "<h3>Onde está o Painel Administrativo?</h3>";
if (!empty($painel_encontrado)) {
    echo "<div style='background:#064e3b; border:1px solid #10b981; padding:15px; border-radius:8px;'>";
    echo "<p style='color:#a7f3d0; margin-top:0;'><b>✅ Painel encontrado na(s) seguinte(s) pasta(s):</b></p>";
    foreach ($painel_encontrado as $p) {
        $rel = ltrim(str_replace($root, '', $p), '/\\');
        $url = '/' . str_replace('\\', '/', $rel) . '/';
        echo "<p>Caminho: <code>$p</code><br>";
        echo "<a class='btn' href='$url' target='_blank'>👉 Clique aqui para abrir: $url</a></p>";
    }
    echo "</div>";
} else {
    echo "<div class='alert'>⚠️ A pasta do painel (com o arquivo dashboard.php) NÃO foi encontrada dentro de " . htmlspecialchars($root) . "!<br><br>Verifique no Gerenciador de Arquivos do aaPanel se a pasta foi apagada ou se está em outro local.</div>";
}

echo "</div></body></html>";
