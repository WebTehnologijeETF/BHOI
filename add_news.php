<?php
function editInputData($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
	return $data;
}
$idvijesti = editInputData(htmlentities($_REQUEST['idvijesti']));
$ime = editInputData(htmlentities($_REQUEST['ime']));
$email = editInputData(htmlentities($_REQUEST['email']));
$komentar = editInputData(htmlentities($_REQUEST['komentar']));
if($ime == "")
	print "Ime nije ispravno!"
else
{
	try
	{
		$veza = new PDO("mysql:dbname=bhoi;host=localhost;charset=utf8", "bhoiuser", "pw123!");
	}
	catch(PDOException $exception)
	{
		print "Greška prilikom spajanja na bazu podataka";
	}
	$noviKomentar = $veza -> prepare("insert komentari set vijest = ?, imeAutora = ?, emailAutora = ?, tekst = ?;");
	$noviKomentar -> execute(array($idvijesti, $ime, $email, $komentar));
	if (!$noviKomentar) 
		print "Greška prilikom korištenja servisa!";
	else
		print "Komentar uspješno objavljen!";
}
?>

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
	$err1p = $err2p = $naslov = $slika = $uvodniTekst = $citavTekst = "";
	function editInputData($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
		return $data;
	}
	if(isset($_POST["objavi"]))
	{
		$err1p = $err2p = "";
		$naslov = editInputData($_POST["naslov"]);
		$slika = editInputData($_POST["slika"]);
		$uvodniTekst = editInputData($_POST["uvodniTekst"]);
		$citavTekst = editInputData($_POST["citavTekst"]);
		$valid = true;
		if($naslov == "")
		{
			$err1p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($uvodniTekst == "")
		{
			$err2p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($valid)
		{
			$korisnickoIme = $_SESSION['korisnickoIme'];
			$novaVijest = $veza -> prepare("insert into vijesti set naslov = ?, autor = ?, slika = ?, uvodniTekst = ?, citavTekst = ?;");
			$novaVijest -> execute(array($naslov, $korisnickoIme, $slika, $uvodniTekst, $citavTekst));
			if (!$novaVijest) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Novost uspješno objavljena!'); </script>"; 
		}
	}
	?>
	<body id="form_body">
		<div id="main_wrapper">
			<h1>Objavljivanje novosti</h1>
			<div id="form">
				<?php
					if (isset($_SESSION['korisnickoIme']))
					{
						print '<p>Polja označena sa * su obavezna</p>';
						print '<form method="post">';
						print "<p>Naslov: *</p><input type=\"text\" name=\"naslov\" value=\"$naslov\">$err1p";
						print "<p>Slika:</p><input type=\"text\" name=\"slika\" value=\"$slika\"><br><br>";
						print "<p>Uvodni tekst: *</p><textarea rows=\"10\" cols=\"80\" name=\"uvodniTekst\">$uvodniTekst</textarea>$err2p";
						print "<p>Čitav tekst:</p><textarea rows=\"10\" cols=\"80\" name=\"citavTekst\">$citavTekst</textarea>";
						print "<br><br><button name=\"objavi\" type=\"submit\">Objavi</button></form><br><br>";  
					}
					else
						print '<p style="color:red"><b>Greška! Najprije izvršite prijavu!</b></p>';
				?>
			</div>
		</div>
	</body>
</html>