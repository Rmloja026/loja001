<?php
require_once("api/db.php");
$res = mysqli_query($conn, "SELECT * FROM pix_tabela_codigos LIMIT 10");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
$res2 = mysqli_query($conn, "SELECT * FROM pix_tabelas LIMIT 10");
while($row = mysqli_fetch_assoc($res2)) {
    print_r($row);
}
?>
