<?php
// define variables and set to empty values
$nameErr = $emailErr = $isChristianErr =  "";
$name = $email = $wechat = $phone = $school = $area = $church = "";
$isChristian = FALSE;
$hasChurch = FALSE;
$hasError = FALSE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty ($_POST["name"])) {
		$nameErr = "Name is required";
		$hasError = TRUE;
	} else {
		$name = test_input($_POST["name"]);
	}

	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
		$hasError = TRUE;
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
			$hasError = TRUE;
		}
	}

	if (empty($_POST["isChristian"])) {
		$isChristianErr = "Required to select.";
		$hasError = TRUE;
	} else {
		$isChristian = $_POST["isChristian"] === 'TRUE'?TRUE:FALSE;
	}

	$wechat = test_input($_POST["wechat"]);
	$phone = test_input($_POST["phone"]);
	$school = test_input($_POST["school"]);
	$hasChurch = $_POST["hasChurch"] === 'TRUE'?TRUE:FALSE;
	$church = test_input($_POST["church"]);
	$area = test_input($_POST["area"]);


	if ($hasError === FALSE) {
		// send the data to another php and add it to the database.
		$url = "http://www.fengwenyouni.com/submit.php";
		$data = array('name' => $name, 'email' => $email, 'wechat' => $wechat, 'phone' => $phone, 'school' => $school,'hasChurch' => $hasChurch, 'church' => $church, 'area' => $area, 'isChristian' => $isChristian);

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);

		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result == "Success")
		{
			header("Location: http://www.fengwenyouni.com/successful.html");
			exit;
			//	echo "ERROR: There was an error occured when sending your information to the database.";
		}
		else
		{
			$emailErr = $result;
		}
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>枫闻有祢</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />

		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>

		<div id="content">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">枫闻有祢</a>
					</div>	
					<ul class="nav navbar-nav">
						<li class="active"><a href="#"><span class="glyphicon glyphicon-edit"></span> REGISTER</a></li>
						<li><a href="info.html"><span class="glyphicon glyphicon-home"></span> EVENT INFO</a></li>
						<li><a href="testimonies.html"><span class="glyphicon glyphicon-eye-open"></span> TESTIMONIES</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="contactus.html"><span class="glyphicon glyphicon-envelope"></span> CONTACT US</a></li>
					</ul>
				</div>
			</nav>

			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-8 col-md-offset-2">
						<h1>Registration form 报名表</h1>
						<p>请填写以下信息报名佈道会</p> 
						<p><span class="error">* required field.</span></p>

						<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
							<div class="form-group">
								<label for="name_text">姓名(中英)Name:<span class="error">* <?php echo $nameErr;?> </span></label>
								<input class="form-control" type="TEXT" name="name" id="name_text" value="<?php echo $name; ?>"/>
							</div>

							<div class="form-group">
								<label for="email_text">邮箱Email:<span class="error">* <?php echo $emailErr;?> </span></label>
								<input class="form-control" type="TEXT" name="email" id="email_text" value="<?php echo $email; ?>" />
							</div>

							<div class="form-group">
								<label>是否为基督徒Are you a Christian? <span class="error">* <?php echo $isChristianErr;?> </span></label>
								<br />
								<input type="RADIO" name="isChristian" id="is_christian_radio_true" value="TRUE" <?php if (isset($isChristian) && $isChristian==TRUE) echo "checked";?>/>
								<label for="is_christian_radio_true">Yes</label>
								<br />
								<input type="RADIO" name="isChristian" id="is_christian_radio_false" value="FALSE" <?php if (isset($isChristian) && $isChristian==FALSE) echo "checked";?>/>
								<label for="is_christian_radio_false">No</label>
							</div>

							<!-- <div class="form-group">
								<label for="wechat_text">微信Wechat:</label>
								<input class="form-control" type="TEXT" name="wechat" id="wechat_text" value="<?php echo $wechat; ?>" />
							</div>

							<div class="form-group">
								<label for="phone_text">电话Phone Number:</label>
								<input class="form-control" type="TEXT" name="phone" id="phone_text" value="<?php echo $phone; ?>" />
							</div>
							-->

							<div class="form-group">
								<label for="school_text">学校school(在读或毕业):</label>
								<input class="form-control" type="TEXT" name="school" id="school_text" value="<?php echo $school; ?>" />
							</div>

							<div class="form-group">
								<label for="fellowship_text">所在城市(如果你在大多伦多地区居住，请拜托详细说下地区，因为实在有点大，例如: Markham):</label>
								<input class="form-control" type="TEXT" name="area" id="area_text" value="<?php echo $area; ?>" />
							</div>

							<div class="form-group">
								<label>是否有去固定教会Do you have a home church? </label>
								<br />
								<input type="RADIO" name="hasChurch" id="has_church_radio_true" value="TRUE" <?php if (isset($hasChurch) && $hasChurch==TRUE) echo "checked";?>/>
								<label for="has_church_radio_true">Yes</label>
								<br />
								<input type="RADIO" name="hasChurch" id="has_church_radio_false" value="FALSE" <?php if (isset($hasChurch) && $hasChurch==FALSE) echo "checked";?>/>
								<label for="has_church_radio_false">No</label>
							</div>

							<div class="form-group">
								<label for="church_text">(若是）所在教会Church: </label>
								<input class="form-control" type="TEXT" name="church" id="church_text" value="<?php echo $church; ?>" />
							</div>


							<button type="SUBMIT" class="btn btn-default">Submit</button>
						</form>
					</div>
				</div>
			</div> 
		</div> <!-- content -->


		<div id="footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-8 col-md-offset-2">
						<p class="text-muted">&copy;2016 枫闻有祢 All right reserved.</p> 
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
