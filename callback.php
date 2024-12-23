<?php

// PHP Version 7.3.3

$result = [];

try {
  $key2 = "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz";
  $postdata = file_get_contents('php://input');
  $postdatajson = json_decode($postdata, true);
  $mac = hash_hmac("sha256", $postdatajson["data"], $key2);

  $requestmac = $postdatajson["mac"];

  // kiểm tra callback hợp lệ (đến từ ZaloPay server)
  if (strcmp($mac, $requestmac) != 0) {
    // callback không hợp lệ
    $result["return_code"] = -1;
    $result["return_message"] = "mac not equal";
  } else {
    // thanh toán thành công
    // merchant cập nhật trạng thái cho đơn hàng
    $datajson = json_decode($postdatajson["data"], true);
    // echo "update order's status = success where app_trans_id = ". $dataJson["app_trans_id"];

    error_log("thanh toán thành công", 3, 'C:\xampp\htdocs\GitHub\logfile.log');

    $result["return_code"] = 1;
    $result["return_message"] = "success";
  }
} catch (Exception $e) {
  $result["return_code"] = 0; // ZaloPay server sẽ callback lại (tối đa 3 lần)
  $result["return_message"] = $e->getMessage();
}

// thông báo kết quả cho ZaloPay server
echo json_encode($result);