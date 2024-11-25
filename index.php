
<?php
session_start();
include("header.php");

$con = new connec(); // Khởi tạo kết nối
$tbl = "slider";
$result = $con->select_all($tbl);

// Kiểm tra xem người dùng đã đăng nhập chưa
if (empty($_SESSION["username"])) {
    ?>
    <script>
        $(document).ready(function () {
            $("#modelId1").modal('show');
        });
    </script>
    <?php
}
?>

<style>
    .carousel-item img {
        width: 100%;
        height: 100%;
    }

    .banner {
        background-color: #f0b700;
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: 20px;
        font-size: 24px;
    }

    .hot-movies {
        margin-top: 40px;
    }

    .hot-movies h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .movie-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        margin: 10px;
        transition: transform 0.3s;
        text-align: center;
        display: flex;
        flex-direction: column; /* Sử dụng flexbox để căn giữa */
        align-items: center; /* Căn giữa theo chiều ngang */
    }

    .movie-card:hover {
        transform: scale(1.05);
    }

    .movie-card img {
        width: 80%; /* Thu nhỏ ảnh phim */
        height: auto;
    }

    .movie-card p {
        padding: 10px;
        text-align: center;
    }

    .btn-book {
        margin: 10px 0;
        background-color: #f0b700;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none; /* Xóa gạch chân khỏi liên kết */
        text-align: center; /* Căn giữa nội dung của nút */
    }

    .btn-book:hover {
        background-color: #e0a700;
    }

    .movie-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Căn giữa các phim */
    }

    .movie-card img {
    width: 100%; /* Chiều rộng 100% của card */
    height: auto; /* Tự động điều chỉnh chiều cao */
    max-height: 400px; /* Giới hạn chiều cao tối đa */
    object-fit: cover; /* Cắt ảnh để phù hợp với khung */
    }
</style>

<section style="background-image: url('images/background.jpg'); background-size: cover; background-position: center; display: flex; justify-content: center;">
    <div id="carouselId" class="carousel slide" data-ride="carousel" data-interval="3000" style="width: 1000px;">
        <?php
        if ($result->num_rows > 0) {
            echo '<ol class="carousel-indicators">';
            for ($i = 0; $i < $result->num_rows; $i++) {
                echo '<li data-target="#carouselId" data-slide-to="' . $i . '" class="' . ($i === 0 ? 'active' : '') . '"></li>';
            }
            echo '</ol>';
        }
        ?>

        <div class="carousel-inner" role="listbox">
            <?php
            $j = 0;
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="carousel-item <?php echo ($j === 0) ? 'active' : ''; ?>">
                    <div class="d-flex justify-content-center">
                        <img src="<?php echo $row["img_path"]; ?>" alt="<?php echo $row["alt"]; ?>" class="img-fluid">
                    </div>
                </div>
                <?php
                $j++;
            }
            ?>
        </div>

        <!-- Điều khiển "Previous" và "Next" -->
        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<!-- Banner -->
<div class="banner">
    Khám Phá Những Bộ Phim Mới Nhất Đang Chiếu Ngay Hôm Nay!
</div>

<!-- Mục Phim Đang Hot -->
<div class="hot-movies">
    <h2>Phim Đang Hot</h2>
    <div class="movie-container">
        <?php
        // Lấy dữ liệu từ bảng hot_movies
        $hot_movies = $con->select_all("hot_movies");

        if ($hot_movies->num_rows > 0) {
            while ($movie = $hot_movies->fetch_assoc()) {
                // Tìm ID phim từ bảng movie
                $movie_info = $con->select("movie", $movie['id']); // Giả sử id ở đây là id của movie
                if ($movie_info && $movie_info->num_rows > 0) {
                    $movie_data = $movie_info->fetch_assoc();
                    ?>
                    <div class="col-md-3">
                        <div class="movie-card">
                            <a href="detail.php?id=<?php echo htmlspecialchars($movie_data['id']); ?>"> <!-- ID từ bảng movie -->
                                <img src="<?php echo htmlspecialchars($movie['img_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                            </a>
                            <p><?php echo htmlspecialchars($movie["title"]); ?></p>
                            <a href="booking.php?movie_id=<?php echo htmlspecialchars($movie_data['id']); ?>" class="btn-book">Đặt vé ngay</a>
                        </div>
                    </div>
                    <?php
                }
            }
        } else {
            echo "<p class='text-center'>Không có phim nào đang hot.</p>";
        }
        ?>
    </div>
</div>


<?php
include("footer.php");
?>
