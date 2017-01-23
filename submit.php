<?php
require 'PHPMailer/PHPMailerAutoload.php';

	$username="Replace with your database username";
	$password="Replace with your database password";
	$database="Replace with your database name";

	$conn = new mysqli(localhost, $username, $password, $database);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$isChristian = $_POST['isChristian'] == TRUE? 1 : 0;
	$hasChurch = $_POST['hasChurch'] == TRUE? 1 : 0;

	$sql = "set names 'utf8'";

	$fingerprint = md5($_POST['name'] . $_POST['email']);

	if ($conn->query($sql) === FALSE) {
		echo "ERROR: " . $conn->error;
	}

	$sql = "INSERT INTO Registrations (name, email, wechat, phone, school, church, area, isChristian, hasChurch, FingerPrint) VALUES ('" 
		. $_POST['name'] . "','" 
		. $_POST['email'] . "','" 
		. $_POST['wechat'] . "','" 
		. $_POST['phone'] . "','" 
		. $_POST['school'] . "','" 
		. $_POST['church'] . "','" 
		. $_POST['area'] . "'," 
		. $isChristian . "," 
		. $hasChurch . ",'"
		. $fingerprint . "')";

	if ($conn->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

	$name = $_POST['name'];
	$to = $_POST['email'];

	$mail = new PHPMailer;
	// $mail->isSMTP();
	$mail->isSendmail();
	/*
	$mail->SMTPDebug = 2;
	$mail->Debugoutput = 'html';
	$mail->Host = "mail.fengwenyouni.com";
	$mail->SMTPAuth = false;
	$mail->SMTPSecure = false;
	$mail->Port = 2525;
	$mail->SMTPSecure = 'tls';
	*/
	$mail->Username = "no-reply@fengwenyouni.com";
	$mail->Password = "replace with your email password.";
	$mail->CharSet = 'UTF-8';
	$mail->ContentType = 'text/html; charset=utf-8\r\n';	

	$mail->setFrom('no-reply@fengwenyouni.com', 'no-reply');
	$mail->addAddress($_POST['email'], $_POST['name']);


	$subject = "Registration confirmation";
	$message = "
		<html>
			<head>
				<title>注册成功！</title>
			</head>

			<body>
				<p>你好 $name,</p>
				<br>
				<p>您已申请成功参加枫闻有祢大学生佈道会!</p>
				<p>您的注册号码为: <b>$fingerprint</b>.</p>
				<p><b>请保留此邮件作为您佈道会的入场券。<b></p>
				<p>时间：<b>2016年9月23日晚上7:00pm</b></p>
				<p>地点: <b>Knox Presbyterian Church, 630 Spadina Ave, Toronto, ON</b></p>
				<p>我们期待与你相见！</p>
				<br>
				<p>主内,</p>
				<p>枫闻有祢</p>
			<body>
		</html>
		";

	$mail->Subject = $subject;
	$mail->msgHTML($message);

	if (!$mail->send())
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
		echo "Success";
	}
	

	/*
	 * PHP local mail method.
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;chartset=UTF-8" . "\r\n";

	mail($to, $subject, $message, $headers);
	echo "Success";
	 */
?>
