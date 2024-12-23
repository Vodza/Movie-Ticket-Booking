<?php

// PHP Version 7.3.3

$config = [
  "app_id" => 2553,
  "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
  "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
  "endpoint" => "https://sb-openapi.zalopay.vn/v2/query"
];

if(isset($_GET["app_trans_id"])){
    $app_trans_id = $_GET['app_trans_id'];
} // Input your app_trans_id
$data = $config["app_id"]."|".$app_trans_id."|".$config["key1"]; // app_id|app_trans_id|key1
$params = [
  "app_id" => $config["app_id"],
  "app_trans_id" => $app_trans_id,
  "mac" => hash_hmac("sha256", $data, $config["key1"])
];

$context = stream_context_create([
    "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($params)
    ]
]);

$resp = file_get_contents($config["endpoint"], false, $context);
$result = json_decode($resp, true);

foreach ($result as $key => $value) {
  echo "$key: $value<br>";
}