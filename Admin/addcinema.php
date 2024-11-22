<?php
session_start();


if(isset($_POST["btn_insert"]))
{
    include("../conn.php");
    $name=$_POST["cinema_name_txt"];
    $location=$_POST["cinema_location_txt"];
    $city=$_POST["city_name_txt"];
    $con = new connec();

    $sql = "INSERT INTO cinema VALUES (0, '$name', '$location', '$city')";
    $con->insert($sql, "Thêm thành công");
    header("Location:viewcinema.php");
    
}

if(empty($_SESSION["admin_username"]))
{
    header("Location:index.php");
}

else
{

    include("admin_header.php");

?>

            <section>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2" style="background-color:maroon;">
                                        <?php include('admin_sidenavbar.php'); ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h5 class="text-center mt-2" style="color:maroon;">Thêm Rạp</h5>

                                        <form method="post">
                                            <div class="container" style="color:maroon;">

                                                    <label for="email"><b>Tên Rạp</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập tên rạp" name="cinema_name_txt" Required>

                                                    <label for="email"><b>Địa Chỉ Rạp</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập địa chỉ" name="cinema_location_txt" Required>

                                                    <label for="email"><b>Thành Phố</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập thành phố" name="city_name_txt" Required>

                                                    <button type="submit" name="btn_insert" class="btn btn-success">Thêm</button>
                                                    <a href="viewcinema.php" class="btn btn-secondary">Hủy</a>
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
