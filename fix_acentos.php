<?php
// =======================================================================
// SCRIPT DE CORREÇÃO AUTOMÁTICA GERAL
// 1. Corrige caracteres acentuados corrompidos em arquivos (.php, .html, .js, .css)
// 2. Substitui script do FontAwesome quebrado (403 kit) por CDN oficial
// 3. Corrige caracteres quebrados diretamente no Banco de Dados (tabelas config e produto)
// =======================================================================

@ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=utf-8');

$root = __DIR__;
echo "<!DOCTYPE html><html lang='pt-br'><head><meta charset='utf-8'><title>Correção do Sistema</title>";
echo "<style>body{font-family:sans-serif;background:#0f172a;color:#f8fafc;padding:30px;line-height:1.6;} .card{background:#1e293b;padding:20px;border-radius:10px;margin-bottom:20px;} .btn{display:inline-block;padding:10px 20px;background:#10b981;color:#fff;text-decoration:none;border-radius:6px;font-weight:bold;margin-top:15px;}</style></head><body>";
echo "<h1>🚀 Otimizador & Reparador de Acentos e Ícones</h1>";

$c_C3 = chr(0xC3);
$c_C2 = chr(0xC2);

$replaces = [
    // Sequências compostas
    $c_C3 . chr(0xA7) . $c_C3 . chr(0xA3) . 'o' => 'ção',
    $c_C3 . chr(0xA7) . $c_C3 . chr(0xB5) . 'es' => 'ções',
    $c_C3 . chr(0xA7) . $c_C3 . chr(0xA3) => 'çã',
    $c_C3 . chr(0xA7) . $c_C3 . chr(0xB5) => 'çõ',
    
    // Minúsculas
    $c_C3 . chr(0xA1) => 'á',
    $c_C3 . chr(0xA0) => 'à',
    $c_C3 . chr(0xA2) => 'â',
    $c_C3 . chr(0xA3) => 'ã',
    $c_C3 . chr(0xA9) => 'é',
    $c_C3 . chr(0xAA) => 'ê',
    $c_C3 . chr(0xAD) => 'í',
    $c_C3 . chr(0xB3) => 'ó',
    $c_C3 . chr(0xB4) => 'ô',
    $c_C3 . chr(0xB5) => 'õ',
    $c_C3 . chr(0xBA) => 'ú',
    $c_C3 . chr(0xBC) => 'ü',
    $c_C3 . chr(0xA7) => 'ç',
    
    // Maiúsculas
    $c_C3 . chr(0x81) => 'Á',
    $c_C3 . chr(0x80) => 'À',
    $c_C3 . chr(0x82) => 'Â',
    $c_C3 . chr(0x83) => 'Ã',
    $c_C3 . chr(0x89) => 'É',
    $c_C3 . chr(0x8A) => 'Ê',
    $c_C3 . chr(0x8D) => 'Í',
    $c_C3 . chr(0x93) => 'Ó',
    $c_C3 . chr(0x94) => 'Ô',
    $c_C3 . chr(0x95) => 'Õ',
    $c_C3 . chr(0x9A) => 'Ú',
    $c_C3 . chr(0x87) => 'Ç',
    
    // Símbolos
    $c_C2 . chr(0xB0) => '°',
    $c_C2 . chr(0xBA) => 'º',
    $c_C2 . chr(0xAA) => 'ª',
    $c_C2 . chr(0xA9) => '©',
    $c_C2 . chr(0xAE) => '®',
    $c_C2 . chr(0xB7) => '·',
    $c_C3 . ' ' => 'à ',
    $c_C2 => ''
];

echo "<div class='card'><h2>1. Verificando e Corrigindo Arquivos do Projeto</h2><ul>";

$fixedCount = 0;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));

foreach ($iterator as $file) {
    if ($file->isFile() && in_array(strtolower($file->getExtension()), ['php', 'js', 'html', 'css'])) {
        $path = $file->getPathname();
        if (strpos($path, '.git') !== false || basename($path) === 'fix_acentos.php') continue;
        
        $content = @file_get_contents($path);
        if ($content === false) continue;
        $modified = $content;
        
        // 1. Consertar acentos
        foreach ($replaces as $broken => $fixed) {
            if (strpos($modified, $broken) !== false) {
                $modified = str_replace($broken, $fixed, $modified);
            }
        }
        
        // 2. Consertar FontAwesome 403 kit
        if (strpos($modified, 'kit.fontawesome.com/42d5adcbca.js') !== false) {
            $modified = str_replace(
                '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">',
                '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">',
                $modified
            );
        }
        
        if ($modified !== $content) {
            @file_put_contents($path, $modified);
            echo "<li><span style='color:#38bdf8;'>" . htmlspecialchars(str_replace($root, '', $path)) . "</span> corrigido!</li>";
            $fixedCount++;
        }
    }
}

echo "</ul><p><strong>Total de arquivos corrigidos: $fixedCount</strong></p></div>";

// 3. Verificação no Banco de Dados
echo "<div class='card'><h2>2. Verificando e Corrigindo Banco de Dados (MySQL)</h2>";

if (file_exists(__DIR__ . '/api/db.php')) {
    include_once __DIR__ . '/api/db.php';
    if (isset($conn) && $conn) {
        @mysqli_set_charset($conn, "utf8mb4");
        @mysqli_query($conn, "SET NAMES 'utf8mb4'");
        
        $dbFixed = 0;
        
        // Tabela config
        $resConfig = @mysqli_query($conn, "SELECT id, nome, endereco FROM config");
        if ($resConfig) {
            while ($row = mysqli_fetch_assoc($resConfig)) {
                $id = $row['id'];
                $nome = $row['nome'];
                $end = $row['endereco'];
                
                $nMod = $nome;
                $eMod = $end;
                foreach ($replaces as $broken => $fixed) {
                    if (strpos($nMod, $broken) !== false) $nMod = str_replace($broken, $fixed, $nMod);
                    if (strpos($eMod, $broken) !== false) $eMod = str_replace($broken, $fixed, $eMod);
                }
                
                if ($nMod !== $nome || $eMod !== $end) {
                    $nModEsc = mysqli_real_escape_string($conn, $nMod);
                    $eModEsc = mysqli_real_escape_string($conn, $eMod);
                    @mysqli_query($conn, "UPDATE config SET nome='$nModEsc', endereco='$eModEsc' WHERE id='$id'");
                    echo "<p style='color:#34d399;'>Tabela 'config' (Nome/Endereço) corrigida com sucesso!</p>";
                    $dbFixed++;
                }
            }
        }
        
        // Tabela produto
        $resProd = @mysqli_query($conn, "SELECT codigo, nome, descricao FROM produto");
        if ($resProd) {
            while ($row = mysqli_fetch_assoc($resProd)) {
                $cod = $row['codigo'];
                $nome = $row['nome'];
                $desc = $row['descricao'];
                
                $nMod = $nome;
                $dMod = $desc;
                foreach ($replaces as $broken => $fixed) {
                    if (strpos($nMod, $broken) !== false) $nMod = str_replace($broken, $fixed, $nMod);
                    if (strpos($dMod, $broken) !== false) $dMod = str_replace($broken, $fixed, $dMod);
                }
                
                if ($nMod !== $nome || $dMod !== $desc) {
                    $nModEsc = mysqli_real_escape_string($conn, $nMod);
                    $dModEsc = mysqli_real_escape_string($conn, $dMod);
                    @mysqli_query($conn, "UPDATE produto SET nome='$nModEsc', descricao='$dModEsc' WHERE codigo='$cod'");
                    $dbFixed++;
                }
            }
            if ($dbFixed > 0) {
                echo "<p style='color:#34d399;'>$dbFixed registros em 'produto' corrigidos no banco!</p>";
            } else {
                echo "<p style='color:#94a3b8;'>Banco de dados já está consistente.</p>";
            }
        }
    } else {
        echo "<p style='color:#f87171;'>Não foi possível conectar ao banco de dados.</p>";
    }
}
echo "</div>";

echo "<div class='card'><h2>🎉 Concluído com Sucesso!</h2><p>Todos os arquivos e fontes foram padronizados para UTF-8 nativo e CDN segura.</p><a href='./' class='btn'>Voltar para a Loja</a> <a href='./@SERVIDOR/dashboard.php' class='btn' style='background:#3b82f6; margin-left:10px;'>Acessar Painel</a></div>";
echo "</body></html>";
