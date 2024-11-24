<?php
include("header.php");
include 'db.php'; // Kết nối cơ sở dữ liệu

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $movie_id = $_GET['id']; // Lấy ID phim từ URL

    // Sử dụng câu lệnh chuẩn bị để tránh SQL injection
    $stmt = $conn->prepare("SELECT m.*, i.industry_name, g.genre_name, l.lang_name 
                            FROM movie m
                            JOIN industry i ON m.industry_id = i.id
                            JOIN genre g ON m.genre_id = g.id
                            JOIN language l ON m.lang_id = l.id
                            WHERE m.id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy dữ liệu phim
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy phim.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID phim không hợp lệ.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Phim</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Ảnh phim bên trái -->
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($row["movie_banner"]); ?>" style="width:100%; height:auto;" alt="Movie Banner"/>
            </div>
            <!-- Mô tả phim bên phải -->
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($row["name"]); ?></h2>
                <p><b>Ngày Phát Hành: </b><?php echo htmlspecialchars($row["rel_date"]); ?></p>
                <p><b>Quốc Gia: </b><?php echo htmlspecialchars($row["industry_name"]); ?></p>
                <p><b>Ngôn Ngữ: </b><?php echo htmlspecialchars($row["lang_name"]); ?></p>
                <p><b>Thể Loại: </b><?php echo htmlspecialchars($row["genre_name"]); ?></p>
                <p><b>Mô Tả: </b><?php echo nl2br(htmlspecialchars($row["movie_desc"])); ?></p>
                <a class="btn btn-primary" href="booking.php?id=<?php echo htmlspecialchars($row['id']); ?>" style="background-color:maroon; color:white; width:100%">Đặt vé ngay</a>
            </div>
        </div>
    </div>
</body>
</html>


<?php
include("footer.php");
?>
