<?php
require_once('api/db.php');
$sql = mysqli_query($conn, "SELECT * FROM online");
while ($row = mysqli_fetch_assoc($sql)) {
    print_r($row);
}
echo "Total rows: " . mysqli_num_rows($sql) . "\n";
echo "Current Time: " . time() . "\n";
?>