<?php
session_start();

if(empty($_SESSION["admin_username"]))
{
    header("Location:index.php");
}

else
{

    include("admin_header.php");

    $con = new connec();
    $tbl = "hot_movies";
    $result = $con->select_all($tbl);
?>

            
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Danh sách phim hot</h5>
                            <a href="addhotmovie.php">Thêm phim hot</a>
                            <table class="table mt-5" border="1">
                                <thead style="background-color:maroon;color:white;">
                                    <tr>
                                        <th>Ảnh</th>
                                        <th>Tên</th>
                                        <th>Ngày Phát Hành</th>
                                        <th>Nút</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($result->num_rows>0)
                                        {
                                            while($row=$result->fetch_assoc())
                                            {
                                                ?>
                                                <tr>
                                                    <td><img src="../<?php echo $row["img_path"]; ?>" style="height:200px;"></td>
                                                    <td><?php echo $row["title"]; ?></td>
                                                    <td><?php echo $row["release_date"]; ?></td>
                                                    <td>
                                                        <a href="edithotmovie.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Chỉnh</a>
                                                        <a href="deletehotmovie.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Xóa</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
                    
    <?php
    include("admin_footer.php");
}
?>