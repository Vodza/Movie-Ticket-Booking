<?php
session_start();


$imgsrc="";
$alt_txt="";


if(isset($_POST["btn_update"]))
{
    include("../conn.php");
    $alt=$_POST["slider_alt_txt"];

    $target_dir="Images/";
    $target_file=$target_dir.$_FILES["fileToUpload"]["name"];

    $target_dir_01="../Images/";
    $target_file_01=$target_dir_01.$_FILES["fileToUpload"]["name"];

    $uploadOk=1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_01))
    {
        $id=$_GET["id"];
        $con = new connec();
        $sql = "update slider SET img_path='$target_file', alt='$alt' WHERE id=$id;";
        $con->insert($sql, "Cập Nhật thành công");
        header("Location:viewslider.php");
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

    if(isset($_GET["id"]))
    {
        $id=$_GET["id"];
        $con = new connec();
        $tbl = "slider";
        $result=$con->select($tbl, $id);
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc();
            $imgsrc=$row["img_path"];
            $alt_txt=$row["alt"];
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
                                        <h5 class="text-center mt-2" style="color:maroon;">Sửa Slider</h5>
                                        <form method="post" enctype="multipart/form-data" class="mt-5">
                                            <div class="container" style="color:maroon;">

                                                    <label><b>Chọn Ảnh</b></label>
                                                    <input type="file" style="border-radius:30px;" name="fileToUpload" id="fileToUpload" value="<?php echo $imgsrc; ?>" Required>
                                                    <br><br>
                                                    <img src="../<?php echo $imgsrc; ?>" alt="<?php echo $alt_txt; ?>" style="height:150px"
                                                    <br><br>

                                                    <label><b>Văn Bản Thay Thế</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập văn bản thay thế" name="slider_alt_txt" value="<?php echo $alt_txt; ?>" Required>

                                                    <button type="submit" name="btn_update" class="btn btn-primary">Cập Nhật</button>
                                                    <a href="viewslider.php" class="btn btn-secondary">Hủy</a>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </section>
                                
                <?php
                include("admin_footer.php");
                }
                ?>
