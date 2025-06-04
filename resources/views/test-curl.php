<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    echo 'Success: ' . substr($result, 0, 100); // جزء من النتيجة
}
curl_close($ch);
