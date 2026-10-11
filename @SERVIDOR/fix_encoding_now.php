<?php
$directory = __DIR__;
$files = glob($directory . "/*.php");

$replacements = [
    'Áƒ§Áƒµes' => 'ções',
    'Áƒ§Áƒ£o' => 'ção',
    'Áƒ§Áƒ£' => 'çã',
    'Áƒ¡' => 'á',
    'Áƒ©' => 'é',
    'Áƒ­' => 'í',
    'Áƒ³' => 'ó',
    'Áƒº' => 'ú',
    'Áƒ¢' => 'â',
    'Áƒª' => 'ê',
    'Áƒ´' => 'ô',
    'Áƒ£' => 'ã',
    'Áƒµ' => 'õ',
    'Áƒ§' => 'ç',
    'Áƒâ€¡ÁƒÆ’O' => 'ÇÃO',
    'Áƒâ€¡Áƒâ€¢ES' => 'ÇÕES',
    'Áƒâ€¡' => 'Ç',
    'Áƒâ€š' => '',
    'ção' => 'ção',
    'ções' => 'ções',
    'á' => 'á',
    'é' => 'é',
    'í' => 'í',
    'ó' => 'ó',
    'ú' => 'ú',
    'ã' => 'ã',
    'õ' => 'õ',
    'ç' => 'ç',
    'â' => 'â',
    'ê' => 'ê',
    'ô' => 'ô',
    'Ãš' => 'Ú'
];

foreach ($files as $file) {
    if (basename($file) == 'fix_encoding_now.php') continue;
    
    $content = file_get_contents($file);
    $original_content = $content;
    
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    if ($content !== $original_content) {
        file_put_contents($file, $content);
        echo "Corrigido encodings em: " . basename($file) . "\n";
    }
}
echo "Finalizado.\n";
?>
