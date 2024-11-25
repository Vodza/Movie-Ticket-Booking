<?php
session_start();

$lang_name = "";

if (isset($_POST["btn_update"])) {
    include("../conn.php");
    $lang_name = $_POST["lang_name_txt"];
    $id = $_GET["id"];
    $con = new connec();

    $sql = "UPDATE language SET lang_name='$lang_name' WHERE id=$id";
    if ($con->insert($sql, "Cập nhật thành công")) {
        header("Location:viewlanguage.php");
        exit();
    } else {
        echo "<script>alert('Cập nhật thất bại');</script>";
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
        $tbl = "language";

        $result = $con->select($tbl, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lang_name = $row["lang_name"];
        } else {
            echo "<script>alert('Không tìm thấy ngôn ngữ');</script>";
            header("Location:viewlanguage.php");
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
                <h5 class="text-center mt-2" style="color:maroon;">Sửa Ngôn Ngữ</h5>
                <form method="post">
                    <div class="container" style="color:maroon;">
                        <label for="lang_name"><b>Tên Ngôn Ngữ</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập tên ngôn ngữ" name="lang_name_txt" value="<?php echo $lang_name; ?>" required>
                        <br><br>
                        <button type="submit" name="btn_update" class="btn btn-primary">Cập Nhật</button>
                        <a href="viewlanguage.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
