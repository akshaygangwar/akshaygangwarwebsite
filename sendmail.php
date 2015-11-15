<?php

	//echo $_POST['name'];
	//echo $_POST['querytype'];
	//echo $_POST['message'];

	$name = $querytype = $message = $email = $verify = $needresponse = "";
	$nameErr = $emailErr = "";	

	//remove all htmlspecialcharacters and slashes from input to prevent XSS attacks.
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$name = test_input($_POST['q1']);
	//ensure that names only have letters and whitespaces.
	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$nameErr = "Only letters and white space allowed"; 
		echo $nameErr. "<br />";
	}
	$querytype = $_POST['q3'];
	$needresponse = $_POST['q4'];
	$message = test_input($_POST['q5']);
	$email = test_input($_POST['q2']);
	$verify = $_POST['q6'];

	//if there are no errors in the name input
	if ($nameErr == "") {
		//safe to email
		//echo " NO ERROR WITH FORM";
		$subject = "";
		if ($querytype == "question"){
			echo "Question";
			$subject = 'Question from '. $email;
		}
		else {
			echo "Feedback";
			$subject = "Feedback from ". $email;
		}

		//change the recipient to holocastapp@gmail.com after testing is complete.
		$recipient = "akshaygangwar2009@gmail.com";

		$msgbody = "Email received from ". $name. "\n";
		$msgbody .= $message;
		//$msgbody = wordwrap($msgbody, 70);

		$from = $email;
		$humanBool = False;

		//check if human
		if ($verify == "whitewalkers") {
			$humanBool = False;
		}
		else {
			$humanBool = True;
		}

		//if human, do the following
		if($humanBool == True){
			if($trueBool = mail($recipient, $subject, $msgbody, $from)) {
				echo "<script>alert('Message Successfully Submitted')</script>";
				echo "<script>location.href='".$_SERVER['HTTP_REFERER']."'</script>";
			}
		}
		//otherwise do the following
		else {
			echo "<script>alert('The Citadel does not accept ravens from the Whitewalkers')</script>";
			echo "<script>location.href='".$_SERVER['HTTP_REFERER']."'</script>";
		}

		//$uri = 'http://';
		//$uri .= $_SERVER['HTTP_HOST'];

		//header('Location: '.$uri.'/app-2/index.html');
		//exit;

	}

	//if there's an error with name, alert the user.
	else {
		echo "<script>alert('Could not send the message. Only letters and whitespaces allowed.')</script>";
		echo "<script>location.href='".$_SERVER['HTTP_REFERER']."'</script>";
	}

?>