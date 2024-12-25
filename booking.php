
<?php
session_start();
if (empty($_SESSION["username"])) {
    header("Location:index.php");
} else {
    include("header.php");
}

$con = new connec();

// Lấy ID phim từ URL
$movie_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin show dựa trên ID phim
$sql_query="SELECT SELECT movie_ticket_booking.show.id, movie_ticket_booking.show.show_date, movie_ticket_booking.show.ticket_id, movie_ticket_booking.show.no_seat, movie.name AS 'movie_name', show_time.time, cinema.name FROM movie_ticket_booking.show, movie,show_time, cinema where movie_ticket_booking.show.movie_id=movie.id AND movie_ticket_booking.show.show_time_id =show_time.id AND movie_ticket_booking.show.cinema_id=cinema.id;";

// Lấy thông tin show dựa trên ID phim
$result = $con->select_show_dt();

// Kiểm tra nếu có shows
if ($result->num_rows > 0) {
    $shows = [];
    while ($row = $result->fetch_assoc()) {
        $shows[] = $row; // Lưu các show vào mảng
    }
} else {
    echo "Không có lịch chiếu nào cho phim này.";
    exit;
}

if (isset($_POST["btn_booking"])) {
    $con = new connec();

    $cust_id = $_POST["cust_id"];
    $show_id = $_POST["show_id"];
    $no_tikt = $_POST["no_ticket"];
    $total_amnt = (70000 * $no_tikt);

    $seat_number = $_POST["seat_dt"];
    $seat_arr = explode(", ", $seat_number);

    foreach ($seat_arr as $item) {
        $sql = "INSERT INTO seat_reserved VALUES(0, $show_id, $cust_id, '$item', 'true')";
        $abc = $con->insert_lastid($sql);
    }

    $sql = "INSERT INTO seat_detail VALUES(0, $cust_id, $show_id, $no_tikt)";
    $seat_dt_id = $con->insert_lastid($sql);

    $sql = "INSERT INTO booking VALUES(0, $cust_id, $show_id, $no_tikt, $seat_dt_id, NOW(), $total_amnt)";
    $con->insert($sql, "Đặt vé thành công");
}

?>

<section class="mt-5">
    <h3 class="text-center" style="color:maroon;">Đặt Vé</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div id="seat-map" id="seatCharts">
                    <h3 class="text-center mt-5" style="color:maroon;">Chọn Chỗ Ngồi</h3>
                    <hr>
                    <label class="text-center" style="width:100%;background-color:maroon;color:white;padding:2%; margin-left: -15px">
                        MÀN HÌNH
                    </label>

                    <div class="row" id="seat_chart"></div>

                    <!-- Hiển thị thông tin show -->
                    <h6 class="mt-5" style="color:maroon;">Chọn Lịch Chiếu</h6>
                    <form method="post" id="showForm">
                        <select name="show_id" id="show_id" required onchange="showBookingSection();">
                            <option value="">-- Chọn Lịch Chiếu --</option>
                            <?php foreach ($shows as $show): ?>
                                <option value="<?php echo $show['id']; ?>">
                                    <?php echo $show['movie_name'] . ' - ' . $show['name'] . ' - ' . $show['show_date'] . ' ' . $show['time']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                
                <form action="payment.php" method="post">
                <div id="bookingSection" style="display:none;">
                        <h6 class="mt-5" style="color:maroon;">Giá Vé</h6>
                        <p class="mt-1">70,000 VND</p>

                        <h6 class="mt-3" style="color:maroon;">Tổng Giá Vé</h6>
                        <p class="mt-1" id="price_details"></p>
                        
                    </div>
            </div>
                </form>
            <div class="col-md-5">
                <form method="post" action="payment.php" class="mt-5">
                    <div class="container" style="color:maroon;">
                        <center>
                            <p>Vui lòng điền thông tin để đặt vé</p>
                        </center>
                        <hr>
                        <label for="username"><b>Mã Khách Hàng</b></label>
                        <input type="number" style="border-radius:30px;" name="cust_id" required value="<?php echo $_SESSION['cust_id']; ?>" readonly>

                        <input type="hidden" name="show_id" id="hidden_show_id"> <!-- Lưu ID show -->

                        <label for="psw"><b>Số Vé</b></label>
                        <input type="number" style="border-radius:30px;" id="no_ticket" name="no_ticket" required  readonly>

                        <label for="psw-repeat"><b>Ghế Ngồi</b></label>
                        <input type="text" style="border-radius:30px;" name="seat_dt" id="seat_dt" required  readonly>
                        <input type="hidden" id="price_details_input" name="price_details" required>


                        <button type="submit" name="btn_booking" class="btn" style="background-color:maroon;color:white;">Xác nhận đặt vé</button>
                        <hr>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function showBookingSection() {
    var showId = document.getElementById("show_id").value;
    if (showId) {
        document.getElementById("bookingSection").style.display = "block";
        document.getElementById("hidden_show_id").value = showId; // Lưu ID show vào hidden input
        document.getElementById("no_ticket").disabled = false; // Kích hoạt trường số vé
        document.getElementById("seat_dt").disabled = false; // Kích hoạt trường ghế ngồi
        loadSeats(); // Tạo ghế ngồi khi lịch chiếu được chọn
    } else {
        document.getElementById("bookingSection").style.display = "none";
        document.getElementById("no_ticket").disabled = true; // Vô hiệu hóa trường số vé
        document.getElementById("seat_dt").disabled = true; // Vô hiệu hóa trường ghế ngồi
    }
}

function loadSeats() {
    $('#seat_chart').empty(); // Xóa ghế cũ nếu có
    for (var i = 1; i <= 4; i++) {
        for (var j = 1; j <= 10; j++) {
            $('#seat_chart').append('<div class="col-md-2 mt-2 mb-2 ml-2 mr-2 text-center" style="background-color:grey;color:white"><input type="checkbox" id="seat" value="R' + i + 'S' + j + '" name="seat_chart[]" class="mr-2 col-md-2 mb-2" onclick="checkboxtotal();">R' + i + 'S' + j + '</div>');
        }
    }
}

function checkboxtotal() {
    // Kiểm tra xem lịch chiếu đã được chọn hay chưa
    var showId = document.getElementById("show_id").value;
    if (!showId) {
        alert("Vui lòng chọn lịch chiếu trước khi chọn ghế.");
        return; // Dừng thực hiện hàm nếu chưa chọn lịch chiếu
    }

    var seat = [];
    $('input[name="seat_chart[]"]:checked').each(function() {
        seat.push($(this).val());
    });

    var st = seat.length;
    var total = st * 70000;
    document.getElementById('no_ticket').value = st;
    
    var totalFormatted = total.toLocaleString('vi-VN') + " VND";
    $('#price_details').text(total);

    $('#seat_dt').val(seat.join(", "));

    //lưu giá trị vào hàm ẩn
    document.getElementById('price_details_input').value = total;    
    }


</script>



<?php
include("footer.php");
?>
