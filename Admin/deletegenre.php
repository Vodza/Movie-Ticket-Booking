<?php
session_start();

$genre_name = "";

if (isset($_POST["btn_delete"])) {
    include("../conn.php");
    $id = $_GET["id"];
    $con = new connec();
    $table = "genre";

    // Thực hiện xóa bản ghi
    if ($con->delete($table, $id)) {
        echo "<script>alert('Xóa thể loại thành công');</script>";
    } else {
        echo "<script>alert('Xóa thể loại thất bại');</script>";
    }

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

        // Lấy thông tin của thể loại để hiển thị trước khi xóa
        $result = $con->select($tbl, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $genre_name = $row["genre_name"];
        } else {
            echo "<script>alert('Không tìm thấy thể loại');</script>";
            header("Location:viewgenre.php");
            exit();
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
                <h5 class="text-center mt-2" style="color:maroon;">Xóa Thể Loại</h5>

                <form method="post">
                    <div class="container" style="color:maroon;">
                        <label for="genre_name"><b>Tên Thể Loại</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Tên thể loại" name="genre_name" value="<?php echo $genre_name; ?>" readonly>

                        <br><br>
                        <button type="submit" name="btn_delete" class="btn btn-danger">Xóa</button>
                        <a href="viewgenre.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include("admin_footer.php");
?>
