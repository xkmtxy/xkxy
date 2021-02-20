<?php
include "../common.php";

$gmcode = trim($_POST['checknum']);
error_reporting(0);
if ($gmcode == '') {
    $return = array(
        'errcode' => 1,
        'info' => 'GM码不能为空',
    );
    exit(json_encode($return));
}

if ($gmcode != '108b085a47dac7b39560d4bdba6ce2cf') {
    $return = array(
        'errcode' => 1,
        'info' => 'GM码错误',
    );
    exit(json_encode($return));
}

if ($_POST) {
    if ($_GET['act']) {
        $type = trim($_GET['act']);
        switch ($type) {
            case 'mod':
                $user = $_POST['user'];
                $money = $_POST['money'];
                $type = $_POST['type'];
                $serverid = $_POST['ServerID'];
                $userinfo = $DB->get_row("SELECT * FROM cly_users WHERE user='" . $user . "' limit 1");
                if (empty($userinfo)) {
                    exit("会员不存在");
                }
                if ($user && $type) {
                    $str = "";
                    if ($type == 'money') {
                        money($userinfo['uid'],$money,true);
                        $str .= "平台币增加成功！";
                    }
                    if ($type == 'money1') {
                        $DB->query("UPDATE cly_users SET money1=money1+'" . $money . "' WHERE user='" . $user . "'");
                        $str .= "抽奖次数增加成功！";
                    }
                    if ($type == 'allch' && $serverid) {
                        $DB->get_row("UPDATE `cly_user_servers` SET `allch`=`allch`+'{$money}' WHERE ServerID='{$serverid}' and uid='{$userinfo['uid']}'");
                        $str .= "账号分区累计充值增加成功！";
                    }
                    if ($type == 'allch1') {
                        $DB->get_row("UPDATE `cly_users` SET `allch`=`allch`+'{$money}' WHERE uid='{$userinfo['uid']}'");
                        $str .= "账号累计充值增加成功！";
                    }
                    if ($type == 'viptime') {
                        $nowtime = $userinfo['viptime'];
                        $nowtime = strtotime($nowtime) < strtotime(date("Y-m-d H:i:s")) ? strtotime(date("Y-m-d H:i:s")) : strtotime($nowtime);
                        $endtime = strtotime('+' . $money . ' day', $nowtime);
                        $endtime = date('Y-m-d H:i:s', $endtime);
                        $DB->get_row("UPDATE cly_users SET viptime='{$endtime}' WHERE user='" . $user . "'");
                        $str .= "会员时间增加成功！";
                    }
                    exit($str);
                } else {
                    exit("参数不完整，请重新提交");
                }

                break;
            default:
                exit("无此操作！");
        }
    }
}
?>
