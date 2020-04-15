<?php
// 数据库信息填写
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
header("Content-Type:text/html;charset=utf-8");
define("sql_host", "127.0.0.1"); //数据库地址
define("sql_port", 3306); //数据库端口
define("sql_name", "NetWave"); //数据库名
define("sql_usr", "L3yit4Mn"); //数据库用户名
define("sql_pwd", "hSS0XkaS"); //数据库密码
define("salt", "nacl");
//服务器信息
define('host', '113.31.107.130');
define('port', 22);
define('usr', 'root');
define('pwd', '(3*He[4#%Tgq');
define('cmd1', 'iptables -A INPUT -s [ip] -m limit --limit 168/sec -p tcp --dport 39253 -j ACCEPT && service iptables save');
define('cmd2', 'iptables -A INPUT -s [ip] -p tcp --dport 39253 -j ACCEPT && service iptables save');
define('cmd3', 'iptables -A INPUT -s [ip] -p tcp --dport 39254 -j ACCEPT && service iptables save');
define('cmd4', 'iptables -A INPUT -s [ip] -m limit --limit 160/sec -p tcp --dport 39253 -j ACCEPT && iptables -A INPUT -s [ip] -m limit --limit 160/sec -p tcp --dport 39254 -j ACCEPT && service iptables save');
define('cmd5', 'iptables -A INPUT -s [ip] -p tcp --dport 39253 -j ACCEPT && iptables -A INPUT -s [ip] -p tcp --dport 39254 -j ACCEPT && service iptables save');
define('cmdd1', 'iptables -D INPUT -s [ip] -m limit --limit 168/sec -p tcp --dport 39253 -j ACCEPT && service iptables save');
define('cmdd2', 'iptables -D INPUT -s [ip] -p tcp --dport 39253 -j ACCEPT && service iptables save');
define('cmdd3', 'iptables -D INPUT -s [ip] -p tcp --dport 39254 -j ACCEPT && service iptables save');
define('cmdd4', 'iptables -D INPUT -s [ip] -m limit --limit 160/sec -p tcp --dport 39253 -j ACCEPT && iptables -D INPUT -s [ip] -m limit --limit 160/sec -p tcp --dport 39254 -j ACCEPT && service iptables save');
define('cmdd5', 'iptables -D INPUT -s [ip] -p tcp --dport 39253 -j ACCEPT && iptables -D INPUT -s [ip] -p tcp --dport 39254 -j ACCEPT && service iptables save');
function sendCMD($level, $ip) {
    //echo str_replace('[ip]', $ip,constant("cmd".$level));
    if (!function_exists("ssh2_connect")) die("Error: SSH2 does not exist on you're server");
    if (!($con = ssh2_connect(constant('host'), constant('port')))) {
        echo "Error: Connection Issue";
    } else {
        if (!ssh2_auth_password($con, constant('usr'), constant('pwd'))) {
            echo "Error: Login failed, one or more of you're server credentials are incorrect.";
        } else {
            if (!($stream = ssh2_exec($con, str_replace('[ip]', $ip, constant("cmd" . $level))))) {
                echo "Error: You're server was not able to execute you're methods file and or its dependencies";
            } else {
                stream_set_blocking($stream, false);
                $data = "";
                while ($buf = fread($stream, 4096)) {
                    $data.= $buf;
                }
                fclose($stream);
            }
        }
    }
}
function sendCMDD($level, $ip) {
    //echo str_replace('[ip]', $ip,constant("cmd".$level));
    if (!function_exists("ssh2_connect")) die("Error: SSH2 does not exist on you're server");
    if (!($con = ssh2_connect(constant('host'), constant('port')))) {
        echo "Error: Connection Issue";
    } else {
        if (!ssh2_auth_password($con, constant('usr'), constant('pwd'))) {
            echo "Error: Login failed, one or more of you're server credentials are incorrect.";
        } else {
            if (!($stream = ssh2_exec($con, str_replace('[ip]', $ip, constant("cmdd" . $level))))) {
                echo "Error: You're server was not able to execute you're methods file and or its dependencies";
            } else {
                stream_set_blocking($stream, false);
                $data = "";
                while ($buf = fread($stream, 4096)) {
                    $data.= $buf;
                }
                fclose($stream);
            }
        }
    }
}
function str_check($value) {
    if (!get_magic_quotes_gpc()) {
        // 进行过滤
        $value = addslashes($value);
    }
    $value = str_replace("_", "\_", $value);
    $value = str_replace("%", "\%", $value);
    return $value;
}
?>