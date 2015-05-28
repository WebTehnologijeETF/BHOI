<!DOCTYPE HTML SYSTEM>
<html>
	<head>
		<meta http-equiv="ContentType" content="text/html; charset=utf-8">
		<title>BHOI - Oficijelna stranica</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css">
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	</head>
	<?php
	session_start();
	define('CHARSET', 'UTF-8');
	$veza = new PDO("mysql:dbname=bhoi;host=localhost;charset=utf8", "bhoiuser", "pw123!");
	$veza -> exec("set names utf8");
	$err1p = $err2p = $err3p = $korisnickoImeKorisnika = $sifra = $email = "";
	function editInputData($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
		return $data;
	}
	if(isset($_POST["dodaj"]))
	{
		$err1p = $err2p = $err3p = "";
		$korisnickoImeKorisnika = editInputData($_POST["korisnickoImeKorisnika"]);
		$sifra = editInputData($_POST["sifra"]);
		$email = editInputData($_POST["email"]);
		$valid = true;
		if($korisnickoImeKorisnika == "")
		{
			$err1p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($sifra == "")
		{
			$err2p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($email == "")
		{
			$err3p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($valid)
		{
			$noviKorisnik = $veza -> prepare("insert into korisnici set korisnickoIme = ?, sifra = md5(?), email = ?;");
			$noviKorisnik -> execute(array($korisnickoImeKorisnika, $sifra, $email));
			if (!$noviKorisnik) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Korisnik uspješno dodan!'); </script>"; 
		}
	}
	?>
	<body id="form_body">
		<div id="main_wrapper">
			<h1>Dodavanje korisnika</h1>
			<div id="form">
				<?php
					if (isset($_SESSION['korisnickoIme']))
					{
						print '<p>Polja označena sa * su obavezna</p>';
						print '<form method="post">';
						print "<p>Korisničko ime: *</p><input type=\"text\" name=\"korisnickoImeKorisnika\" value=\"$korisnickoImeKorisnika\">$err1p";
						print "<p>Šifra: *</p><input type=\"password\" name=\"sifra\" value=\"$sifra\">$err2p";
						print "<p>Email: *</p><input type=\"text\" name=\"email\" value=\"$email\">$err3p";
						print "<br><br><button name=\"dodaj\" type=\"submit\">Dodaj</button></form><br><br>";  
					}
					else
						print '<p style="color:red"><b>Greška! Najprije izvršite prijavu!</b></p>';
				?>
			</div>
		</div>
	</body>
</html>