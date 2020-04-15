<?php
require 'info.php';
$usr = $_REQUEST['usr'];
//$usr = mysql_real_escape_string($usr);
$pwd = $_REQUEST['pwd'];
$ypwd = $pwd;
$conn = new mysqli(constant("sql_host"), constant("sql_usr"), constant("sql_pwd"), constant("sql_name"), constant("sql_port"));
// var_dump($conn);
if (!$conn->connect_error) {
    $sql_error = true;
} else {
    $sql_error = false;
    $conn->close();
    die("数据库连接失败");
}
//$usr = mysql_real_escape_string($usr);
$ip = NULL;
//执行数据库命令
//UPDATE user SET D = 1
$cmd = "UPDATE user SET D = 1 WHERE `dateD` < now() AND D=0";
mysqli_query($conn, $cmd);
$cmd1 = "SELECT * FROM user WHERE D=1";
$result = mysqli_query($conn, $cmd1);
while ($row2 = mysqli_fetch_array($result)) {
    //var_dump($row2);
    echo $row2['levelD'] . $row2['ip'];
    sendCMDD($row2['levelD'], getIP());
    sendCMDD($row2['levelD'], $row2['ip']);
    $usr = $row2['usr'];
    $cmd23 = "UPDATE user SET D = 2 WHERE usr = '$usr' ";
    mysqli_query($conn, $cmd23);
}
$cmd = "SELECT * FROM user WHERE usr='$usr'";
$result = mysqli_query($conn, $cmd);
if (!$result) {
    die(mysqli_error($conn));
}
$row = mysqli_fetch_array($result);
//var_dump($row);
if ($row != NULL) {
    $pwd = md5(constant("salt") . $pwd);
    if ($pwd == $row['pwd']) {
        //var_dump($row);
        $ip = $row['ip'];
        //echo "$ip";
        $group = $row['levelD'];
        $date = $row['dateD'];
        $qq = $row['QQ'];
        $h = $row['h'];
        $L = $row['L'];
        $D = $row['D'];
        //$zero1=date("y-m-d h:i:s");
        //$zero2=$row['dateD'];
        if ($D == 1 || $D == 2) {
            //sendCMDD($group,$ip);
            //mysqli_query($conn,"UPDATE user SET D = 1 WHERE usr = '$usr' ");
            die("你的使用已到期 或 您的账户疑似共享已被管理员封禁。请查看邮箱");
        }
        $rip = getIP();
        if (isset($_REQUEST['rip'])) {
            $zero1 = date("y-m-d h:i:s");
            $zero2 = $row['L'];
            //echo strtotime($zero1);
            //echo strtotime("+600 seconds",$zero2);
            if (strtotime($zero1) < strtotime("+600 seconds", strtotime($zero2))) {
                die("宝贝，你再等等，我们得冷却十分钟才能改一次哦~");
            } else {
                $cmd = "UPDATE user SET L = '$zero1' WHERE usr = '$usr' ";
                mysqli_query($conn, $cmd);
            }
            if ($zero2 == "") {
                $cmd = "UPDATE user SET L = '$zero1' WHERE usr = '$usr' ";
                mysqli_query($conn, $cmd);
            }
            $rip = $_REQUEST['rip'];
            $cmd = "UPDATE user SET ip = '$rip' WHERE usr = '$usr' ";
            if (mysqli_query($conn, $cmd)) {
                $text = $h . "-" . $rip;
                sendCMDD($group, $ip);
                sendCMD($group, $rip);
                $a = 0;
                foreach (explode("-", $h) as $var) {
                    //echo "$var";
                    if ($var == $rip) {
                        $a = 1;
                    }
                }
                //$cmd="UPDATE user SET h = '$text' WHERE usr = '$usr' ";
                //mysqli_query($conn, $cmd);
                //print_r(explode("-",$h));
                if ($a == 0 || $ip == "" || $h == "") {
                    $cmd = "UPDATE user SET h = '$text' WHERE usr = '$usr' ";
                    mysqli_query($conn, $cmd);
                }
            } else {
                die("账号或密码错误");
            }
        }
    } else {
        die("登录失败");
    }
} else {
    die(mysqli_error($conn));
}
function getIP() {
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if (@$_SERVER["HTTP_CLIENT_IP"]) $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if (@$_SERVER["REMOTE_ADDR"]) $ip = $_SERVER["REMOTE_ADDR"];
    else if (@getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (@getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
    else if (@getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknown";
    return $ip;
}
function check_param($value = null) {
    #  select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile
    $str = 'select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile';
    if (!$value) {
        exit('没有参数！');
    } elseif (eregi($str, $value)) {
        exit('参数非法！');
    }
    return true;
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
				<form class="login100-form validate-form" action="user.php" method="post">
					<span class="login100-form-title p-b-49">Welcome</span>
					<div class="wrap-input100 validate-input m-b-23" data-validate="<strong>目前ip</strong>">
						<span class="label-input100">您目前的IP : <?php echo getIP(); ?></span>
						<input class="input100" type="text"style="visibility: hidden;" name="usr" value="<?php echo $usr ?>" placeholder="请输入用户名" autocomplete="off">
						</div>
					<div class="wrap-input100 validate-input m-b-23" data-validate="<strong>用户组</strong>">
						<span class="label-input100">您的用户组 : <?php echo "$group"; ?></span>
						<br><br><br>
						</div>
					<div class="wrap-input100 validate-input m-b-23" data-validate="<strong>绑定的IP</strong>">
						<span class="label-input100">您绑定的IP : <?php echo $ip; ?></span>
						<input class="input100" type="text"style="visibility: hidden;" name="pwd" value="<?php echo $ypwd ?>" placeholder="请输入用户名" autocomplete="off">
						</div>
					<div class="wrap-input100 validate-input m-b-23" data-validate="<strong>过期时间</strong>">
						<span class="label-input100">过期时间 : <?php echo $date; ?></span>
						<input class="input100" type="text" style="visibility: hidden;"  name="rip" value="<?php echo getIP() ?>" placeholder="请输入用户名" autocomplete="off">
						</div>
                    <h6>加速IP： </h6>
						<h6>Hypixel：2og5mhapkw9mrwc.litefish.top:39253</h6>
						<h6> Syuu：2og5mhapkw9mrwc.litefish.top:39254</h6>
						<p>&nbsp;</p>
					<div class="text-right p-t-8 p-b-31">


					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">修改</button>
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