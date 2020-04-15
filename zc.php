<?php
require 'info.php';
$usr = $_REQUEST['usr'];
$pwd = $_REQUEST['pwd'];
$usr = str_check($usr);
$email = $_REQUEST['email'];
$qq = $_REQUEST['qq'];
$key = $_REQUEST['key'];
$conn = new mysqli(constant("sql_host"), constant("sql_usr"), constant("sql_pwd"), constant("sql_name"), constant("sql_port"));
if (!$conn->connect_error) {
    $sql_error = true;
} else {
    $sql_error = false;
    $conn->close();
    die("数据库连接失败");
}
$cmd = "SELECT * FROM user WHERE usr='$usr'";
$result = mysqli_query($conn, $cmd);
$row = mysqli_fetch_array($result);
$cmd = "SELECT * FROM my WHERE mm='$key'";
$result2 = mysqli_query($conn, $cmd);
$row2 = mysqli_fetch_array($result2);
if ($row == NULL && $row2 != NULL) {
    $pwd = md5(constant("salt") . $pwd);
    $date = $row2['dateD'];
    $date = date('y-m-d h:i:s', strtotime("+$date day"));
    $level = $row2['groupD'];
    $cmd = "INSERT INTO user (usr,pwd,ip,dateD,levelD,QQ,email,h,L) VALUES ('$usr','$pwd','','$date','$level','$qq','$email','-','')";
    if (mysqli_query($conn, "DELETE FROM my WHERE mm='$key'")) {
        if (mysqli_query($conn, $cmd)) {
            echo "<script>alert(/Ok/)</script>";
        } else {
            die(mysqli_error($conn));
        }
    }
}
?>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>NetWave</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" /> 

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" action="zc.php" method="post">
					<span class="login100-form-title p-b-49">注册</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
						<span class="label-input100">用户名</span>
						<input class="input100" type="text" name="usr" placeholder="请输入用户名" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入密码">
						<span class="label-input100">密码</span>
						<input class="input100" type="password" name="pwd" placeholder="请输入密码" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入邮箱">
						<span class="label-input100">邮箱</span>
						<input class="input100" type="text" name="email" placeholder="请输入邮箱" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="请输入联系QQ">
						<span class="label-input100">QQ</span>
						<input class="input100" type="test" name="qq" placeholder="请输入联系QQ">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="请输入注册码">
						<span class="label-input100">注册码</span>
						<input class="input100" type="test" name="key" placeholder="请输入注册码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					<div class="text-right p-t-8 p-b-31">
						<a href="index.html">登录</a>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">注 册</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>