<?php
/**
 * 网站主要信息区域
 * 全局方法，全局常量
 */
// 数据库信息填写
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
header("Content-Type:text/html;charset=utf-8");
define("sql_host", "127.0.0.1"); //数据库地址
define("sql_port", 3306); //数据库端口
define("sql_name", "ssh2_webadmin"); //数据库名
define("sql_usr", "root"); //数据库用户名
define("sql_pwd", "root"); //数据库密码
define("salt", "nacl");
//服务器信息
define('host', '');
define('port', 22);
define('usr', 'root');
define('pwd', '');
/**
 * 分别是五个等级的到期和启用命令
 */
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
/**
 * [sendCMDD description]
 * @param  [type] $level [description]
 * @param  [type] $ip    [description]
 * @return [type]        [description]
 * 根据等级执行命令
 */
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
/**
 * [str_check description]
 * @param  [type] $value [description]
 * @return [type]        [description]
 * 过滤危险字符串
 */
function str_check($value) {
    $value = addslashes($value);
    return $value;
}
?>
