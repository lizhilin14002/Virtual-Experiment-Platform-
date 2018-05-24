<?php
include_once 'config.php';

//https://mp.weixin.qq.com/wiki/10/2adfb2f10828e87aa1e5c3ef83b17906.html

$sql = "INSERT INTO `user` (`addtime`) VALUES ('" . time() . "')";
mysql_query($sql);

$scene_id = mysql_insert_id();

$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
$access_token_array = json_decode(curlGet($url), true);
$access_token = $access_token_array['access_token'];
//echo $access_token;exit;http://www.sucaihuo.com/project/wxvalid/index.php 
$qrcode_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;

$post_data = array();
$post_data['expire_seconds'] = 3600 * 24; //有效时间
$post_data['action_name'] = 'QR_SCENE';
$post_data['action_info']['scene']['scene_id'] = $scene_id; //传参二维码主键id，微信端可获取
$json = curlPost($qrcode_url, json_encode($post_data));
if (!$json['errcode']) {

    $ticket = $json['ticket'];
    $ticket_img = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
} else {
    echo '发生错误：错误代码 ' . $json['errcode'] . '，微信返回错误信息：' . $json['errmsg'];
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <title>微信扫码登录</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    </head>
    <body style="background-color: rgb(51, 51, 51);" align="center">
        <h3 style="text-align: center;color:#ffffff;font-size: 20px;margin-bottom:20px;margin-top:58px;">微信登录</h3>
        <p style="text-align:center;"><img src="<?php echo $ticket_img; ?>" style="width:282px;height:282px;"></p>
        <p id="login_status" style="margin-top:20px;display:none;text-align:center;font-size:14px;"></p>	
        <div style="width:100%;" align="center">
          <div style="color:#ffffff;fontg-size:13px;font-weight:400;font-family: 'Microsoft Yahei';width:254px;background-color: #232323;border-radius: 100px;-moz-border-radius: 100px;-webkit-border-radius: 100px;box-shadow: inset 0 5px 10px -5px #191919,0 1px 0 0 #444;-moz-box-shadow: inset 0 5px 10px -5px #191919,0 1px 0 0 #444; -webkit-box-shadow: inset 0 5px 10px -5px #191919,0 1px 0 0 #444;padding: 7px 14px;">
        		请使用微信扫描二维码<br/>登录NEWMOOC
          </div>
        </div>
        <script type="text/javascript" src="jquery.min.js"></script>
        <script>
            check_login();
            function check_login() {
                $.post("check_login.php", {scene_id: <?php echo $scene_id; ?>}, function(data) {
                    if (data.openid != null) {
                        alert("扫码成功，您好，" + data.nickname);
                        location.href='http://newmooc.tianyongxin.cn/home/form/wxlogin?user='+data.username;
                    } else {
                        setTimeout("check_login()", 4000);
                    }
                }, "json");
            }
        </script>
    </body>
</html>
<?php

function curlGet($url) {
    $ch = curl_init();
    $headers[] = 'Accept-Charset:utf-8';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function curlPost($url, $data) {
    $ch = curl_init();
    $headers[] = 'Accept-Charset: utf-8';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);

    if (isset($result['errcode'])) {
        $errmsg = wx_error_msg($result['errcode']);
        return array('errcode' => $result['errcode'], 'errmsg' => $errmsg);
    } else {
        $result['errcode'] = 0;
        return $result;
    }
}

function wx_error_msg($code) {
    if ($code == -1) {
        return '微信平台系统繁忙';
    }

    $error_codes = array(40001 => '获取access_token时AppSecret错误，或者access_token无效', 40002 => '不合法的凭证类型', 40003 => '不合法的OpenID', 40004 => '不合法的媒体文件类型', 40005 => '不合法的文件类型', 40006 => '不合法的文件大小', 40007 => '不合法的媒体文件id', 40008 => '不合法的消息类型', 40009 => '不合法的图片文件大小', 40010 => '不合法的语音文件大小', 40011 => '不合法的视频文件大小', 40012 => '不合法的缩略图文件大小', 40013 => '不合法的APPID', 40014 => '不合法的access_token', 40015 => '不合法的菜单类型', 40016 => '不合法的按钮个数', 40017 => '不合法的按钮个数', 40018 => '不合法的按钮名字长度', 40019 => '不合法的按钮KEY长度', 40020 => '不合法的按钮URL长度', 40021 => '不合法的菜单版本号', 40022 => '不合法的子菜单级数', 40023 => '不合法的子菜单按钮个数', 40024 => '不合法的子菜单按钮类型', 40025 => '不合法的子菜单按钮名字长度', 40026 => '不合法的子菜单按钮KEY长度', 40027 => '不合法的子菜单按钮URL长度', 40028 => '不合法的自定义菜单使用用户', 40029 => '不合法的oauth_code', 40030 => '不合法的refresh_token', 40031 => '不合法的openid列表', 40032 => '不合法的openid列表长度', 40033 => '不合法的请求字符，不能包含\\uxxxx格式的字符', 40035 => '不合法的参数', 40038 => '不合法的请求格式', 40039 => '不合法的URL长度', 40050 => '不合法的分组id', 40051 => '分组名字不合法', 41001 => '缺少access_token参数', 41002 => '缺少appid参数', 41003 => '缺少refresh_token参数', 41004 => '缺少secret参数', 41005 => '缺少多媒体文件数据', 41006 => '缺少media_id参数', 41007 => '缺少子菜单数据', 41008 => '缺少oauth code', 41009 => '缺少openid', 42001 => 'access_token超时', 42002 => 'refresh_token超时', 42003 => 'oauth_code超时', 43001 => '需要GET请求', 43002 => '需要POST请求', 43003 => '需要HTTPS请求', 43004 => '需要接收者关注', 43005 => '需要好友关系', 44001 => '多媒体文件为空', 44002 => 'POST的数据包为空', 44003 => '图文消息内容为空', 44004 => '文本消息内容为空', 45001 => '多媒体文件大小超过限制', 45002 => '消息内容超过限制', 45003 => '标题字段超过限制', 45004 => '描述字段超过限制', 45005 => '链接字段超过限制', 45006 => '图片链接字段超过限制', 45007 => '语音播放时间超过限制', 45008 => '图文消息超过限制', 45009 => '接口调用超过限制', 45010 => '创建菜单个数超过限制', 45015 => '回复时间超过限制', 45016 => '系统分组，不允许修改', 45017 => '分组名字过长', 45018 => '分组数量超过上限', 46001 => '不存在媒体数据', 46002 => '不存在的菜单版本', 46003 => '不存在的菜单数据', 46004 => '不存在的用户', 47001 => '解析JSON/XML内容错误', 48001 => 'api功能未授权', 50001 => '用户未授权该api');

    if (isset($error_codes[$code])) {
        return $error_codes[$code];
    } else {
        return '错误号：' . $code . ',未知错误';
    }
}
?>
