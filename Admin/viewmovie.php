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
    $sql = "SELECT movie.id, movie.name, movie.movie_banner, movie.movie_desc, movie.rel_date, industry.industry_name, genre.genre_name, language.lang_name, movie.duration FROM movie, genre, industry, movie_ticket_booking.language WHERE movie.industry_id=industry.id AND movie.genre_id=genre.id AND movie.lang_id=language.id;";
    $result = $con->select_by_query($sql);
    ?>

            
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Danh sách phim</h5>
                            <a href="addmovie.php">Thêm phim</a>

                            <table class="table mt-5" border="1">
                                <thead style="background-color:maroon;color:white;">
                                    <tr>
                                        <th>Banner</th>
                                        <th>Tên</th>
                                        <th>Ngày ra mắt</th>
                                        <th>Quốc gia</th>
                                        <th>Thể loại</th>
                                        <th>Ngôn ngữ</th>
                                        <th>Mô tả</th>
                                        <th>Thời gian phim</th>
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
                                                    <td><img src="../<?php echo $row["movie_banner"]; ?>" style="height:200px;"></td>
                                                    <td><?php echo $row["name"]; ?></td>
                                                    <td><?php echo $row["rel_date"]; ?></td>
                                                    <td><?php echo $row["industry_name"]; ?></td>
                                                    <td><?php echo $row["genre_name"]; ?></td>
                                                    <td><?php echo $row["lang_name"]; ?></td>
                                                    <td><?php echo $row["movie_desc"]; ?></td>
                                                    <td><?php echo $row["duration"]; ?></td>
                                                    <td>
                                                        <a href="editmovie.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Chỉnh</a>
                                                        <a href="deletemovie.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Xóa</a>
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