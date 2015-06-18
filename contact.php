<!DOCTYPE HTML SYSTEM>
<html>
	<head>
		<meta http-equiv="ContentType" content="text/html; charset=utf-8">
		<title>BHOI - Oficijelna stranica</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css">
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
		<script src="scripts/dropdown.js" type="text/javascript"></script>
		<script src="scripts/slideshow.js" type="text/javascript"></script>
		<script src="scripts/services.js" type="text/javascript"></script>
	</head>
	<?php
		define('CHARSET', 'UTF-8');
		$imeIPrezime = "";
		$emailAdresa = "";
		$poruka = "";
		$err1p = $err2p = $err3p = "";
	    $displayCheck = 'none';
		$header = "Kontaktirajte nas putem WEB obrasca";
		function editInputData($data) 
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
			return $data;
		}
		function validateName($name)
		{
			$upperName = strtoupper($name);
			if ($upperName == "")
				return false;
			for ($i = 0; $i < strlen($upperName); $i++)
				if (($upperName[$i] < 'A' || $upperName[$i] > 'Z') && $upperName[$i] != ' ')
					return false;
				return true;
		}
		$valid = true;
		if(isset($_POST["send"]))
		{
			$imeIPrezime = editInputData($_POST["imeIPrezime"]);
			$emailAdresa = editInputData($_POST["email"]);
			$poruka = editInputData($_POST["message"]);
			$err1p = $err2p = $err3p = "";
			$displayCheck = 'none';
			if(!validateName($imeIPrezime))
			{
				$valid = false;
				$err1p = '<img src="images/error.png" class="error1" style="display: inline;" title="Polje je prazno ili sadrži nedozvoljene znakove">';
			}
			if(!preg_match("/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]/i", $emailAdresa))
			{
				$valid = false;
				$err2p = '<img src="images/error.png" class="error1" style="display: inline;" title="Polje je prazno ili ne predstavlja email adresu">';
			}
			
			if($poruka == "")
			{
				$valid = false;
				$err3p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			}
			if($valid)
			{
				$displayCheck = 'block';
				$header = "Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke";
			}
		}
		if(isset($_POST["sure"]))
		{
			$header = "Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke";
			$imeIPrezime = $_POST["imeIPrezimeH"];
			$emailAdresa = $_POST["emailH"];
			$poruka = $_POST["porukaH"];
			$displayCheck = $_POST["displayCheckH"];
			require("sendgrid-php/sendgrid-php.php");
			$service_plan_id = "sendgrid_56d99";
			$account_info = json_decode(getenv($service_plan_id), true);
			$sendgrid = new SendGrid("amehanovic1", "woot123.");
			$email = new SendGrid\Email();
			$email->addTo("amehanovic1@etf.unsa.ba")->setFrom($emailAdresa)->setSubject("BHOI - Kontakt obrazac")->setText($poruka);
			$sendgrid->send($email);
			print '<script>alert("Zahvaljujemo se što ste nas kontaktirali")</script>';
		}
	?>
	<body>
		<div id="slideshow">
			<div id="top">
				<div id="menu">
					<img src="images/Logo.png" alt="Logo">
					<ul>
						<li><a onclick="loadNewPage('news.php')">Početna</a></li>
						<li><a onclick="loadNewPage('contests.html')">Takmičenja</a></li>
						<li><a onclick="loadNewPage('projects.html')">Projekti</a></li>
						<li><a onclick="loadNewPage('gallery.html')">Galerija</a></li>
						<li><a onclick="loadNewPage('about.html')">O&nbsp;nama</a></li>
						<li><a href="contact.php">Kontakt</a></li>
						<li><a href="admin.php">Admin</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="main_wrapper">
			<h1>Kontakt</h1>
			<div id="contact">
				<p>
				Telefon: +387 33 100 001<br>
				Fax: +387 33 100 002<br>
				Email: email@email.com<br>
				Adresa: Ulica Zmaja od Bosne b.b., 71000 Sarajevo, Bosna i Hercegovina<br>
				</p>
				<div id="provjera" style="display: <?php print $displayCheck; ?>">
					<form method="post">
						<input type="hidden" name="imeIPrezimeH" value="<?php print $imeIPrezime; ?>">
						<input type="hidden" name="emailH" value="<?php print $emailAdresa; ?>">
						<input type="hidden" name="porukaH" value="<?php print $poruka; ?>">
						<input type="hidden" name="displayCheckH" value="<?php print $displayCheck; ?>">
						<h4>Provjerite da li ste ispravno popunili kontakt formu</h4>
						<p>
						<?php 
							print "Ime i prezime: ".$imeIPrezime."<br>";
							print "Email: ".$emailAdresa."<br>";
							print "Poruka: ".$poruka."<br>";
						?>
						</p>
						<h4>Da li ste sigurni da želite poslati ove podatke?</h4>
						<button name="sure" type="submit" action="<?php print htmlspecialchars($_SERVER["PHP_SELF"]);?>">Siguran&nbsp;sam</button>
					</form>
				</div>
				<h4><?php print $header; ?></h4>
				<p>Polja označena sa * su obavezna</p>
				<form method="post" action="<?php print htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<p>
					Ime i prezime: *<br>
					<input type="text" name="imeIPrezime" value="<?php print $imeIPrezime; ?>"><?php print $err1p; ?>
					<br>
					<br>
					Email: *<br>
					<input type="text" name="email" value="<?php print $emailAdresa; ?>"><?php print $err2p; ?>
					<br>
					<br>
					Poruka: *<br>
					<textarea rows="10" cols="80" name="message"><?php print $poruka; ?></textarea><?php print $err3p; ?><br>
					<br>
					<button name="send" type="submit">Pošalji</button>
					<button name="reset" type="submit">Resetuj</button>
					</p>
				</form>
				<br>
				<br>
			</div>
		</div>
		<div id="banners">
			<a href="http://www.turkishairlines.com" target="_blank">
			<img src="images/TALogo.png" alt="Logo1"></a>
			<a href="http://www.ius.edu.ba/bs" target="_blank">
			<img src="images/IUSLogo.png" alt="Logo2"></a>
			<a href="http://www.coca-cola.ba" target="_blank">
			<img src="images/CocaColaLogo.png" alt="Logo3"></a>
			<a href="http://www.liverpoolfc.com" target="_blank">
			<img src="images/LFCLogo.png" alt="Logo4"></a>
			<a href="http://www.milka.com" target="_blank">
			<img src="images/MilkaLogo.png" alt="Logo5"></a>
			<a href="http://www.fanta.ba" target="_blank">
			<img src="images/FantaLogo.png" alt="Logo6"></a>
			<a href="http://www.mercedesamgf1.com" target="_blank">
			<img src="images/MercLogo.png" alt="Logo7"></a>
		</div>
		<div id="footer">
			<h1>COPYRIGHT © BHOI 2015</h1>
		</div>
		<script>
		window.onload = function () {
			slideshow()
			setInterval(function () {
				slideshow()
			}, 7000)
		}
		</script>
	</body>
</html>