<?php

	$username="database username";
	$password="database password";
	$database="database name";

	$conn = new mysqli(localhost, $username, $password, $database);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "set names 'utf8'";

	if ($conn->query($sql) === FALSE) {
		echo "ERROR: " . $conn->error;
	}

	$sql = "INSERT INTO Messages (email, message) VALUES ('" 
		. $_POST['email'] . "','" 
		. $_POST['message'] . "')";

	if ($conn->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

	echo "Message sent successfully";
?>
