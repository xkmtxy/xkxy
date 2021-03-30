<?php
include "../includes/common.php";
if ($_POST) {
    if ($_POST ['type']) {
        $type = trim($_POST ['type']);
        switch ($type) {
            case 'qingli':
                $flag = ":";
                $uid = $_POST['uid'];
                $cmd = "java -classpath ." . $flag . "gsxdb.jar Client " . $servers['port'] . " " . $userinfo['UserID'] . " clearbag";
                exec($cmd, $out);
                $retnn = exec($cmd);
                if ($retnn) {
                    echo "清理成功";
                    exit;
                } else {
                    echo "清理失败";
                    exit;
                }
                break;
            case 'yanzheng':
                $flag = ":";
                $uid = $_POST['uid'];
                $cmd = "java -classpath ." . $flag . "gsxdb.jar Client " . $servers['port'] . " " . $userinfo['UserID'] . " addbindtel#" . $userinfo['UserID'] . "#13666666666#2";
                $retnn = exec($cmd);
                if ($retnn) {
                    echo "关联成功";
                    exit;
                } else {
                    echo "关联失败";
                    exit;
                }
                break;

            case 'qiandao':
                if ($myserver['allch'] < $config['trade_money']) {
                    exit('暂无权限,需累计充值达到'.$config['trade_money'].'元才能使用此功能！');
                }
                $rand = rand(1, 3);
                $time = time();
                $today = strtotime(date("Y-m-d"), time());
                $today1 = $today + 86400;
                $uid = $_POST['uid'];
                $goodinfo = $DB->get_row("select * from cly_users where user='" . $uid . "'");

                if ($today1 > $goodinfo['time']) {
                    $DB->query("update `cly_users` set money=money+'{$rand}' where user='{$uid}'");
                    $DB->query("update `cly_users` set time='{$today1}' where user='{$uid}'");
                    echo "领取" . $rand . "平台币成功";
                } else {
                    echo "一天只能领取一次哟";
                    exit;
                }
                break;
            case 'sign':
                $time = date("Y-m-d H:i:s");
                if ($isvip) {
                    $res = $DB->get_row("SELECT * FROM `cly_sign_logs` where `uid`={$uid} and DATE_FORMAT(`createtime`,'%d') = DATE_FORMAT(CURDATE(),'%d') limit 1");
                    if (empty($res)) {
                        $DB->get_row("insert into `cly_sign_logs` ( `uid`,`user`,`createtime`) values ('{$userinfo['uid']}','{$userinfo['user']}', '{$time}')");
                        $arr = explode(",", $config['vipsign']);
                        $vipsign = array();
                        foreach ($arr as $data) {
                            $data = trim($data);
                            $tmp = explode("#", $data);
                            $vipsign[$tmp[0]] = [$tmp[1], $tmp[2]];
                        }
                        $day = (int)date("d");
                        for ($i = 0; $i < $vipsign[$day][1]; $i++) {
                            $cmd = 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $servers['port'] . '" "gm" "userId=28673" "roleId=' . $userinfo['UserID'] . '" "additem ' . $vipsign[$day][0] . ' 1" ';
                            exec($cmd, $out);
                        }
                        echo $cmd;
                    } else {
                        echo "一天只能签到一次哟";
                    }
                } else {
                    echo "您不是会员，暂无权限访问！成为会员后每天可以领取游戏等丰厚道具奖励！";
                }
                break;
            case 'zhuanzhi':
                $uid = $_POST['uid'];
                $juese = $_POST['juese'];
                $zhiye = $_POST['zhiye'];
                if ($userinfo['money'] < $config['zhuanzhi']) {
                    exit("您的平台币不足");
                }

                $cmd = 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $servers['port'] . '" "gm" "userId=20481" "roleId=' . $userinfo['UserID'] . '" "changeschool ' . $juese . ' ' . $zhiye . ' ' . $uid . '"';
                exec($cmd, $out);
                echo "转职成功";
                break;
            case 'zengjia':
                $uid = $_POST['uid'];
                $lili = $_POST['key'];
                $lili = intval($lili);
                $lili = $lili > 0 ? $lili : 0;
                $lilil = $config['pingtaibi'] * $lili;
                if ($userinfo['money'] < $lilil) {
                    echo "您的平台币不足兑换";
                    return 0;
                }
                if ($cishu = $DB->query("update `cly_users` set money=money-'{$lilil}' where user='{$uid}'")) {
                    logs($userinfo['uid'], '兑换抽奖次数余额减少：' . $lilil . '元');
                    $cishu1 = $DB->query("update `cly_users` set money1=money1+'{$lili}' where user='{$uid}'");
                    logs($userinfo['uid'], '抽奖次数增加：' . $lili . '次');
                    echo "增加" . $lili . "次抽奖次数成功！";
                }
                break;

            case 'danci':
                $uid = $userinfo['user'];
                if ($userinfo['money1'] == 0 || $userinfo['money1'] < 1) {
                    echo "您的抽奖次数不足";
                    return 0;
                }
                if ($cishu = $DB->query("update `cly_users` set money1=money1-1 where user='{$uid}'")) {
                    logs($uid, "抽奖次数减少1次");
                    $date = date("Y-m-d H:i:s");
                    $mynum = rand(0, $num - 1);
                    $date = date("Y-m-d H:i:s");
                    $goodinfo = $DB->get_row("select * from cly_shop where id='" . $res[$mynum] . "' limit 1");
                    $cmd = 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $servers['port'] . '" "gm" "userId=28673" "roleId=' . $userinfo['UserID'] . '" "additem ' . $goodinfo['itemid'] . ' 1" ';
                    $user = $userinfo['user'];
                    $itemid = $goodinfo['name'];
                    $ggg = $DB->get_row("insert into `pay_settle` ( `pid`,`time`,`statuss`,`username`) values ('$user', '$date', '1', '$itemid')");
                    echo "恭喜抽到" . $goodinfo['name'] . "！";
                    exec($cmd, $out);
                }
                break;

            case 'shilian':
                $uid = $userinfo['user'];
                if ($userinfo['money1'] == 0 || $userinfo['money1'] < 10) {
                    echo "您的抽奖次数不足，请去兑换";
                    return 0;
                }
                if ($cishu = $DB->query("update `cly_users` set money1=money1-10 where user='{$uid}'")) {
                    logs($uid, "抽奖次数减少10次");
                    for ($i = 0; $i < 10; $i++) {
                        $mynum = rand(0, $num - 1);
                        $date = date("Y-m-d H:i:s");
                        $goodinfo = $DB->get_row("select * from cly_shop where id='" . $res[$mynum] . "' limit 1");
                        $cmd = 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $servers['port'] . '" "gm" "userId=28673" "roleId=' . $userinfo['UserID'] . '" "additem ' . $goodinfo['itemid'] . ' 1" ';
                        $user = $userinfo['user'];
                        $itemid = $goodinfo['name'];
                        $ggg = $DB->get_row("insert into `pay_settle` ( `pid`,`time`,`statuss`,`username`) values ('$user', '$date', '1', '$itemid')");
                        echo "恭喜抽到" . $goodinfo['name'] . "！";
                        exec($cmd, $out);
                    }
                }
                break;
/* 	case "sendfanli"://仓库
        $id = GetPost('id');
        $serverid = GetPost('ServerID');
        $str = 'UserID';
        $sql = "update cangku set draw = 1 where id = ".$id;
        if($DB->query($sql)===false) {
            $cmd='java -jar jmxc.jar "" "" "127.0.0.1" "'.$servers['port'].'" "gm" "userId=28673" "roleId='.$userinfo[$str].'" "additem '.$goodinfo['itemid'].' '.$num.'" ';
            json(['code' => 0, 'msg' => '操作失败']);
        }
        $cmd='java -jar jmxc.jar "" "" "127.0.0.1" "'.$servers['port'].'" "gm" "userId=28673" "roleId='.$userinfo[$str].'" "addpet#'.$goodinfo['itemid'].'  '.$num.'" ';
        json(['code' => 1, 'msg' => '操作成功']);
        break;
	default:
		json(['code' => 0, 'msg' => '操作不存在']);
		break; */
            case 'fanli':
                {
                    $date = date("Y-m-d H:i:s");
                    $dc = explode(',', $config['fanli']);
                    $wp = explode(',', $config['song']);
                    $sl = explode(',', $config['sl']);
                    $fl = array();
                    $myserver = $DB->get_row("select * from cly_user_servers where ServerID='{$userinfo['ServerID']}' and uid='{$userinfo['uid']}'");
                    foreach ($dc as $key => $row) {
                        array_push($fl, 2);
                        if ($myserver['allch'] >= $row) {
                            $fl[$key] = 0;
                        }
                    }
                    for ($i = 0; $i < $myserver['fl']; $i++) {
                        $fl[$i] = 1;
                    }
                    foreach ($fl as $key => $row) {
                        if ($row == 0) {
                            for ($i = 0; $i < $sl[$key]; $i++) {
                                $cmd = 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $servers['port'] . '" "gm" "userId=28673" "roleId=' . $userinfo['UserID'] . '" "additem ' . $wp[$key] . ' 1" ';
                                exec($cmd, $out);
                                usleep(1000000);
                            }
                            $user = $userinfo['user'];
                            $itemid = $goodinfo['name'];
                            $uname = $wp[$key] . '*' . $sl[$key];
                            $ggg = $DB->get_row("insert into `pay_settle` ( `pid`,`time`,`statuss`,`username`) values ('$user', '$date', '1', '$uname')");
                            $DB->get_row("UPDATE `cly_user_servers` SET `fl`=`fl`+ 1 WHERE ServerID='{$userinfo['ServerID']}' and uid='{$userinfo['uid']}'");
                            echo "发放成功！";
                            usleep(500000);
                        }
                    }
                }
                break;
            case 'jiangli':
                $uid = $userinfo['user'];
                $song = $config['allchsong'];
                if ($userinfo['fanli'] > 0) {
                    echo "已经领取过了，请不要重复领取！只能领取一次";
                }else if($userinfo['allch']<$config['allch']){
                    echo "未达到系统条件，账号充值需要大于".$config['allch'].'元';
                }
                else {
                    $DB->query("update `cly_users` set money=money+{$song} where user='{$uid}'");
                    $DB->query("update `cly_users` set fanli=fanli+1 where user='{$uid}'");
                    echo "领取成功";
                }
                break;
        }
    }
}
