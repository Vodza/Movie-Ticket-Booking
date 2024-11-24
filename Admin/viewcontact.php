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
    $tbl = "contact";
    $result = $con->select_all($tbl);
?>

            
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Tất Cả Tin Nhắn</h5>

                            <table class="table mt-5" border="1">
                                <thead style="background-color:maroon;color:white;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>SDT</th>
                                        <th>Tin nhắn</th>
                                        <th>Ngày gửi</th>
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
                                                    <td><?php echo $row["name"]; ?></td>
                                                    <td><?php echo $row["email"]; ?></td>
                                                    <td><?php echo $row["num"]; ?></td>
                                                    <td><?php echo $row["msg"]; ?></td>
                                                    <td><?php echo $row["msg_date"]; ?></td>
                                                    <td>
                                                        <a href="editcontact.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Chỉnh</a>
                                                        <a href="deletecontact.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Xóa</a>
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