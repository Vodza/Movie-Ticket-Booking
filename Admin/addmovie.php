<?php
session_start();

if(isset($_POST["btn_insert"]))
{
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

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_01))
    {
        include("../conn.php");
        $con = new connec();
        $sql = "INSERT INTO movie (name, movie_banner, rel_date, industry_id, genre_id, lang_id, duration, movie_desc) VALUES ('$name', '$target_file', '$rel_date', '$industry_id', '$genre_id', '$lang_id', '$duration', '$desc');";
        $con->insert($sql, "Thêm phim thành công");
        header("Location:viewmovie.php");
    }
    else
    {
        echo "Oops, đã có lỗi khi cập nhật tệp";
    }
}

if(empty($_SESSION["admin_username"]))
{
    header("Location:index.php");
}
else
{
    include("admin_header.php");

    // Giả sử bạn đã có các bảng để lấy danh sách thể loại, ngôn ngữ và quốc gia
    $con = new connec();
    $industries = $con->select_by_query("SELECT * FROM industry");
    $genres = $con->select_by_query("SELECT * FROM genre");
    $languages = $con->select_by_query("SELECT * FROM language");
?>

<style>
    .banner-img {
        width: 100%; /* Chiều rộng 100% */
        height: auto; /* Chiều cao tự động */
        max-height: 300px; /* Chiều cao tối đa cho banner */
    }
</style>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;">
                <?php include('admin_sidenavbar.php'); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center mt-2" style="color:maroon;">Thêm Phim</h5>

                <form method="post" enctype="multipart/form-data" class="mt-5">
                    <div class="container" style="color:maroon;">
                        <label><b>Chọn Ảnh</b></label>
                        <input type="file" style="border-radius:30px;" name="fileToUpload" id="fileToUpload" required>
                        <br><br>

                        <label><b>Tên Phim</b></label>
                        <input type="text" style="border-radius:30px;" name="movie_name" required>

                        <label><b>Ngày Ra Mắt</b></label>
                        <input type="date" style="border-radius:30px;" name="rel_date" required>

                        <label><b>Quốc Gia</b></label>
                        <select name="industry_id" style="border-radius:30px;" required>
                            <?php while($row = $industries->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['industry_name']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <label><b>Thể Loại</b></label>
                        <select name="genre_id" style="border-radius:30px;" required>
                            <?php while($row = $genres->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['genre_name']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <label><b>Ngôn Ngữ</b></label>
                        <select name="lang_id" style="border-radius:30px;" required>
                            <?php while($row = $languages->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['lang_name']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <label><b>Thời Gian Phim</b></label>
                        <input type="text" style="border-radius:30px;" name="duration" required>

                        <label><b>Mô Tả</b></label>
                        <textarea style="border-radius:30px;" name="movie_desc" required></textarea>

                        <button type="submit" name="btn_insert" class="btn btn-success">Thêm</button>
                        <a href="viewmovie.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include("admin_footer.php");
                            }
?>