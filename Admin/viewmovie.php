<?php
session_start();

if(empty($_SESSION["admin_username"]))
{
    header("Location:index.php");
}

else
{

    include("admin_header.php");
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
                                        <th>Thời gian phim</th>
                                        <th>Thể loại</th>
                                        <th>Nút</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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