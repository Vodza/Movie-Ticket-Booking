<?php
include("header.php");

$con = new connec();
$tbl = "movie";
$result = $con->select_movie($tbl, "nowshowing");

?>


<section class="mt-5">
    <h5 class="text-center" style="color:maroon;">Đang Chiếu</h5>
    <div class="container">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ind = $con->select("industry", $row["industry_id"]);
                    $indrow = $ind->fetch_assoc();

                    $lang = $con->select("language", $row["lang_id"]);
                    $langrow = $lang->fetch_assoc();

                    $gen = $con->select("genre", $row["genre_id"]);
                    $genrow = $gen->fetch_assoc();
                    ?>
                    <div class="col-md-3">

                        <img src="<?php echo htmlspecialchars($row["movie_banner"]); ?>" style="width: 100%; height: 250px; object-fit: contain; alt="Movie Banner" />

                        <h6 class="text-center mt-2" style="height:30px;"><?php echo htmlspecialchars($row["name"]); ?></h6>
                        <p><b>Ngày Phát Hành: </b><?php echo htmlspecialchars($row["rel_date"]); ?></p>
                        <p><b>Quốc Gia: </b><?php echo htmlspecialchars($indrow["industry_name"]); ?></p>
                        <p><b>Ngôn Ngữ: </b><?php echo htmlspecialchars($langrow["lang_name"]); ?></p>
                        <p><b>Thể Loại: </b><?php echo htmlspecialchars($genrow["genre_name"]); ?></p>
                        <a class="btn" href="detail.php?id=<?php echo htmlspecialchars($row['id']); ?>" style="background-color:maroon; color:white; width:100%; margin: 10px 0;">Chi tiết</a>
                        <a class="btn" href="booking.php?id=<?php echo htmlspecialchars($row['id']); ?>" style="background-color:maroon; color:white; width:100%">Đặt vé ngay</a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<?php
include("footer.php");
?>
