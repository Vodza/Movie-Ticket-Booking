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
    $sql = "SELECT seat_reserved.id, seat_reserved.show_id, customer.fullname, seat_reserved.seat_number, seat_reserved.reserved FROM seat_reserved, customer WHERE seat_reserved.cust_id=customer.id;";
    $result = $con->select_by_query($sql);
    ?>

            
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Chi Tiết Ghế Đã Đặt</h5>

                            <table class="table mt-5" border="1">
                                <thead style="background-color:maroon;color:white;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Khách Hàng</th>
                                        <th>Số Ghế</th>
                                        <th>Trạng Thái</th>
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
                                                    <td><?php echo $row["fullname"]; ?></td>
                                                    <td><?php echo $row["seat_number"]; ?></td>
                                                    <td>
                                                        <?php
                                                            if($row["reserved"]==0)
                                                            {
                                                                echo "Đã được đặt";
                                                            }
                                                            else
                                                            {
                                                                echo "Còn trống";
                                                            }
                                                        ?>
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