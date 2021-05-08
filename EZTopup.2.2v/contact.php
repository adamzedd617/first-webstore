<?php
	if (isset($_POST['send'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$comments = $_POST['comments'];

		$mailto = "adamzedd617@gmail.com";
		$headers = "From: ".$email;
		$txt = "You have received an email from ".$name.".\n\n".$comments;
		mail($mailto, $subject, $txt, $headers);
		
		header("location: index.php?mailsendto:support@EZTopup.com");
	}
?>