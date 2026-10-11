<?php
require_once('api/db.php');
$sql = mysqli_query($conn, "DESCRIBE online");
while ($row = mysqli_fetch_assoc($sql)) {
    print_r($row);
}
?>