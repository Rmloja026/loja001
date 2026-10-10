<?php
$log_file = __DIR__ . '/poll_log.txt';
if (file_exists($log_file)) {
    echo "<pre>" . htmlspecialchars(file_get_contents($log_file)) . "</pre>";
} else {
    echo "Nenhum log encontrado ainda.";
}
?>
