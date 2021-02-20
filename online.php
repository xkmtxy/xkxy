<?php

header("Content-type:application/json;charset=utf-8");
include_once("conn.php");

$os_name = PHP_OS;
if (strpos($os_name, "Linux") !== false) {
    $flag = ":";
    $flag1 = "\\";
    $flag2 = 'export LANG="zh_CN.UTF-8" && ';
} else {
    if (strpos($os_name, "WIN") !== false) {
        $flag = ";";
        $flag1 = "^";
        $flag2 = '';
    }
}

if ($_POST['type'] == "playchange") {
    $sql = "select pof from admin limit 0,1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row['pof'] == 2) {
        $sql = "update admin set pof =1";
        $info = "已开启玩家后台功能";
    } else {
        $sql = "update admin set pof =2";
        $info = "已关闭玩家后台功能";
    }
    $res = mysqli_query($conn, $sql);
    $return = array(
        'errcode' => 0,
        'info' => $info,
    );
    exit(json_encode($return));
}
if ($_POST['type'] == "zzof") {
    $sql = "select zzof from admin limit 0,1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row['zzof'] == 2) {
        $sql = "update admin set zzof =1";
        $info = "已开启玩家自助转职功能";
    } else {
        $sql = "update admin set zzof =2";
        $info = "已关闭玩家自助转职功能";
    }
    $res = mysqli_query($conn, $sql);
    $return = array(
        'errcode' => 0,
        'info' => $info,
    );
    exit(json_encode($return));
}
if ($_POST['type'] == "qbof") {
    $sql = "select qbof from admin limit 0,1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row['qbof'] == 2) {
        $sql = "update admin set qbof =1";
        $info = "已开启玩家清包功能";
    } else {
        $sql = "update admin set qbof =2";
        $info = "已关闭玩家清包功能";
    }
    $res = mysqli_query($conn, $sql);
    $return = array(
        'errcode' => 0,
        'info' => $info,
    );
    exit(json_encode($return));
}
$uid = $_POST["uid"];
if ($uid == '') {
    $return = array(
        'errcode' => 1,
        'info' => '角色ID不能为空',
    );
    exit(json_encode($return));
}
$num = $_POST["num"];
if (empty($num)) {
    $num = 10;
}
if ($_POST['type']) {
    $type = trim($_POST['type']);
    $port = $_POST['qu'];
    switch ($type) {
        case 'setgrow':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "setpetgrow ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '修改成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'setgj':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "setpetattack ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '修改成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'setfy':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "setpetdefend ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '修改成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'setfs':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "setpetmagic ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '修改成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'settl':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "setpetphyforce ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '修改成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'setsd':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "setpetspeed ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '修改成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'rolenum':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "rolenum"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '在线人数:' . $out[0],
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'gmcmd':
            $gmcmd = str_replace(" ", "#", $_POST['gmcmd']);
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "'. $gmcmd .'"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '执行成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'updateshield':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "updateshield"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '更新成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'updatenotclear':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "updatenotclear"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '更新成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'makeequip':
            $equipid = $_POST['equipid'];
            $skillid = $_POST['skillid'];
            $effectid = $_POST['effectid'];
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addsequip#'. $equipid . "#" . $effectid . "#" . $skillid.'"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => $cmd,
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'kickout':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "kick ' . $uid . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '角色已被强制下线',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'hideme':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '"  "hideme"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '隐身成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'showme':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '"  "showme"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '取消隐身成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'addbx':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=4097"  "addbx 4097"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '增加随机宝箱成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'stoprole':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=12289" "createrole 0"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '禁止服务器创建角色',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'startrole':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=12289" "createrole 1"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '开启服务器创建角色',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'addpet':
            $petid = intval($_POST['petid']);
            $petlevel = intval($_POST['petlevel']);
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '"  "addpet ' . $petid . ' ' . $petlevel . ' ' . $uid . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '发送宠物成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'bindtel':
            $tel = intval($_POST['tel']);
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '"  "changebindtel ' . $uid . ' ' . $tel . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '绑定手机成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'addvip1':
            $vipfile = 'sysvip.json';
            $fp = fopen($vipfile, "a+");
            if (filesize($vipfile) > 0) {
                $str = fread($fp, filesize($vipfile));
                fclose($fp);
                $vipjson = json_decode($str);
                if ($vipjson == null) {
                    $vipjson = array();
                }
            } else {
                $vipjson = array();
            }
            if (!in_array($uid, $vipjson)) {
                array_push($vipjson, $uid);
                file_put_contents($vipfile, json_encode($vipjson));
                $info = '授权成功!!';
            } else {
                $info = '该ID已经授权';
            }
            $return = array(
                'errcode' => 0,
                'info' => $info,
            );
            exit(json_encode($return));
            break;
        case 'addvip':
            $sql = "select * from player where rid = '$uid'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            if (!empty($row['id'])) {
                $state = $row['state'];
                if ($state == 1) {
                    $sql = "update player set state=2 where rid = '$uid'";
                    $res = mysqli_query($conn, $sql);
                    if ($res) {

                        $d = $time . " 给角色id：" . $uid . "授权成功";
                        $str = $str . "\r\n" . $d;
                        file_put_contents($log, $str);

                        $errcode = 0;
                        $info = "授权成功";
                    } else {
                        $errcode = 1;
                        $info = "授权失败";
                    }
                }
                if ($state == 2) {
                    $errcode = 1;
                    $info = "已经授过权了";
                }
            } else {
                $errcode = 1;
                $info = "玩家还没有注册";
            }
            $return = array(
                'errcode' => $errcode,
                'info' => $info,
            );
            exit(json_encode($return));
            break;
        case 'delvip':
            $sql = "select * from player where rid = '$uid'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            if (!empty($row['id'])) {
                $state = $row['state'];
                $sql = "update player set state=1 where rid = '$uid'";
                $res = mysqli_query($conn, $sql);
                if ($res) {

                    $d = $time . " 取消角色id：" . $uid . "授权成功";
                    $str = $str . "\r\n" . $d;
                    file_put_contents($log, $str);
                    $errcode = 0;
                    $info = "取消授权成功";
                } else {
                    $errcode = 1;
                    $info = "取消授权失败";
                }
            } else {
                $errcode = 1;
                $info = "玩家还没有注册";
            }
            $return = array(
                'errcode' => $errcode,
                'info' => $info,
            );
            exit(json_encode($return));
            break;
        case 'addgold':
            $gold = $_POST['gold'];
            $sql = "select id from player where rid = '$uid'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            if (empty($row['id'])) {
                $errcode = 1;
                $info = "玩家还未注册后台";
            } else {
                $sql = "update player set gold = gold + $gold where rid = '$uid'";
                $res = mysqli_query($conn, $sql);
                if ($res) {
                    $errcode = 0;
                    $info = "增加成功";

                    $d = $time . " 给角色id：" . $uid . "增加" . $gold . "金币";
                    $str = $str . "\r\n" . $d;
                    file_put_contents($log, $str);
                } else {
                    $errcode = 1;
                    $info = "增加失败";
                }
            }
            $return = array(
                'errcode' => $errcode,
                'info' => $info,
            );
            exit(json_encode($return));
            break;
        case 'zzd':
            $juese = $_POST['juese'];
            $zhiye = $_POST['zhiye'];
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "changeschool ' . $juese . ' ' . $zhiye . ' ' . $uid . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '转职成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'addlevel':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addlevel#' . $num . ' "';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '增加等级成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'baitan':  //一键清除摆摊公示
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "baitantimeclear"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '清楚公示成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'checkcode':  //一键开启手机验证码
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "checkcode  1"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '开启成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'jump':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "coquest"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '跳过成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'charge':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addqian#3 ' . $num . '"';
            exec($cmd, $out);
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addvipexp#' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '充值成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'jinbi':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addgold#' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '充值金币成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'banggong':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addbanggong#' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '增加帮贡成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'addrwskill':
            $skill = $_POST["skill"];
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "learngskill ' . $skill . ' ' . $num . '"';
            //addpetskill $skillId$ $exp$ $skillType(0/1)$	skillId	exp	skillType
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '增加人物技能成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'petjn':
            $skill = $_POST["skill"];
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "addpetskill ' . $skill . ' 1 1 "';
            //addpetskill $skillId$ $exp$ $skillType(0/1)$	skillId	exp	skillType
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '增加宠物技能成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'delpetjn':
            $skill = $_POST["skill"];
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "delpetskill ' . $skill . '  ' . $num . ' 1 "';
            //addpetskill $skillId$ $exp$ $skillType(0/1)$	skillId	exp	skillType
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '删除宠物技能成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'item':
            $itemid = $_POST["itemid"];
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "additem ' . $itemid . ' ' . $num . '" ';
            //$cmd=$flag2.'java -jar jmxc.jar "" "" "127.0.0.1" "'.$port.'" "gm" "userId=4096" "roleId='.$uid.'" "mail {$uid} GM GM 10000 {$itemid}|{$num}" ';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '发送成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'allmail':
            $itemid = $_POST["itemid"];
            $times = $_POST["times"];
            $mailct = $_POST["mailct"];
            $levelmin = $_POST["levelmin"];
            $levelmax = $_POST["levelmax"];
            $cmd = $flag2 . "java -classpath ." . $flag . "gsxdb.jar Clients " . $port . " " . $uid . " mailbycond#GM#" . $mailct . "#" . $times . "#" . $itemid . $flag1 . "|" . $num . "#1" . $flag1 . "|" . $levelmin . $flag1 . "|" . $levelmax;
            //$cmd=$flag2.'java -cp jmxc.jar "" "" "127.0.0.1" "'.$port.'" "gm" "userId=4096" "roleId='.$uid.'" "mailbycond GM 全服邮件 0 '.$itemid.'|'.$num.' 1|10|100" ';
            ////mailbycond 邮件标题 邮件内容 有效时间默认填0 奖励多个用逗号1|100,2|100 领取邮件的条件1|10|100
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '全服发送成功',
            );
            exit(json_encode($return));
            break;
        case 'clearbag':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "clearbag"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '清包成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'gf':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "dismissguild"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => 'OK!!!',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'allgg':
            $notice = $_POST["gg"];
            $locale = 'en_US.UTF-8';
            setlocale(LC_ALL, $locale);
            putenv('LC_ALL=' . $locale);
            $cmd = $flag2 . "java -classpath ." . $flag . "gsxdb.jar Clients " . $port . " " . $uid . " zmd#" . $notice;
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '发送公告成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'alltc':
            $notice = $_POST["gg"];
            $locale = 'en_US.UTF-8';
            setlocale(LC_ALL, $locale);
            putenv('LC_ALL=' . $locale);
            $cmd = $flag2 . "java -classpath ." . $flag . "gsxdb.jar Clients " . $port . " " . $uid . " tc#" . $notice;
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '发送弹窗成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'startgg':
            $notice = $_POST["gg"];
            $jiange = $_POST["jiange"];
            $locale = 'en_US.UTF-8';
            setlocale(LC_ALL, $locale);
            putenv('LC_ALL=' . $locale);
            $cmd = $flag2 . "java -classpath ." . $flag . "gsxdb.jar Clients " . $port . " " . $uid . " ggg#start#" . $jiange . "#" . $notice;
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '开启循环公告成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'stopgg':
            $locale = 'en_US.UTF-8';
            setlocale(LC_ALL, $locale);
            putenv('LC_ALL=' . $locale);
            $cmd = $flag2 . "java -classpath ." . $flag . "gsxdb.jar Clients " . $port . " " . $uid . " ggg#stop";
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '关闭循环公告成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'fh':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=9845" "roleId=' . $uid . '" "forbid#' . $uid . '#999999#1"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '封号成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            // java -jar jmxc.jar "" "" "127.0.0.1" "'.$port.'" "gm" "userId=4096" "roleId=8193" "forbid  569345 1767024000  GM"
            break;
        case 'jf':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "unforbid ' . $uid . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '解封成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'sq':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "shenqi ' . $uid . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '发送成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'subfs':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "subfushi ' . $uid . ' ' . $num . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '减仙玉成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'jy':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "nonvoice ' . $uid . ' 64000000 GM 0"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '禁言成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        case 'jcjy':
            $cmd = $flag2 . 'java -jar jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "unnonvoice ' . $uid . '"';
            exec($cmd, $out);
            $return = array(
                'errcode' => 0,
                'info' => '取消禁言成功',
				'cmd' => $cmd,
            );
            exit(json_encode($return));
            break;
        default:
            $return = array(
                'errcode' => 1,
                'info' => 'type error',
            );
            exit(json_encode($return));
            break;
    }
}
exit("ok");
?>
