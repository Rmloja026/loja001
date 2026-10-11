<?php
$url = "https://mercadoseguroblak.com/api/check_payment_status.php";
$data = array(
    'gateway' => 'copia_cola',
    'transaction_id' => '00020101021226740014br.gov.bcb.pix2552pix.ebanx.com/qr/v2/1F752F14A29AAFA69819B4FB9399BB7A5204000053039865802BR5924Facebook Servicos Online6009SAO PAULO62070503***630425D6'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
// We also need to send the session cookie to pass the authorization check!
// Or we can just modify check_payment_status.php temporarily to log any calls!
?>
