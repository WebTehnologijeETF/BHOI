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
	$err1p = $err2p = $id = $naslov = $slika = $uvodniTekst = $citavTekst = "";
	function editInputData($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
		return $data;
	}
	if(isset($_GET['id']))
		$id = editInputData($_GET['id']);
	$vijestKojuTrebaPromijeniti = $veza -> prepare("select naslov, slika, uvodniTekst, citavTekst from vijesti where id = ?;");
	$vijestKojuTrebaPromijeniti -> execute(array($id));
	foreach($vijestKojuTrebaPromijeniti as $vijest)
	{
		$naslov = $vijest['naslov'];
		$slika = $vijest['slika'];
		$uvodniTekst = $vijest['uvodniTekst'];
		$citavTekst = $vijest['citavTekst'];
	}
	if(isset($_POST["promijeni"]))
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
			$promijenjenaVijest = $veza -> prepare("update vijesti set naslov = ?, slika = ?, uvodniTekst = ?, citavTekst = ? where id = ?;");
			$promijenjenaVijest -> execute(array($naslov, $slika, $uvodniTekst, $citavTekst, $id));
			if (!$promijenjenaVijest) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Novost uspješno promijenjena!'); </script>"; 
		}
	}
	if (isset($_POST['obrisi']))
	{
		$idkomentara = $_POST["idk"];
		$brisanjeKomentara = $veza -> prepare("delete from komentari where id = ?;");
		$brisanjeKomentara -> execute(array($idkomentara));
		if (!$brisanjeKomentara) 
		{
			$greska = $veza -> errorInfo();
			print "SQL greška: " . $greska[2];
			exit();
		}
		else
			print "<script> alert('Komentar uspješno obrisan!'); </script>"; 
	}
	?>
	<body id="form_body">
		<div id="main_wrapper">
			<h1>Promjena novosti</h1>
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
						print "<br><br><button name=\"promijeni\" type=\"submit\">Promijeni</button></form><br><br>";
						print "<h4>Upravljanje komentarima</h4><br>";
						$dobavljeniKomentari = $veza -> prepare("select id, imeAutora, emailAutora, tekst, UNIX_TIMESTAMP(vrijemeObjave) vrijemeObjave1 from komentari where vijest = ? order by vrijemeObjave1 desc;");
						$dobavljeniKomentari -> execute(array($id));
						if (!$dobavljeniKomentari) 
						{
							$greska = $veza -> errorInfo();
							print "SQL greška: " . $greska[2];
							exit();
						}
						else
						{
							print '<table>';
							print '<tr><th>Ime autora</th><th>Email autora</th><th>Tekst komentara</th><th>Vrijeme objave</th><th>Opcije</th></tr>';
							foreach ($dobavljeniKomentari as $komentar) 
							{
								$idkomentara = $komentar['id'];
								$imeAutora = $komentar['imeAutora'];
								$emailAutora = $komentar['emailAutora'];
								$tekst = $komentar['tekst'];
								$vrijemeObjave = date("d.m.Y. H:i", $komentar['vrijemeObjave1']);
								print "<tr><td>$imeAutora</td><td>$emailAutora</td><td>$tekst</td><td>$vrijemeObjave</td><td><form method=\"post\"><input type=\"hidden\" name=\"idk\" value=\"$idkomentara\"><button name=\"obrisi\" type=\"submit\">Obriši</button></form></td></tr>";
							}
							print '</table><br><br>';
						}
					}
					else
						print '<p style="color:red"><b>Greška! Najprije izvršite prijavu!</b></p>';
				?>
			</div>
		</div>
	</body>
</html>