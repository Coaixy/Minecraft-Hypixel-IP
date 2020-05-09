<?php
/**
 * 密钥生成器  格式 keys.php?key=【密码】&num=【数量】&level=【级别】&time=【时长】
**/
require 'info.php';
$key = $_REQUEST['key'];
$num = $_REQUEST['num'];
$level = $_REQUEST['level'];
$time = $_REQUEST['time'];
if ($key != "NetWave.lmfuture.czy") {
    die();
}
$conn = new mysqli(constant("sql_host"), constant("sql_usr"), constant("sql_pwd"), constant("sql_name"), constant("sql_port"));
if (!$conn->connect_error) {
    $sql_error = true;
} else {
    $sql_error = false;
    $conn->close();
    die("数据库连接失败");
}
$time = time();
//利用时间戳进行卡密生成
for ($i = 0;$i < $num;$i++) {
    $my = md5($time . $i);
    $cmd = "INSERT INTO my (mm,dateD,groupD) VALUES ('$my','$time','$level')";
    var_dump(mysqli_query($conn, $cmd));
    echo "$my";
    //输出卡密
}
?>
