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
    $tbl = "language";
    $result = $con->select_all($tbl);
?>

            
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Ngôn Ngữ</h5>
                            <a href="addlanguage.php">Thêm ngôn ngữ</a>

                            <table class="table mt-5" border="1">
                                <thead style="background-color:maroon;color:white;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
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
                                                    <td><?php echo $row["id"]; ?></td>
                                                    <td><?php echo $row["lang_name"]; ?></td>
                                                    <td>
                                                        <a href="editlanguage.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Chỉnh</a>
                                                        <a href="deletelanguage.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Xóa</a>
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