<?php
session_start();

if (isset($_POST["btn_delete"])) {
    include("../conn.php");
    $id = $_GET["id"];
    $table = "industry";
    $con = new connec();

    $con->delete($table, $id);
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
                <h5 class="text-center mt-2" style="color:maroon;">Xóa Quốc Gia</h5>

                <form method="post">
                    <div class="container" style="color:maroon;">
                        <p><b>Bạn có chắc chắn muốn xóa quốc gia: <?php echo $industry_name; ?>?</b></p>

                        <button type="submit" name="btn_delete" class="btn" style="background-color:maroon; color:white">Xóa</button>
                        <a href="viewindustry.php" class="btn" style="background-color:maroon; color:white">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("admin_footer.php"); ?>
