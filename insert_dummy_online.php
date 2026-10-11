<?php
require_once('api/db.php');
$ip = '127.0.0.1';
$etapa = 'produto';
$dispositivo = 'desktop';
$cidade = 'Teste';
$estado = 'TS';
$ua = 'Teste Agent';
$hora = date('H:i:s');
$tempo = time() + 3000;

$r = mysqli_query($conn, "INSERT INTO online (ip, useragent, etapa, cidade, estado, dispositivo, hora, time, situacao) VALUES ('$ip', '$ua', '$etapa', '$cidade', '$estado', '$dispositivo', '$hora', '$tempo', 'ativo')");

if ($r) {
    echo "Inserted successfully.<br>";
} else {
    echo "Error inserting: " . mysqli_error($conn) . "<br>";
}

$sql = mysqli_query($conn, "SELECT * FROM online");
echo "Rows in online: " . mysqli_num_rows($sql) . "<br>";

$sql2 = mysqli_query($conn, "SELECT count(id) as online FROM online WHERE time >= '" . time() . "' AND situacao='ativo'");
$res = mysqli_fetch_assoc($sql2);
echo "Online users according to query: " . $res['online'] . "<br>";
?>