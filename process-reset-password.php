<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM customer WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if ($customer === null) {
    die("không thấy token");
}

if (strtotime($customer["reset_token_expires_at"]) <= time()) {
    die("token đã hết hạn");
}

if (strlen($_POST["password"]) < 8) {
    die("Mật khẩu cần dài ít nhất 8 kí tự");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Mật khẩu bắt buộc phải có ít nhất 1 chữ cái");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Mật khẩu bắt buộc phải có ít nhất 1 chữ số");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Mật khẩu không khớp");
}

// Mã hóa mật khẩu
$password_hash = hash('sha256', $_POST["password"]);

$sql = "UPDATE customer SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $password_hash, $customer["id"]);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Đã cập nhật mật khẩu. Hãy đăng nhập.";
} else {
    echo "Lỗi cập nhật mật khẩu.";
}