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
    $sql = "SELECT seat_detail.id, customer.fullname,seat_detail.seat_no, movie_ticket_booking.show.id AS 'show_id', movie.name
    FROM
    seat_detail, customer, movie, movie_ticket_booking.show
    WHERE
    seat_detail.cust_id = customer.id AND
    seat_detail.show_id= movie_ticket_booking.show.id AND
    movie.id=movie_ticket_booking.show.movie_id;";
    $result = $con->select_by_query($sql);
    ?>

            
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Chi Tiết Ghế/h5>
                            <a href="addseat_detail.php">Đặt Ghế</a>

                            <table class="table mt-5" border="1">
                                <thead style="background-color:maroon;color:white;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Khách Hàng</th>
                                        <th>Số Ghế</th>
                                        <th>Tên Phim</th>
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
                                                    <td><?php echo $row["seat_no"]; ?></td>
                                                    <td><?php echo $row["name"]; ?></td>
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