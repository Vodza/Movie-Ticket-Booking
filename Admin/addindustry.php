<?php
session_start();

if (isset($_POST["btn_insert"])) {
    include("../conn.php");
    $industry_name = $_POST["industry_name_txt"];
    $con = new connec();

    $sql = "INSERT INTO industry (id, industry_name) VALUES (0, '$industry_name')";
    $con->insert($sql, "Thêm quốc gia thành công");
    header("Location:viewindustry.php");
    exit();
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
                <h5 class="text-center mt-2" style="color:maroon;">Thêm Quốc Gia</h5>

                <form method="post">
                    <div class="container" style="color:maroon;">

                        <label for="industry_name"><b>Tên Quốc Gia</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập tên quốc gia" name="industry_name_txt" required>

                        <br><br>
                        <button type="submit" name="btn_insert" class="btn btn-success">Thêm</button>
                        <a href="viewindustry.php" class="btn btn-secondary">Hủy</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
