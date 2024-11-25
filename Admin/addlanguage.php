<?php
session_start();

if (isset($_POST["btn_insert"])) {
    include("../conn.php");
    $lang_name = $_POST["lang_name_txt"];
    $con = new connec();

    $sql = "INSERT INTO language (id, lang_name) VALUES (0, '$lang_name')";
    if ($con->insert($sql, "Thêm ngôn ngữ thành công")) {
        header("Location:viewlanguage.php");
        exit();
    } else {
        echo "<script>alert('Thêm ngôn ngữ thất bại');</script>";
    }
}

if (empty($_SESSION["admin_username"])) {
    header("Location:index.php");
    exit();
} else {
    include("admin_header.php");
}
?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;">
                <?php include('admin_sidenavbar.php'); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center mt-2" style="color:maroon;">Thêm Ngôn Ngữ</h5>
                <form method="post">
                    <div class="container" style="color:maroon;">
                        <label for="lang_name"><b>Tên Ngôn Ngữ</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập tên ngôn ngữ" name="lang_name_txt" required>
                        <br><br>
                        <button type="submit" name="btn_insert" class="btn btn-success">Thêm</button>
                        <a href="viewlanguage.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
