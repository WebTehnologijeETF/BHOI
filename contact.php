<!DOCTYPE HTML SYSTEM>
<html>
	<head>
		<meta http-equiv="ContentType" content="text/html; charset=utf-8">
		<title>BHOI - Oficijelna stranica</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css">
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
		<script src="scripts/dropdown.js" type="text/javascript"></script>
		<script src="scripts/validation.js" type="text/javascript"></script>
		<script src="scripts/navigation_contact.js" type="text/javascript"></script>
		<script src="scripts/services.js" type="text/javascript"></script>
	</head>
	<?php
		define('CHARSET', 'UTF-8');
		$imeIPrezime = "";
		$emailAdresa = "";
		$opcina = "";
		$mjesto = "";
		$ddl = "";
		$websiteurl = "";
		$poruka = "";
		$err1p = $err2p = $err3p = $err4p = $err5p = "";
		$selected1 = $selected2 = '';
		$displayWebsite = $displayCheck = 'none';
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
			if (((int)$upperName[$i] < 65 || (int)$upperName[$i] > 90) && (int)$upperName[$i] != ' ')
				return false;
			return true;
		}
		$valid = true;
		if(isset($_POST["send"]))
		{
			$imeIPrezime = editInputData($_POST["imeIPrezime"]);
			$emailAdresa = editInputData($_POST["email"]);
			$opcina = editInputData($_POST["opcina"]);
			$mjesto = editInputData($_POST["mjesto"]);
			$ddl = editInputData($_POST["ddl"]);
			$websiteurl = editInputData($_POST["websiteURL"]);
			$poruka = editInputData($_POST["message"]);
			$err1p = $err2p = $err3p = $err4p = $err5p = "";
			$selected1 = $selected2 = '';
			$displayWebsite = $displayCheck = 'none';
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
			if($ddl != "Da" && $ddl != "Ne")
			{
				$valid = false;
				$websiteurl = '';
				$err3p = '<img src="images/error.png" class="error1" style="display: inline;" title="Sadržaj padajuæeg izbornika je ureðivan">';
			}
			else
			{
				if($ddl == "Da")
				{
					$selected1 = '';
					$selected2 = 'selected="selected"';
					$displayWebsite = 'block';
					if(!preg_match("/^(www)+\.[A-Z0-9.-]+\.[A-Z]/i", $websiteurl))
					{
						$valid = false;
						$err4p = '<img src="images/error.png" class="error1" style="display: inline;" title="Polje je prazno ili ne predstavlja website URL">';
					}
				}
				else
				{
					$selected1 = 'selected="selected"';
					$selected2 = '';
					$websiteurl = '';
				}
			}
			if($poruka == "")
			{
				$valid = false;
				$err5p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
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
			$opcina = $_POST["opcinaH"];
			$mjesto = $_POST["mjestoH"];
			$websiteurl = $_POST["websiteURLH"];
			$poruka = $_POST["porukaH"];
			$selected1 = $_POST["selected1H"];
			$selected2 = $_POST["selected2H"];
			$displayWebsite = $_POST["displayWebsiteH"];
			$displayCheck = $_POST["displayCheckH"];
			require("sendgrid-php/sendgrid-php.php");
			$service_plan_id = "sendgrid_56d99";
			$account_info = json_decode(getenv($service_plan_id), true);
			$sendgrid = new SendGrid("amehanovic1", "woot123.");
			$email = new SendGrid\Email();
			$email->addTo("amehanovic1@etf.unsa.ba")->addCc("vljubovic@etf.unsa.ba")->setFrom($emailAdresa)->setSubject("BHOI - Kontakt obrazac")->setText($poruka);
			$sendgrid->send($email);
			echo '<script>alert("Zahvaljujemo se što ste nas kontaktirali")</script>';
		}
	?>
	<body>
		<div id="slideshow">
			<div id="top">
				<div id="menu">
					<img src="images/Logo.png" alt="Logo">
					<ul>
						<li><a onclick="loadNewPage('news.php')">Poèetna</a></li>
						<li><a onclick="loadNewPage('contests.html')">Takmièenja</a></li>
						<li><a onclick="loadNewPage('projects.html')">Projekti</a></li>
						<li><a onclick="loadNewPage('gallery.html')">Galerija</a></li>
						<li><a onclick="loadNewPage('about.html')">O&nbsp;nama</a></li>
						<li><a href="contact.php">Kontakt</a></li>
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
				<div id="provjera" style="display: <?php echo $displayCheck; ?>">
					<form method="post">
						<input type="hidden" name="imeIPrezimeH" value="<?php echo $imeIPrezime; ?>">
						<input type="hidden" name="emailH" value="<?php echo $emailAdresa; ?>">
						<input type="hidden" name="opcinaH" value="<?php echo $opcina; ?>">
						<input type="hidden" name="mjestoH" value="<?php echo $mjesto; ?>">
						<input type="hidden" name="websiteURLH" value="<?php echo $websiteurl; ?>">
						<input type="hidden" name="porukaH" value="<?php echo $poruka; ?>">
						<input type="hidden" name="porukaH" value="<?php echo $poruka; ?>">
						<input type="hidden" name="selected1H" value="<?php echo $selected1; ?>">
						<input type="hidden" name="selected2H" value="<?php echo $selected2; ?>">
						<input type="hidden" name="displayWebsiteH" value="<?php echo $displayWebsite; ?>">
						<input type="hidden" name="displayCheckH" value="<?php echo $displayCheck; ?>">
						<h4>Provjerite da li ste ispravno popunili kontakt formu</h4>
						<p>
						<?php 
							echo "Ime i prezime: ".$imeIPrezime."<br>";
							echo "Email: ".$emailAdresa."<br>";
							echo "Opæina: ".$opcina."<br>";
							echo "Mjesto: ".$mjesto."<br>";
							echo "Website URL: ".$websiteurl."<br>";
							echo "Poruka: ".$poruka."<br>";
						?>
						</p>
						<h4>Da li ste sigurni da želite poslati ove podatke?</h4>
						<button name="sure" type="submit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">Siguran&nbsp;sam</button>
					</form>
				</div>
				<h4><?php echo $header; ?></h4>
				<p>Polja oznaèena sa * su obavezna</p>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<p>
					Ime i prezime: *<br>
					<input type="text" name="imeIPrezime" value="<?php echo $imeIPrezime; ?>"><?php echo $err1p; ?>
					<br>
					<br>
					Email: *<br>
					<input type="text" name="email" value="<?php echo $emailAdresa; ?>"><?php echo $err2p; ?>
					<br>
					<br>
					Opæina:<br>
					<input type="text" name="opcina" value="<?php echo $opcina; ?>">
					<br>
					<br>
					Mjesto:<br>
					<input type="text" name="mjesto" value="<?php echo $mjesto; ?>">
					<br>
					<br>
					Imate li website?<br>
					<select name="ddl" id="ddl" onchange="return update()"><?php echo $err3p; ?>
						<option value="Ne" <?php echo $selected1; ?> >Ne</option>
						<option value="Da" <?php echo $selected2; ?> >Da</option>
					</select>
					<br>
					</p>
					<div id="website" style="display:<?php echo $displayWebsite; ?>;">
						<p>Website URL: *</p>
						<input type="text" name="websiteURL" value="<?php echo $websiteurl; ?>"><?php echo $err4p; ?>
					</div>
					<p>
					<br>
					Poruka: *<br>
					<textarea rows="10" cols="80" name="message"><?php echo $poruka; ?></textarea><?php echo $err5p; ?><br>
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
	</body>
</html>