<?php
include("header.php");

if(isset($_POST["btn_submit"]))
{
    $name=$_POST["name"];
    $email=$_POST["email"];
    $no=$_POST["number"];
    $messg=$_POST["message"];

    $sql = "INSERT INTO contact VALUES (0,'$name', '$email', '$no', '$messg', now())";

    $con=new connec();
    $con->insert($sql, "Chúng tôi sẽ sớm liên hệ với bạn qua địa chỉ email");
}
?>


<section style="min-height: 450px;">
    <div class="container" style="color:maroon;">

        <div class="col-md-12">
            <center>
                <h1>Liên Hệ Với Chúng Tôi</h1>
                <p>
                    Chúng tôi rất vui nếu chúng ta có thể làm việc cùng nhau.
                    Để lại tin nhắn của bạn bên dưới và chúng tôi sẽ trả lời sớm nhất có thể.
                </p>
            </center>
        </div>


        <div class="row" style="color:white;">
            <div class="col-md-6 mt-5 mb-5 pl-5" style="border-radius:30px;background-color: maroon;">
                <h2 class="mt-5">Thông tin liên hệ</h2>
                <p class="mt-1">
                    Chúng tôi sẽ trả lời bạn trong vòng 24h
                </p>

                <p class="mt-5"><i class="fa fa-phone mt-3"></i>&nbsp; +94 xxxxxx789</p>
                <p class="mt-3"><i class="fa fa-envelope mt-3"></i>&nbsp; abc@gmail.com</p>
                <p class="mt-3"><i class="fa fa-map-marker mt-3"></i>&nbsp; abc@gmail.com</p></p>

                <h2 class="mt-5">Gia nhập cùng chúng tôi</h2>
                <div class="mb-5">
                    <a href="https://www.facebook.com/" class="mt-5" style="color:white;"><i class="fa fa-facebook-square fa-2x mt-3"></i></a>
                    <a href="https://www.instagram.com/" class="mt-5 ml-3" style="color:white;"><i class="fa fa-instagram fa-2x mt-3"></i></a>
                    <a href="https://x.com/" class="mt-5 ml-3" style="color:white;"><i class="fa fa-twitter-square fa-2x mt-3"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <form method="post">
                    <div class="container" style="color:maroon;">

                        <label for="username"><b>Tên của bạn</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập tên" name="name" id="username"Required>

                        <label for="email"><b>Email</b></label>
                        <input type="text" style="border-radius:30px;" placeholder="Nhập email" name="email" id="email" Required>

                        <label for="number"><b>Số điện thoại</b></label>
                        <input type="tel" style="border-radius:30px;" placeholder="Nhập số điện thoại" name="number" id="number" Required>

                        <label for="message"><b>Tin nhắn của bạn</b></label>
                        <textarea name="message" id="message" rows="4" style="resize:none;width: 100%;border-radius:30px;"></textarea>

                        <button type="submit" name="btn_submit" style="background-color:maroon; color:white">Gửi tin nhắn</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>





</section>



<?php
include("footer.php");
?>
