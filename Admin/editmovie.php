<?php
session_start();

$imgsrc = "";
$movie_id = "";
$name = ""; // Khởi tạo biến
$rel_date = "";
$industry_id = "";
$genre_id = "";
$lang_id = "";
$duration = "";
$desc = "";

if(empty($_SESSION["admin_username"])) {
    header("Location:index.php");
    exit();
}

if(isset($_POST["btn_update"])) {
    include("../conn.php");
    
    $movie_id = $_GET["id"];
    $name = $_POST["movie_name"];
    $rel_date = $_POST["rel_date"];
    $industry_id = $_POST["industry_id"];
    $genre_id = $_POST["genre_id"];
    $lang_id = $_POST["lang_id"];
    $duration = $_POST["duration"];
    $desc = $_POST["movie_desc"];
    
    $target_dir = "Images/";
    $target_file = $target_dir . $_FILES["fileToUpload"]["name"];
    $target_dir_01 = "../Images/";
    $target_file_01 = $target_dir_01 . $_FILES["fileToUpload"]["name"];
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_01)) {
        $con = new connec();
        $sql = "UPDATE movie SET name='$name', movie_banner='$target_file', rel_date='$rel_date', industry_id='$industry_id', genre_id='$genre_id', lang_id='$lang_id', duration='$duration', movie_desc='$desc' WHERE id='$movie_id';";
        $con->insert($sql, "Cập nhật phim thành công");
        header("Location:viewmovie.php");
        exit();
    } else {
        echo "Oops, đã có lỗi khi cập nhật tệp";
    }
}

if(empty($_SESSION["admin_username"])) {
    header("Location:index.php");
    exit();
} else {
    include("admin_header.php");
}
    // Sử dụng filter_input để lấy ID từ GET
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    if($id) { // Kiểm tra xem ID có hợp lệ không
        $con = new connec();
        $tbl = "movie"; // Bảng phim
        $result = $con->select($tbl, $id);
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imgsrc = $row["movie_banner"]; // Trường hình ảnh của phim
            $name = $row["name"]; // Trường tên phim
            $rel_date = $row["rel_date"]; // Trường ngày ra mắt
            $industry_id = $row["industry_id"]; // ID quốc gia
            $genre_id = $row["genre_id"]; // ID thể loại
            $lang_id = $row["lang_id"]; // ID ngôn ngữ
            $duration = $row["duration"]; // Thời gian phim
            $desc = $row["movie_desc"]; // Mô tả phim
        } else {
            echo "Không tìm thấy phim với ID đã cho.";
        }
    } else {
        echo "ID không hợp lệ.";
    }
?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;">
                <?php include('admin_sidenavbar.php'); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center mt-2" style="color:maroon;">Chỉnh Sửa Phim</h5>
                <form method="post" enctype="multipart/form-data" class="mt-5">
                    <div class="container" style="color:maroon;">
                        <label><b>Chọn Ảnh (Banner)</b></label>
                        <input type="file" style="border-radius:30px;" name="fileToUpload" id="fileToUpload" required>
                        <br><br>
                        <img src="../<?php echo $imgsrc; ?>" alt="Banner" style="height:150px;">
                        <br><br>

                        <label><b>Tên Phim</b></label>
                        <input type="text" style="border-radius:30px;" name="movie_name" value="<?php echo $name; ?>" required>

                        <label><b>Ngày Ra Mắt</b></label>
                        <input type="date" style="border-radius:30px;" name="rel_date" value="<?php echo $rel_date; ?>" required>

                        <label><b>Quốc Gia</b></label>
                        <select name="industry_id" style="border-radius:30px;" required>
                            <?php 
                            $industries = $con->select_by_query("SELECT * FROM industry");
                            while($row = $industries->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $industry_id) echo 'selected'; ?>><?php echo $row['industry_name']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <label><b>Thể Loại</b></label>
                        <select name="genre_id" style="border-radius:30px;" required>
                            <?php 
                            $genres = $con->select_by_query("SELECT * FROM genre");
                            while($row = $genres->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $genre_id) echo 'selected'; ?>><?php echo $row['genre_name']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <label><b>Ngôn Ngữ</b></label>
                        <select name="lang_id" style="border-radius:30px;" required>
                            <?php 
                            $languages = $con->select_by_query("SELECT * FROM language");
                            while($row = $languages->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $lang_id) echo 'selected'; ?>><?php echo $row['lang_name']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <label><b>Thời Gian Phim</b></label>
                        <input type="text" style="border-radius:30px;" name="duration" value="<?php echo $duration; ?>" required>

                        <label><b>Mô Tả</b></label>
                        <textarea style="border-radius:30px;" name="movie_desc" required><?php echo $desc; ?></textarea>

                        <button type="submit" name="btn_update" class="btn btn-primary">Cập Nhật</button>
                        <a href="viewmovie.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include("admin_footer.php");
?>