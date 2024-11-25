<?php
include("conn.php");
$con = new connec();
if(!isset($_SESSION)) {
    session_start();
}

if(isset($_GET["action"]))
{
        if($_GET["action"]== "logout")
        {
            $_SESSION["username"]=null;
            $_SESSION["cust_id"]=null;
        }
} 

if(empty($_SESSION["username"])) {
    $_SESSION["ul"] = '<li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modelId">Đăng Kí</a></li><li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#modelId1">Đăng Nhập</a></li>';
}

if(isset($_POST["btn_login"])) {
    $email_id = $_POST["log_email"];
    $paswrd_log = $_POST["log_psw"];

    // Mã hóa mật khẩu nhập vào để so sánh với mật khẩu trong cơ sở dữ liệu
    $hashed_password_log = hash('sha256', $paswrd_log);

    $result = $con->select_login("customer", $email_id);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // So sánh email và mật khẩu đã mã hóa
        if($row["email"] == $email_id && $row["password"] == $hashed_password_log) {
            $_SESSION["username"] = $row["fullname"];
            $_SESSION["cust_id"]  = $row["id"];
            $_SESSION["ul"]='<li class="nav-item"> <a class="nav-link"> Xin Chào '. $_SESSION["username"].'</a></li> <li class="nav-item"> <a class="nav-link" href="index.php?action=logout">Logout</a></li>';
        } 
        else {
            echo '<script>alert("Mật khẩu không đúng");</script>';
        }
    } else {
        echo '<script>alert("Email không đúng");</script>';
    }
}

if(isset($_POST["btn_reg"])) {
    $name = $_POST["reg_full_name"];
    $email = $_POST["reg_email"];
    $cellno = $_POST["reg_number_txt"];
    $gender = $_POST["reg_gender_txt"];
    $paswrd = $_POST["reg_psw"];
    $cnfrm_paswrd = $_POST["psw_repeat"];

    if($paswrd == $cnfrm_paswrd) {
        // Mã hóa mật khẩu
        $hashed_password = hash('sha256', $cnfrm_paswrd);
        
        // Cập nhật câu truy vấn với mật khẩu đã mã hóa
        $sql = "INSERT INTO customer VALUES (0, '$name', '$email', '$cellno', '$gender', '$hashed_password')";
        $con->insert($sql, "Đăng kí thành công");
    } else
    {
        ?>
        <script>alert("Mật khẩu không trùng khớp");</script>;
        <?php
    }
}
?>



<!doctype html>
<html lang="en">
<head>
    <title>Mephim</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="images/movie-film-frame-png.webp">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script scr="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
    * {box-sizing: border-box}

    /* Thêm padding vào containers */
    .container {
    padding: 16px;
    }

    /* full-width trường nhập dữ liệu */
    textarea,input[type=text],  input[type=password],input[type=tel], input[type=number], input[type=date]{
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
    }

    textarea,input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
    }

    /* Overwrite mặc định của thẻ hr */
    hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
    }

    /* Style cho nút gửi/đăng ký */
    .registerbtn {
    background-color: maroon;
    color: white;
    padding: 16px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 50%;
    opacity: 0.9;
    
    }

    .registerbtn:hover {
    opacity:1;
    }

    /* Thêm văn bản màu xanh vào liên kết */
    a {
    color: dodgerblue;
    }

    /* Đặt màu nền xám và căn giữa văn bản của phần "đăng nhập" */
    .signin {
    background-color: #f1f1f1;
    text-align: center;
    }

    body {
        background-color: #fdfcf0; /* Đặt màu nền */
    }

    .nav-link {
        text-decoration: none; /* Bỏ gạch chân */
        padding: 10px 15px; /* Thêm khoảng cách cho liên kết */
        border-radius: 5px; /* Bo góc */
        transition: background-color 0.3s, color 0.3s; /* Hiệu ứng chuyển tiếp */
    }   

    .nav-link:hover {
        background-color: #FFFFCC; /* Màu nền khi hover */
        color: whitesmoke; /* Màu chữ khi hover */
        cursor: pointer; /* Đảm bảo con trỏ chuột là pointer */

    }

</style>

</head>
<body>

<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #fcf7dd; color: black; border: 1px solid black;">
    <a class="navbar-brand" href="index.php"><img src="images/movie-film-frame-png.webp" style="width:60px;"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>

    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php" style="color: black;">Trang Chủ</a>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;">Phim</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="comingsoon.php" style="color: black;">Sắp Chiếu</a>
                    <a class="dropdown-item" href="nowshowing.php" style="color: black;">Đang Chiếu</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="offer.php" style="color: black;">Khuyến Mãi</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="booking.php" style="color: black;">Đặt Vé</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="about.php" style="color: black;">Về Chúng Tôi</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="contact.php" style="color: black;">Liên Hệ</a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <?php echo $_SESSION["ul"]; ?>
        </ul>
    </div>
</nav>


<!-- Register Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#212A37; color:aliceblue;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:aliceblue";>
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
            
            <form method="post">
                <div class="container" style="color:maroon;">
                    <center>
                        <h1>Tạo tài khoản mới</h1>
                        <p>Vui lòng điền đầy đủ thông tin để tạo tài khoản</p>
                    </center>
                    <hr>

                    <label for="username"><b>Họ Tên</b></label>
                    <input type="text" style="border-radius:30px;" placeholder="Nhập tên của bạn" name="reg_full_name" id="username"Required>

                    <label for="email"><b>Email</b></label>
                    <input type="text" style="border-radius:30px;" placeholder="Nhập email" name="reg_email" id="email" Required>

                    <label for="number"><b>Số điện thoại</b></label>
                    <input type="tel" style="border-radius:30px;" placeholder="Nhập số điện thoại" name="reg_number_txt" id="number" Required>

                    <label for="gender"><b>Giới tính</b></label>
                    <br>
                    <input type="radio" style="border-radius:30px;margin-right:2%" value="male" name="reg_gender_txt" id="gender" Required>Nam
                    <input type="radio" style="border-radius:30px;margin-left:5%;margin-right:2%" value="female" name="reg_gender_txt" id="gender" Required>Nữ
                    <br><br>

                    <label for="psw"><b>Mật khẩu</b></label>
                    <input type="password" style="border-radius:30px;" placeholder="Nhập mật khẩu" name="reg_psw" id="psw" Required>

                    <label for="psw-repeat"><b>Nhập lại mật khẩu</b></label>
                    <input type="password" style="border-radius:30px;" placeholder="Nhập lại mật khẩu" name="psw_repeat" id="psw_repeat" Required>

                    <button type="submit" class="btn" name="btn_reg" style="background-color:maroon; color:white">Đăng Kí</button>
                    <hr>
                </div>

            <div class="container">
                <p>Đã có tài khoản? <a style="color:gray" data-toggle="modal" data-target="#modelId1" data-dismiss="modal"> Đăng nhập ngay</a></p>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>


<!-- Login Modal -->
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#212A37; color:aliceblue;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:aliceblue">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
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
</div>