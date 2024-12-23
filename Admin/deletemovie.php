<?php
session_start();

$imgsrc = "";
$name = "";

if (isset($_POST["btn_delete"])) {
    include("../conn.php");

    $id = $_GET["id"];
    $table = "movie";
    $con = new connec();

    // Lấy thông tin đường dẫn ảnh để xóa file
    $result = $con->select($table, $id);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imgPath = "../" . $row["movie_banner"]; // Đường dẫn ảnh

        // Xóa file ảnh vật lý nếu tồn tại
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }

        // Xóa bản ghi trong cơ sở dữ liệu
        $con->delete($table, $id);
        header("Location:viewmovie.php");
        exit();
    } else {
        echo "Phim không tồn tại.";
        exit();
    }
}

if (empty($_SESSION["admin_username"])) {
    header("Location:index.php");
    exit();
} else {
    include("admin_header.php");

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $con = new connec();
        $tbl = "movie";
        $result = $con->select($tbl, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imgsrc = $row["movie_banner"];
            $name = $row["name"];
        }
    }
}
?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;">
                <?php include('admin_sidenavbar.php'); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center mt-2" style="color:maroon;">Xóa Phim</h5>

                <form method="post">
                    <div class="container" style="color:maroon;">
                        <label><b>Hình Ảnh</b></label>
                        <br>
                        <img src="../<?php echo $imgsrc; ?>" alt="<?php echo $name; ?>" style="height:150px">
                        <br><br>

                        <label><b>Tên Phim</b></label>
                        <input type="text" style="border-radius:30px;" name="movie_name" value="<?php echo $name; ?>" disabled>
                        <br><br>

                        <button type="submit" name="btn_delete" class="btn" style="background-color:maroon; color:white">Xóa</button>
                        <a href="viewmovie.php" class="btn" style="background-color:maroon; color:white">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>