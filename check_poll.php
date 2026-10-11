<?php
$_POST['gateway'] = 'copia_cola';
$_POST['transaction_id'] = '00020126580014br.gov.bcb.pix0136123e4567-e89b-12d3-a456-426614174000520400005303986540499.905802BR5913Loja Oficial6009SAO PAULO62070503***6304';
$_SESSION['session_checkout'] = 1;

ob_start();
require_once("api/check_payment_status.php");
$res = ob_get_clean();
echo $res;
?>
