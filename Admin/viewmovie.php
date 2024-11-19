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
                <div class="continer">
                    <div class="row">
                        <div class="col-md-2" style="background-color:maroon;">
                            <?php include('admin_sidenavbar.php'); ?>
                        </div>
                        <div class="col-md-10">
                            <h5 class="text-center mt-2" style="color:maroon;">Danh sách phim</h5>
                            <a href="addmovie.php">Thêm phim</a>
                        </div>
                    </div>
                </div>
            </section>
                    
    <?php
    include("admin_footer.php");
}
?>