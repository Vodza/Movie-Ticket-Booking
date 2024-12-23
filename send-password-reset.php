<?php

// Kiểm tra xem phương thức yêu cầu có phải là POST không
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Yêu cầu không hợp lệ.");
}

// Lấy email từ yêu cầu POST
$email = $_POST["email"];

// Kiểm tra xem email có được nhập không
if (empty($email)) {
    die("Vui lòng nhập email.");
}

// Tạo token và tính toán thời gian hết hạn
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Kết nối đến cơ sở dữ liệu
$mysqli = require __DIR__ . "/database.php";

// Cập nhật reset token vào cơ sở dữ liệu
$sql = "UPDATE customer SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Nếu cập nhật thành công, gửi email
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Reset Password";
    $mail->Body = <<<END
    Nhấn vào <a href="http://localhost/Online_Movie_Ticket_Booking/reset-password.php?token=$token">đây</a>
    để đặt lại mật khẩu.
    END;

    try {
        $mail->send();
        echo "Đã gửi tin nhắn. Vui lòng kiểm tra email của bạn.";
    } catch (Exception $e) {
        echo "Tin nhắn không thể gửi. Lỗi: {$mail->ErrorInfo}";
    }
} else {
    // Nếu không có dòng nào bị ảnh hưởng, có thể email không tồn tại
    echo "Email không tồn tại trong hệ thống.";
}
?>
