<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include ("connection/connect.php");
if (isset($_POST['submit']))
{
    if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['cpassword']) || empty($_POST['cpassword']))
    {
        $message = "Không được để trống thông tin";
    }
    else
    {
        //check user xem co bi trung` khong
        $check_username = mysqli_query($db, "SELECT username FROM users where username = '" . $_POST['username'] . "' ");
        $check_email = mysqli_query($db, "SELECT email FROM users where email = '" . $_POST['email'] . "' ");

        if ($_POST['password'] != $_POST['cpassword'])
        {
            $message = "Mật khẩu không trùng khớp";
        }
        elseif (strlen($_POST['password']) < 6)
        {
            $message = "Mật khẩu phải lớn hơn 6 kí tự";
        }
        elseif (strlen($_POST['phone']) < 10)
        {
            $message = "Số điện thoại không hợp lệ";
        }

        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $message = "Email không hợp lệ, xin vui lòng nhập đúng email";
        }
        elseif (mysqli_num_rows($check_username) > 0)
        {
            $message = 'Tên tài khoản đã tồn tại!';
        }
        elseif (mysqli_num_rows($check_email) > 0)
        {
            $message = 'Email này đã tồn tại!';
        }
        else
        {

            //truy xuat du lieu trong database
            $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('" . $_POST['username'] . "','" . $_POST['firstname'] . "','" . $_POST['lastname'] . "','" . $_POST['email'] . "','" . $_POST['phone'] . "','" . md5($_POST['password']) . "','" . $_POST['address'] . "')";
            mysqli_query($db, $mql);
            $success = "Tạo tài khoản thành công! <p>Bạn sẽ được trở về nới đăng nhập <span id='counter'>5</span> giây(s).</p>
      <script type='text/javascript'>
      function countdown() {
         var i = document.getElementById('counter');
         if (parseInt(i.innerHTML)<=0) {
            location.href = 'login.php';
         }
         i.innerHTML = parseInt(i.innerHTML)-1;
      }
      setInterval(function(){ countdown(); },1000);
      </script>'";
            header("refresh:5;url=login.php");
        }
    }

}

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Koji Food - Đăng Nhập</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>

    <!--header starts-->
    <header id="header" class="header-scroll top-header headrom">
        <!-- .navbar -->
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button"
                    data-toggle="collapse"
                    data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img
                        class="img-rounded" src="images/logo1.png" alt=""> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right"
                    id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active"
                                href="index.php">Trang Chủ <span
                                    class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active"
                                href="restaurants.php">Nhà hàng <span
                                    class="sr-only"></span></a> </li>


                        <?php
if (empty($_SESSION["user_id"])) // if user is not login

{
    echo '<li class="nav-item"><a href="login.php" class="nav-link active">Đăng Nhập</a> </li>
                        <li class="nav-item"><a href="registration.php" class="nav-link active">Đăng Ký</a> </li>';
}
else
{
    //if user is login
    echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Đơn Đặt</a> </li>';
    echo '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> ' . $_SESSION["username"] . '</a>
                                <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                    <ul class="dropdown-user" style="
                                    background-color: white !important;">
                                    <li> <a class="dropdown-item" href="change_password.php"><i class="fa fa-gear"></i> Đổi mật khẩu</a> </li>
                                    <li> <a class="dropdown-item" href="Logout.php"><i class="fa fa-power-off"></i> Đăng Xuất </a> </li>
                                    
                                    </ul>
                                </div>
                              </li>';
}

?>

                    </ul>

                </div>
            </div>
        </nav>
        <!-- /.navbar -->
    </header>
    <div class="page-wrapper">
        <div class="breadcrumb">
            <div class="container">
                <ul>
                    <li><a href="#" class="active">
                            <span
                                style="color:red;"><?php echo $message; ?></span>
                            <span style="color:green;">
                                <?php echo $success; ?>
                            </span>

                        </a></li>

                </ul>
            </div>
        </div>
        <section class="contact-page inner-page">
            <div class="container">
                <div class="row">
                    <!-- REGISTER -->
                    <div class="col-md-8">
                        <div class="widget">
                            <div class="widget-body">

                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Tên
                                                tài khoản</label>
                                            <input class="form-control"
                                                type="text" name="username"
                                                id="example-text-input"
                                                placeholder="UserName">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label
                                                for="exampleInputEmail1">Họ</label>
                                            <input class="form-control"
                                                type="text" name="firstname"
                                                id="example-text-input"
                                                placeholder="First Name">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label
                                                for="exampleInputEmail1">Tên</label>
                                            <input class="form-control"
                                                type="text" name="lastname"
                                                id="example-text-input-2"
                                                placeholder="Last Name">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Địa
                                                chỉ Email</label>
                                            <input type="text"
                                                class="form-control"
                                                name="email"
                                                id="exampleInputEmail1"
                                                aria-describedby="emailHelp"
                                                placeholder="Enter email">
                                            <small id="emailHelp"
                                                class="form-text text-muted">We"ll
                                                never share your email with
                                                anyone else.</small>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Số
                                                điện thoại</label>
                                            <input class="form-control"
                                                type="text" name="phone"
                                                id="example-tel-input-3"
                                                placeholder="Phone"> <small
                                                class="form-text text-muted">We"ll
                                                never share your email with
                                                anyone else.</small>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label
                                                for="exampleInputPassword1">Mật
                                                khẩu</label>
                                            <input type="password"
                                                class="form-control"
                                                name="password"
                                                id="exampleInputPassword1"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label
                                                for="exampleInputPassword1">Nhập
                                                lại mật khẩu</label>
                                            <input type="password"
                                                class="form-control"
                                                name="cpassword"
                                                id="exampleInputPassword2"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="exampleTextarea">Địa chỉ
                                                nơi ở vận chuyển</label>
                                            <textarea class="form-control"
                                                id="exampleTextarea"
                                                name="address"
                                                rows="3"></textarea>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p> <input type="submit"
                                                    value="Đăng Ký"
                                                    name="submit"
                                                    class="btn theme-btn"> </p>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- end: Widget -->
                        </div>
                        <!-- /REGISTER -->
                    </div>
                    <!-- WHY? -->
                    <div class="col-md-4">
                        <h4>Tạp chí & cẩm nang công thức</h4>
                        <p>Các phương thức luôn được đề cập mọi toàn quốc tại
                            Koji Food</p>
                        <hr>
                        <img src="https://res.cloudinary.com/dbmfupfkf/image/upload/v1674445486/cld-sample-4.jpg"
                            alt="" class="img-fluid">
                        <p></p>
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a
                                        data-parent="#accordion"
                                        data-toggle="collapse"
                                        class="panel-toggle collapsed"
                                        href="#faq1" aria-expanded="false"><i
                                            class="ti-info-alt"
                                            aria-hidden="true"></i>Can I viverra
                                        sit amet quam eget lacinia?</a></h4>
                            </div>
                            <div class="panel-collapse collapse" id="faq1"
                                aria-expanded="false" role="article"
                                style="height: 0px;">
                                <div class="panel-body"> Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Etiam
                                    rutrum ut erat a ultricies. Phasellus non
                                    auctor nisi, id aliquet lectus. Vestibulum
                                    libero eros, aliquet at tempus ut,
                                    scelerisque sit amet nunc. Vivamus id porta
                                    neque, in pulvinar ipsum. Vestibulum sit
                                    amet quam sem. Pellentesque accumsan
                                    consequat venenatis. Pellentesque sit amet
                                    justo dictum, interdum odio non, dictum
                                    nisi. Fusce sit amet turpis eget nibh
                                    elementum sagittis. Nunc consequat lacinia
                                    purus, in consequat neque consequat id.
                                </div>
                            </div>
                        </div>
                        <!-- end:panel -->
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a
                                        data-parent="#accordion"
                                        data-toggle="collapse"
                                        class="panel-toggle" href="#faq2"
                                        aria-expanded="true"><i
                                            class="ti-info-alt"
                                            aria-hidden="true"></i>Can I viverra
                                        sit amet quam eget lacinia?</a></h4>
                            </div>
                            <div class="panel-collapse collapse" id="faq2"
                                aria-expanded="true" role="article">
                                <div class="panel-body"> Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Etiam
                                    rutrum ut erat a ultricies. Phasellus non
                                    auctor nisi, id aliquet lectus. Vestibulum
                                    libero eros, aliquet at tempus ut,
                                    scelerisque sit amet nunc. Vivamus id porta
                                    neque, in pulvinar ipsum. Vestibulum sit
                                    amet quam sem. Pellentesque accumsan
                                    consequat venenatis. Pellentesque sit amet
                                    justo dictum, interdum odio non, dictum
                                    nisi. Fusce sit amet turpis eget nibh
                                    elementum sagittis. Nunc consequat lacinia
                                    purus, in consequat neque consequat id.
                                </div>
                            </div>
                        </div>
                        <!-- end:Panel -->
                        <h4 class="m-t-20">Contact Customer Support</h4>
                        <p> If you"re looking for more help or have a question
                            to ask, please </p>
                        <p> <a href="contact.html"
                                class="btn theme-btn m-t-15">contact us</a> </p>
                    </div>
                    <!-- /WHY? -->
                </div>
            </div>
        </section>
        <section class="app-section">
            <div class="app-wrap">
                <div class="container">
                    <div class="row text-img-block text-xs-left">
                        <div class="container">
                            <div
                                class="col-xs-12 col-sm-6  right-image text-center">
                                <figure> <img src="images/app.png"
                                        alt="Right Image"> </figure>
                            </div>
                            <div class="col-xs-12 col-sm-6 left-text">
                            <h3>Ứng dụng giao đồ ăn tốt nhất</h3>
                                 <p>Giờ đây, bạn có thể chế biến món ăn ở mọi nơi
                                     bạn cảm ơn sự dễ sử dụng miễn phí
                                     Giao đồ ăn &amp; Ứng dụng mang đi.</p>
                                <div class="social-btns">
                                    <a href="#" class="app-btn apple-button clearfix">
                                        <div class="pull-left"><i class="fa fa-apple"></i> </div>
                                        <div class="pull-right"> <span class="text">Có sẵn trên</span>
                                             <span class="text-2">Cửa hàng ứng dụng</span>
                                        </div>
                                    </a>
                                    <a href="#" class="app-btn android-button clearfix">
                                        <div class="pull-left"><i class="fa fa-android"></i> </div>
                                        <div class="pull-right"> <span class="text">Có sẵn trên</span>
                                             <span class="text-2">Cửa hàng Play</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- start: FOOTER -->
        <footer class="footer">
            <div class="container">
                <!-- top footer statrs -->
                <div class="row top-footer">
                    <div
                        class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                        <a href="#"> <img src="images/logo.png"
                        alt="Footer logo"> </a> <span>Giao đơn hàng
                             &amp; Mang đi </span>
                    </div>
                    <div class="col-xs-12 col-sm-2 about color-gray">
                    <h5>Giới thiệu về chúng tôi</h5>
                        <li><a href="#">Giới thiệu về chúng tôi</a> </li>
                             <li><a href="#">Lịch sử</a> </li>
                             <li><a href="#">Nhóm của chúng tôi</a> </li>
                        </ul>
                    </div>
                    <div
                        class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                        <h5>Cách thức hoạt động</h5>
                         <ul>
                             <li><a href="#">Nhập vị trí của bạn</a> </li>
                             <li><a href="#">Chọn nhà hàng</a> </li>
                             <li><a href="#">Chọn bữa ăn</a> </li>
                             <li><a href="#">Thanh toán qua thẻ tín dụng</a> </li>
                             <li><a href="#">Chờ giao hàng</a> </li>
                         </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2 pages color-gray">
                    <h5>Trang</h5>
                         <ul>
                             <li><a href="#">Trang kết quả tìm kiếm</a> </li>
                             <li><a href="#">Trang đăng ký của người dùng</a> </li>
                             <li><a href="#">Trang định giá</a> </li>
                             <li><a href="#">Đặt hàng</a> </li>
                             <li><a href="#">Thêm vào giỏ hàng</a> </li>
                         </ul>
                    </div>
                    <div
                        class="col-xs-12 col-sm-3 popular-locations color-gray">
                        <h5>Địa chỉ</h5>
                         <ul>
                             <li><a href="#">Nguyen Xa, Minh Khai, Bac Tu Liem, Ha Noi</a> </li>
                         </ul>
                    </div>
                </div>
                <!-- top footer ends -->
                <!-- bottom footer statrs -->
                <div class="row bottom-footer">
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-xs-12 col-sm-3 payment-options color-gray">
                                <h5>Tùy chọn thanh toán</h5>
                                <ul>
                                    <li>
                                        <a href="#"> <img
                                                src="images/paypal.png"
                                                alt="Paypal"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img
                                                src="images/mastercard.png"
                                                alt="Mastercard"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img
                                                src="images/maestro.png"
                                                alt="Maestro"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img
                                                src="images/stripe.png"
                                                alt="Stripe"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img
                                                src="images/bitcoin.png"
                                                alt="Bitcoin"> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-4 address color-gray">
                            <h5>Điện thoại: <a href="tel:+080000012222">080000012 222</a></h5>
                            </div>
                            <div
                                class="col-xs-12 col-sm-5 additional-info color-gray">
                                <h5>Thông tin bổ sung</h5>
                                 <p>Tham gia cùng hàng ngàn nhà hàng khác
                                     được hưởng lợi từ việc có thực đơn của họ trên TakeOff
                                 </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bottom footer ends -->
            </div>
        </footer>
        <!-- end:Footer -->
    </div>
    <!-- end:page wrapper -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>

</html>