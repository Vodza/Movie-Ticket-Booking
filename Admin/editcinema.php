<?php
session_start();

$n="";
$l="";
$c="";

if(isset($_POST["btn_update"]))
{
    include("../conn.php");
    $name=$_POST["cinema_name_txt"];
    $location=$_POST["cinema_location_txt"];
    $city=$_POST["city_name_txt"];

    $id=$_GET["id"];
    $con = new connec();
    $sql = "update cinema SET name='$name', location='$location', city='$city' WHERE id=$id;";
    $con->insert($sql, "Cập Nhật thành công");
    header("Location:viewcinema.php");
    
}

if(empty($_SESSION["admin_username"]))
{
    header("Location:index.php");
}

else
{

    include("admin_header.php");

    if(isset($_GET["id"]))
    {
        $id=$_GET["id"];
        $con = new connec();
        $tbl = "cinema";
        $result=$con->select($tbl, $id);
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc();
            $n=$row["name"];
            $l=$row["location"];
            $c=$row["city"];
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
                                        <h5 class="text-center mt-2" style="color:maroon;">Sửa Rạp</h5>

                                        <form method="post">
                                            <div class="container" style="color:maroon;">

                                                    <label for="email"><b>Tên Rạp</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập tên rạp" name="cinema_name_txt" value="<?php echo $n; ?>" Required>

                                                    <label for="email"><b>Địa Chỉ Rạp</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập địa chỉ" name="cinema_location_txt" value="<?php echo $l; ?>" Required>

                                                    <label for="email"><b>Thành Phố</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập thành phố" name="city_name_txt" value="<?php echo $c; ?>" Required>

                                                    <button type="submit" name="btn_update" class="btn btn-primary">Cập Nhật</button>
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
