<?php
require_once('api/db.php');
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN dispositivo VARCHAR(50) DEFAULT 'desktop'");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN situacao VARCHAR(20) DEFAULT 'ativo'");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN etapa VARCHAR(50) DEFAULT 'produto'");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN useragent TEXT");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN cidade VARCHAR(100)");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN estado VARCHAR(50)");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN time INT(11)");
@mysqli_query($conn, "ALTER TABLE online ADD COLUMN hora VARCHAR(20)");
echo "Schema updated";
?>