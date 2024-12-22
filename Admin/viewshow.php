<?php
session_start();

if (empty($_SESSION["admin_username"])) {
    header("Location:index.php");
} else {
    include("admin_header.php");

    // Kết nối với cơ sở dữ liệu
    $con = new connec();
    $tbl = "show"; // Tên bảng 'show'
    $result = $con->select_all($tbl);
?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="background-color:maroon;">
                <?php include('admin_sidenavbar.php'); ?>
            </div>
            <div class="col-md-10">
                <h5 class="text-center mt-2" style="color:maroon;">Danh sách suất chiếu</h5>
                <a href="addshow.php">Thêm suất chiếu</a>

                <table class="table mt-5" border="1">
                    <thead style="background-color:maroon;color:white;">
                        <tr>
                            <th>ID</th>
                            <th>ID Phim</th>
                            <th>Ngày Chiếu</th>
                            <th>ID Thời Gian</th>
                            <th>Số Ghế</th>
                            <th>ID Rạp</th>
                            <th>Giá Vé</th>
                            <th>Nút</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["movie_id"]; ?></td>
                                    <td><?php echo $row["show_date"]; ?></td>
                                    <td><?php echo $row["show_time_id"]; ?></td>
                                    <td><?php echo $row["no_seat"]; ?></td>
                                    <td><?php echo $row["cinema_id"]; ?></td>
                                    <td><?php echo $row["ticket_id"]; ?></td>
                                    <td>
                                        <a href="editshow.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Chỉnh</a>
                                        <a href="deleteshow.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Xóa</a>
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