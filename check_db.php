<?php
require_once("api/db.php");
$sql = mysqli_query($conn, "SELECT id, codigo, nome, oferta FROM produto ORDER BY id DESC LIMIT 20");
$out = [];
while($row = mysqli_fetch_assoc($sql)) {
    $out[] = $row;
}
echo json_encode($out, JSON_PRETTY_PRINT);
?>
