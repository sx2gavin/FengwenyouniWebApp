<?php
	// This file is for testing only.
	$username="Replace with your database username";
	$password="Replace with your database password";
	$database="Replace with your database name";

	$conn = new mysqli(localhost, $username, $password, $database);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO Registrations (name, email, church, fellowship, isChristian) VALUES ('Gavin', 'blah@blah.com', 'CGC', 'CGCJF', 1)";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}


	echo "Database connected successfully.";
	$conn->close();
?>
