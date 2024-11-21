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
    $tbl = "genre";

?>

            <section>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2" style="background-color:maroon;">
                                        <?php include('admin_sidenavbar.php'); ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h5 class="text-center mt-2" style="color:maroon;">Thêm Rạp</h5>

                                        <form method="post">
                                            <div class="container" style="color:maroon;">
                                                <center>
                                                    <h1>Đăng Nhập</h1>
                                                </center>
                                                <hr>

                                                    <label for="email"><b>Email</b></label>
                                                    <input type="text" style="border-radius:30px;" placeholder="Nhập email" name="log_email" id="email" Required>

                                                    <label for="psw"><b>Mật khẩu</b></label>
                                                    <input type="password" style="border-radius:30px;" placeholder="Nhập mật khẩu" name="log_psw" id="log_psw" Required>

                                                    <button type="submit" name="btn_login" class="btn" style="background-color:maroon; color:white">Đăng Nhập</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                                
                <?php
                include("admin_footer.php");
                }
                ?>
