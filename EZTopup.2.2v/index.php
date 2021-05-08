<?php 
	session_start();

    $guestname = "Guest";
    $log = "";

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $_SESSION["name"] = $guestname;
        $log = "Login";
    }else {
    	$log = "Logout";
    }

?>

<!DOCTYPE html>
<html>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/1.css">
	<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="js/dropdown_user.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<script type="text/javascript" src="js/navbar.js" ></script>
<head>
	<title>EZ Topup</title>
	<header>
		<div class="user-int">
			<div class="dropdown">
				<p class="userName">Welcome, </p><a class="userName1" href=""><?php echo htmlspecialchars($_SESSION["name"]); ?></a>
  				<button onclick="myFunction()" class="dropbtn"><i class="far fa-user"></i></button>
  				<div id="myDropdown" class="dropdown-content">
    				<a href="logout.php"><?php echo $log; ?></a>
    				<?php if($log == "Login"){?>
    				<a href="register.php">Register</a>
    				<?php }else{?>
    				<a href="resetpass.php">Reset Password</a>
    				<?php }?>
  				</div>
			</div>
		</div>
		<nav>
		<div class="logo">
			<p class="ezt"><a href="index.php"><img src="icon/logo_EZT_2.0_0_0.ico" width="120" height="40"></a></p>
		</div>
		<ul>
			<li><a href="#home" class="cool-link">HOME</a></li>
			<li><a href="#about" class="cool-link1">ABOUT US</a></li>
			<li><a href="#contact" class="cool-link1">inquire US</a></li>
			<li><a href="faqs.html" class="cool-link1">FAQs</a></li>
		</ul>
		</nav>
	</header>
</head>
<body>
	<section class="s1" id="home">
				
		<div class="color-overlay"></div>
		<img src="image/tetris-1552480157679-1688.jpg">
		<div class="top">
			<p>the most profitable game reload</p>
			<div class="box-button">
				<a href="store.html" class="button7" style="text-decoration: none;">
					<span style="font-size:30px; font-family: 'play', cursive; 
					border-right:1px solid rgba(255,255,255,0.5);padding-right:0.4em; 
					margin-right:0em; vertical-align:middle"><i class="fas fa-shopping-bag" style="color: #42d4f4;"></i></span>
 					TOPUP NOW
				</a>
			</div>
			<div class="arrow-down" >
				<span></span>
				<span></span>
				<span></span>
				<a href="store.html"><span class="hyperspan"></span></a> 
			</div>
		</div>
	</section>
	<section class="s2" id="about">
		<div class="left-pic">
			<img src="icon/logo_EZT_2.0_0_0.ico">
		</div>
		<h2>ABOUT US</h2>
		<p>EASY, FAST AND FRIENDLY IS OUR PRIORITY TO MAKE YOUR ONLINE TOPUP GOING SMOOTH AND STYLE.<br><br>
		We are creating a website where you can topup many type of game from different website easy and nice. We guarantee instant to 15 Minutes Online Delivery! 
		EzTopup is committed to deliver all your purchases on Game Cards, Game Portal Cards or Gaming Tools online within 15 minutes, if not instant! We want you to be able to enjoy gaming sessions seamlessly rather than waiting for what you have purchased.Here at EzTopup, we have been and will always continue to cater more game related products.To enhance your shopping experience, our site is specifically designed to give you a seamless checkout system and a near instant delivery on digital products. Be assured that we will continually upgrade our services to provide all our customers with the best shopping experience you can find anywhere. Our beliefs are to give our customers a one-stop through continuously expanding our product varieties and availability. Our top target or goals is to make young and new generation play game and make E-Sport famous in Malaysia.</p>
	</section>
	<section class="s3" id="contact">
		 <div class="pannel-left">
          <h1>Get in Touch</h1>
          <h3>Please fill out the quick form and we will be in touch with lightning speed.</h3>
          <div class="contact-form">
            <form method="POST" action="contact.php" accept-charset="UTF-8">
            	<div class="aler_message"><?php if(isset($message)) { echo $message; } ?></div>
            	<input name="_token" type="hidden">
              	<input type="hidden" name="_token" >
              	<input type="text" required placeholder="Name" name="name" class="contact-form-field">
              	<input type="email" required placeholder="Your email address" class="contact-form-field" name="email">
              	<input type="text" required placeholder="Subject" name="subject" class="contact-form-field">
              	<textarea required placeholder="Message" id="comments" class="contact-form-field" name="comments"></textarea>
              	<input name="send" type="submit" value="Send" class="contact-form-submit">
            </form>
          </div>
        </div>
        <div class="pannel-right">
          <h3>Connect with us:</h3>
          <p>For support or any questions:
            <br>Email us at <a href="support@EZTopup.com" target="_blank">support@EZTopup.com</a>
          </p>
          <div id="statusMessage"> 
                        <?php
                        if (! empty($message)) {
                            ?>
                            <p class='<?php echo $type; ?>Message'><?php echo $message; ?></p>
                        <?php
                        }
                        ?>
           </div>
        </div>
	</section>
	<section class="s4">
		<div  class="foot-right">
			<a href="#"><i class="fab fa-facebook-square"></i></a>
			<a href="#"><i class="fab fa-twitter-square"></i></a>
			<a href="#"><i class="fab fa-instagram"></i></a>
		</div>
		<div class="foot-left">
				<p class="foot-links">
					<a href="index.php#home">Home</a>
					·
					<a href="store.html">Shop</a>
					·
					<a href="index.php#about">About</a>
					·
					<a href="index.php#contact">Contact</a>
					·
					<a href="faqs.html">FAQs</a>
				</p>
				<p>EZTopup &copy; 2019</p>
			</div>
	</section>
</body>
</html>