<?php

try{
	function getIsPostRequest()
		{
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
		}
	$datetime = date("Y-m-d h:i:s", time()); //时间
	if(getIsPostRequest()){
	require_once("./functions.php");
	$data = json_decode(file_get_contents('php://input'), true);
	if(isset($data["heade"]) && isset($data["text"]) && isset($data["email"]) && $data["email"]!=NULL && $data["text"]!=NULL && $data["heade"]!=NULL){
	$mailtitle = $data["heade"];//邮件主题
	$mailcontent = $data["text"];//邮件内容
	$email = $data["email"];//邮件内容


//接受邮件的邮箱地址
//$email='myxy99@foxmail.com';


//$subject为邮件标题
	$subject = $mailtitle;

//$content为邮件内容
	$content="<div><b>".$mailcontent."</b></div>";


//执行发信
	$flag = sendMail($email,$subject,$content);
//判断是否重复提交！
	if($flag)
	{
    //发送成功
	$data = [
                'code' => '发送成功',
                'dtime' => $datetime,
            ];
	}else{
    //发送失败
		$data = [
                'code' => '发送失败',
                'dtime' => $datetime,
            ];
	}
	echo json_encode($data);
	}else{
	$data = [
                'code' => '瞎搞？？',
                'dtime' => $datetime,
            ];
		echo json_encode($data);	
	}
	}else{
			$data = [
                'code' => '不支持GET请求',
                'dtime' => $datetime,
            ];
		echo json_encode($data);	
	}
}catch(Exception $e){
	    		$data = [
                'code' => '系统错误',
                'dtime' => $datetime,
            ];
		echo json_encode($data);
}