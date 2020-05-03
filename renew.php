<?php
require 'info.php';
$usr = $_REQUEST['usr'];
$usr = str_check($usr); //过滤字符
$email = $_REQUEST['email'];
$emial = str_check($email);//过滤字符
$qq = $_REQUEST['qq'];
$qq = str_check($qq);//过滤字符
$key = $_REQUEST['key']; 
$key = str_check($key);//过滤字符
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
//用户数据库
$cmd = "SELECT * FROM my WHERE mm='$key'";
$result2 = mysqli_query($conn, $cmd);
$row2 = mysqli_fetch_array($result2);
//密钥数据库
if ($row != NULL && $row2 != NULL) {
    $date = $row2['dateD'];
    $date = date('Y-m-d', strtotime("+$date day", strtotime($row['dateD'])));
    //增加时间
    $level = $row2['groupD'];
    if ($level == $row['levelD']) {
        $cmd = "UPDATE user SET D = 0 WHERE usr = '$usr' ";
        mysqli_query($conn, $cmd);
        $cmd = "UPDATE user SET DateD = '$date' WHERE usr = '$usr' ";
        if (mysqli_query($conn, $cmd)) {
            echo "<script>alert(/Ok/)</script>";
        } else {
            die(mysqli_error($conn));
        }
        //执行命令
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
<div class="container-login100" style="background-image:url(images/bg-01.jpg)">
<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
<form class="login100-form validate-form" action="renew.php" method="post">
<span class="login100-form-title p-b-49">登录</span>
<div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
<span class="label-input100">用户名</span>
<input class="input100" type="text" name="usr" placeholder="请输入用户名" autocomplete="off">
<span class="focus-input100" data-symbol="&#xf206;"></span>
</div>
<div class="wrap-input100 validate-input" data-validate="请输入key">
<span class="label-input100">key</span>
<input class="input100" type="test" name="key" placeholder="请输入key">
<span class="focus-input100" data-symbol="&#xf190;"></span>
</div>
<div class="text-right p-t-8 p-b-31">
<a href="zc.php">注册</a>
</div>
<div class="container-login100-form-btn">
<div class="wrap-login100-form-btn">
<div class="login100-form-bgbtn"></div>
<button class="login100-form-btn">登 录</button>
</div>
</div>
</form>
</div>
</div>
</div>
<script src="vendor/jquery/jquery-3.2.1.min.js" type="53ddcdc0c8038f923e17a7fd-text/javascript"></script>
<script src="js/main.js" type="53ddcdc0c8038f923e17a7fd-text/javascript"></script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="53ddcdc0c8038f923e17a7fd-|49" defer=""></script></body>
</html>
