<?php

use App\Events\PushNotif;
use App\Notification;

function getBackOffice()
{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    // $actual_link = 'http://demo.aturuangpos.com';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://billing.aturuangpos.com/api/getBackOffice',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('url' => $actual_link),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . base64_encode(base64_encode(env('APP_UNIQ_KEY')) . '.' .
                ('APP_UNIQ_KEY') . '.' . base64_encode(rand() * rand() * 100))
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
    // return $response;
}

function encryptQr($data)
{
    // $ivSize = openssl_cipher_iv_length('AES-256-CBC');
    // $iv = openssl_random_pseudo_bytes($ivSize);

    // $encrypted = openssl_encrypt($data, 'AES-256-CBC', env('KEY_ENCRYPT'), OPENSSL_RAW_DATA, $iv);
    // $encryptedData = base64_encode($iv . $encrypted);

    // return $encryptedData;
    $key = 'rBf20BQDTcCP4T3Hl5u92LG8NlTTG2nw';
    $iv  = 'G2nwajhz6Qfn+dg=';
    return openssl_encrypt($data, "AES-256-CBC", $key, 0, $iv);
}

function countNotifPenjualan()
{
    return Notification::where([['type', 'App\Notifications\Penjualan'], ['read_at', null]])->count();
}

function pushNotification($data)
{
    $message = "Terdapat penjualan baru, ";
    $message .= $data[1]['name'];
    $message .= " - ";
    $message .= $data[1]['company_name'];
    $message .= " Total :  Rp. ";
    $message .= number_format($data[0]['grand_total'], 0, '.', '.');

    $createNotif = new Notification;
    $createNotif->type = 'App\Notifications\Penjualan';
    $createNotif->notifiable_type = 'App\User';
    $createNotif->notifiable_id = $data[0]['id'];
    $createNotif->data = $message;

    if ($createNotif->save()) {
        $dataMessage = array(
            'body' => $message,
            'total' => countNotifPenjualan(),
            'url' => url('sales')
        );

        event(new PushNotif($dataMessage));
    }
    return $dataMessage;
}

function generate_signature($url, $timestamp, $data)
{
    $string_to_sign = "POST\n" . parse_url($url, PHP_URL_PATH) . "\n" . "auth_key=543ac35d1fcf9b2d17e2&auth_timestamp=$timestamp&body_md5=" . md5($data);
    $auth_signature = hash_hmac('sha256', $string_to_sign, 'YOUR_APP_SECRET', false);
    return $auth_signature;
}
