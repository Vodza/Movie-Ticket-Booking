<?php
session_start();

$genre_name = "";

if (isset($_POST["btn_update"])) {
    include("../conn.php");
    $genre_name = $_POST["genre_name_txt"];

    $id = $_GET["id"];
    $con = new connec();
    $sql = "UPDATE genre SET genre_name='$genre_name' WHERE id=$id;";
    $con->insert($sql, "Cập Nhật thể loại thành công");
    header("Location:viewgenre.php");
    exit();
}

if (empty($_SESSION["admin_username"])) {
    header("Location:index.php");
    exit();
} else {
    include("admin_header.php");

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $con = new connec();
        $tbl = "genre";
        $result = $con->select($tbl, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $genre_name = $row["genre_name"];
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
                <h5 class="text-center mt-2" style="color:maroon;">Chỉnh Sửa Thể Loại</h5>
                <form method="post">
                    <div class="container" style="color:maroon;">

                        <label for="genre_name"><b>Tên Thể Loại</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập tên thể loại" name="genre_name_txt" value="<?php echo $genre_name; ?>" required>

                        <br><br>
                        <button type="submit" name="btn_update" class="btn btn-primary">Cập Nhật</button>
                        <a href="viewgenre.php" class="btn btn-secondary">Hủy</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
