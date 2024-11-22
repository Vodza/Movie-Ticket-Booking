<?php
session_start();

$industry_name = "";

if (isset($_POST["btn_update"])) {
    include("../conn.php");
    $industry_name = $_POST["industry_name_txt"];
    $id = $_GET["id"];
    $con = new connec();

    $sql = "UPDATE industry SET industry_name='$industry_name' WHERE id=$id";
    $con->insert($sql, "Cập Nhật quốc gia thành công");
    header("Location:viewindustry.php");
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
        $tbl = "industry";
        $result = $con->select($tbl, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $industry_name = $row["industry_name"];
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
                <h5 class="text-center mt-2" style="color:maroon;">Sửa Quốc Gia</h5>

                <form method="post">
                    <div class="container" style="color:maroon;">

                        <label for="industry_name"><b>Tên Quốc Gia</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập tên quốc gia" name="industry_name_txt" value="<?php echo $industry_name; ?>" required>

                        <br><br>
                        <button type="submit" name="btn_update" class="btn btn-primary">Cập Nhật</button>
                        <a href="viewindustry.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
