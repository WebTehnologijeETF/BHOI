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
	$err1p = $username = $korisnickoImeKorisnika = $sifra = $email = "";
	function editInputData($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
		return $data;
	}
	if(isset($_GET['username']))
		$username = editInputData($_GET['username']);
	$korisnikKojegTrebaPromijeniti = $veza -> prepare("select korisnickoIme, email from korisnici where korisnickoIme = ?;");
	$korisnikKojegTrebaPromijeniti -> execute(array($username));
	foreach($korisnikKojegTrebaPromijeniti as $korisnik)
	{
		$korisnickoImeKorisnika = $korisnik['korisnickoIme'];
		$email = $korisnik['email'];
	}
	if(isset($_POST["promijeni"]))
	{
		$err1p = "";
		$korisnickoImeKorisnika = editInputData($_POST["korisnickoImeKorisnika"]);
		$sifra = editInputData($_POST["sifra"]);
		$email = editInputData($_POST["email"]);
		$valid = true;
		if($email == "")
		{
			$err1p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($valid)
		{
			$promijenjeniKorisnik;
			if($sifra != "")
			{
				$promijenjeniKorisnik = $veza -> prepare("update korisnici set sifra = md5(?), email = ? where korisnickoIme = ?;");
				$promijenjeniKorisnik -> execute(array($sifra, $email, $username));
			}
			else
			{
				$promijenjeniKorisnik = $veza -> prepare("update korisnici set email = ? where korisnickoIme = ?;");
				$promijenjeniKorisnik -> execute(array($email, $username));
			}
			if (!$promijenjeniKorisnik) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Korisnik uspješno promijenjen!'); </script>"; 
		}
	}
	?>
	<body id="form_body">
		<div id="main_wrapper">
			<h1>Promjena korisnika</h1>
			<div id="form">
				<?php
					if (isset($_SESSION['korisnickoIme']))
					{
						print '<p>Polja označena sa * su obavezna</p>';
						print "<p>Ukoliko u trenutku pritiska na dugme 'Dodaj' polje 'Šifra' bude prazno, korisnička šifra će ostati nepromijenjena</p>";
						print '<form method="post">';
						print "<p>Korisničko ime:</p><input type=\"text\" name=\"korisnickoImeKorisnika\" value=\"$korisnickoImeKorisnika\" readonly>";
						print "<p>Šifra:</p><input type=\"password\" name=\"sifra\">";
						print "<p>Email: *</p><input type=\"text\" name=\"email\" value=\"$email\">$err1p";
						print "<br><br><button name=\"promijeni\" type=\"submit\">Promijeni</button></form><br><br>";  
					}
					else
						print '<p style="color:red"><b>Greška! Najprije izvršite prijavu!</b></p>';
				?>
			</div>
		</div>
	</body>
</html>