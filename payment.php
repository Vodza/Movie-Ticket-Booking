<?php


session_start();
include("conn.php"); // Bao gồm tệp định nghĩa lớp connec

$config = [
    "app_id" => 2553,
    "key1" => "PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL",
    "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
    "endpoint" => "https://sb-openapi.zalopay.vn/v2/create"
];

$amount = isset($_POST['price_details']) ? intval($_POST['price_details']) : 0;

echo $amount;

$embeddata = json_encode(['redirecturl' => 'http://localhost/Online_Movie_Ticket_Booking/']); // Merchant's data
$items = '[]'; // Merchant's data
$transID = rand(0,1000000); //Random trans id
$price_details = isset($_POST['price_details']) ? intval($_POST['price_details']) : 0;
$order = [
    "app_id" => $config["app_id"],
    "app_time" => round(microtime(true) * 1000), // miliseconds
    "app_trans_id" => date("ymd") . "_" . $transID, // translation missing: vi.docs.shared.sample_code.comments.app_trans_id
    "app_user" => "user123",
    "item" => $items,
    "embed_data" => $embeddata,
    "amount" => $amount,
    "description" => "Lazada - Payment for the order #$transID",
    "bank_code" => "",
    "callback_url"  => "localhost/Online_Movie_Ticket_Booking/callback.php",
];

// appid|app_trans_id|appuser|amount|apptime|embeddata|item
$data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
    . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
$order["mac"] = hash_hmac("sha256", $data, $config["key1"]);

$context = stream_context_create([
    "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($order)
    ]
]);

$resp = file_get_contents($config["endpoint"], false, $context);
$result = json_decode($resp, true);

if($result["return_code"] == 1) {
    // Kết nối cơ sở dữ liệu
    $connect = new connec();

    $cust_id = $_POST["cust_id"];
    $show_id = $_POST["show_id"];
    $no_tikt = $_POST["no_ticket"];
    $total_amnt = (70000 * $no_tikt);

    $seat_number = $_POST["seat_dt"];
    $seat_arr = explode(", ", $seat_number);

    foreach ($seat_arr as $item) {
        $sql = "INSERT INTO seat_reserved VALUES(0, $show_id, $cust_id, '$item', 'true')";
        $abc = $connect->insert_lastid($sql);
    }

    $sql = "INSERT INTO seat_detail VALUES(0, $cust_id, $show_id, $no_tikt)";
    $seat_dt_id = $connect->insert_lastid($sql);

    $sql = "INSERT INTO booking VALUES(0, $cust_id, $show_id, $no_tikt, $seat_dt_id, NOW(), $total_amnt)";
    $connect->insert($sql, "Đặt vé thành công");

    // Chuyển hướng đến URL đơn hàng
    header("Location: " . $result["order_url"]);
    exit;
}

foreach ($result as $key => $value) {
    echo "$key: $value<br>";
}
?>
