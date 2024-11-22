<?php
session_start();
if(empty($_SESSION["username"]))
{
    header("Location:index.php");
}
else
{
    include("header.php");
}

$con=new connec();
$result=$con->select_show_dt();
$result1=$con->select_show_dt();


$sql_query="SELECT SELECT movie_ticket_booking.show.id, movie_ticket_booking.show.show_date, movie_ticket_booking.show.ticket_id, movie_ticket_booking.show.no_seat, movie.name AS 'movie_name', show_time.time, cinema.name FROM movie_ticket_booking.show, movie,show_time, cinema where movie_ticket_booking.show.movie_id=movie.id AND movie_ticket_booking.show.show_time_id =show_time.id AND movie_ticket_booking.show.cinema_id=cinema.id;";

$checked_value=0;

if(isset($_POST["btn_booking"]))
{
    $con=new connec();

    $cust_id=$_POST["cust_id"];
    $show_id=$_POST["show_id"];
    $no_tikt=$_POST["no_ticket"];
    $bkng_date=$_POST["booking_date"];
    $total_amnt=(70000 * $no_tikt);


    $seat_number=$_POST["seat_dt"];
    $seat_arr=explode(", ",$seat_number);

    foreach($seat_arr as $item)
    {
        $sql="insert into seat_reserved values(0,$show_id,$cust_id,'$item','true')";
        $abc= $con->insert_lastid($sql);
    }

    $sql="insert into seat_detail values(0,$cust_id,$show_id,$no_tikt)";
    $seat_dt_id=$con->insert_lastid($sql);


    $sql="insert into booking values(0,$cust_id,$show_id,$no_tikt,$seat_dt_id,'$bkng_date',$total_amnt)";
    $con->insert($sql,"Đặt vé thành công");
}



?>
<script>
$(document).ready(function()
{
    for(i=1;i<=4;i++)
    {
        for(j=1;j<=10;j++)
        {
        $('#seat_chart').append('<div class="col-md-2 mt-2 mb-2 ml-2 mr-2 text-center" style="background-color:grey;color:white"><input type="checkbox" id="seat" value="R'+(i+'S'+j)+'" name="seat_chart[]" class="mr-2  col-md-2 mb-2" onclick="checkboxtotal();" >R'+(i+'S'+j)+'</div>')
        }
    }

});

function change_option(mvalue)
{

    sessionStorage.setItem("movie_id_of_option", mvalue.value);
    alert(sessionStorage.getItem('movie_id_of_option'));

}

function checkboxtotal() {
    var seat = [];
    $('input[name="seat_chart[]"]:checked').each(function() {
        seat.push($(this).val());
    });

    var st = seat.length;
    document.getElementById('no_ticket').value = st;
    var total = (st * 70000).toLocaleString('vi-VN') + " VND";
    $('#price_details').text(total);

    $('#seat_dt').val(seat.join(", "));
}


</script>

<section class="mt-5">
    <h3 class="text-center"  style="color:maroon;">Đặt Vé</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div id="seat-map" id="seatCharts">
                <h3 class="text-center mt-5"  style="color:maroon;">Chọn Chỗ Ngồi</h3>
                    <hr>
                    <label class="text-center" style="width:100%;background-color:maroon;color:white;padding:2%; margin-left: -15px"> 
                        MÀN HÌNH
                    </label>

                    <div class="row" id="seat_chart">
                    </div>

                </div>


                <h6 class="mt-5"  style="color:maroon;">Tên Rạp Phim</h6>
                <p class="mt-1" id="cinema_name"></p>


                <h6 class="mt-3"  style="color:maroon;">Phim (Ngày và Giờ)</h6>
                <p class="mt-1" id="show_date_time"></p>

                <h6 class="mt-3"  style="color:maroon;">Giá Vé</h6>
                <p class="mt-1" id="price"></p>

                <h6 class="mt-3"  style="color:maroon;">Tổng Giá Vé</h6>
                <p class="mt-1" id="price_details"></p>

            </div>
            <div class="col-md-5">
                <form method="post" class="mt-5">
                    <div class="container" style="color:maroon;">
                        <center>
                            <p>Vui lòng điền thông tin để đặt vé</p>
                        </center>
                    <hr>
                        <label for="username"><b>Mã Khách Hàng</b></label>
                        <input type="number" style="border-radius:30px;" name="cust_id" required value="<?php echo $_SESSION['cust_id']; ?>" readonly>

                        <label for="email"><b>Phim</b></label>
                        <div class="form-group">
                            <select class="form-control"  name="show_id" style="border-radius:30px;">
                            <option>Select Show</option>
                            <?php

                                if($result->num_rows>0)
                                {
                                    while($row=$result->fetch_assoc())
                                    {
                                        echo '<option value="'.$row["id"].'">'.$row["movie_name"].'</option>';
                                    }
                                }
                            ?>
                            </select>
                        </div>

                        <label for="psw"><b>Số Vé</b></label>
                        <input type="number" style="border-radius:30px;" id="no_ticket" name="no_ticket"  required>

                        <label for="psw-repeat"><b>Ghế Ngồi</b></label>
                        <input type="text" style="border-radius:30px;" name="seat_dt" id="seat_dt" required>

                        <label for="number"><b>Ngày Đặt Vé</b></label>
                        <input type="date" style="border-radius:30px;" name="booking_date"  required>
                            
                        <button type="submit" name="btn_booking" class="btn" style="background-color:maroon;color:white;">Xác nhận đặt vé</button>
                        <hr>
                    </div>

                

                </form>
            </div>
        </div>
    </div>
</section>


<?php
include("footer.php");
?>