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
session_start();
define('CHARSET', 'UTF-8');
$veza = new PDO("mysql:dbname=bhoi;host=localhost;charset=utf8", "bhoiuser", "pw123!");
$veza -> exec("set names utf8");
$korisnickoIme = $greska1 = $greska2 = $uspjeh1 = "";
function editInputData($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
	return $data;
}
function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, 35)];
	}
	return $randomString;
}
if(isset($_POST["odjava"]))
{ 
	session_unset();
}
if(isset($_POST["prijava"]))
{
	$korisnickoIme = editInputData($_POST["korisnickoIme"]);
	$sifra = editInputData($_POST["sifra"]);
	$prijava = $veza -> prepare("select * from korisnici where korisnickoIme = ? and sifra = md5(?);");
	$prijava -> execute(array($korisnickoIme, $sifra));
	$rezultat = $prijava -> fetch(PDO::FETCH_ASSOC);
	if($rezultat)
		$_SESSION['korisnickoIme'] = $korisnickoIme;
	else
		$greska1 = '<p style="color:red"><b>Pogrešni podaci za prijavu!</b></p>';
}
if(isset($_POST["reset"]))
{
	$emailZaSlanje = "";
	$korisnickoIme = editInputData($_POST["korisnickoIme"]);
	$reset1 = $veza -> prepare("select email from korisnici where korisnickoIme = ?;");
	$reset1 -> execute(array($korisnickoIme));
	foreach ($reset1 as $korisnikZaReset)
		$emailZaSlanje = $korisnikZaReset['email'];
	if($emailZaSlanje != "")
	{
		$novaSifra = generateRandomString();
		$reset2 = $veza -> prepare("update korisnici set sifra = md5(?) where korisnickoIme = ?;");
		$reset2 -> execute(array($novaSifra, $korisnickoIme));
		if (!$reset2) 
		{
			$greska = $veza -> errorInfo();
			print "SQL greška: " . $greska[2];
			exit();
		}
		else
		{
			//Nije realizovano slanje nove šifre na email korisnika. Rješenje koje ne koristi Sendgrid ne radi (nije ga moguce testirati).

			/*require("sendgrid-php/sendgrid-php.php");
			$service_plan_id = "sendgrid_56d99";
			$account_info = json_decode(getenv($service_plan_id), true);
			$sendgrid = new SendGrid("amehanovic1", "woot123.");
			$email = new SendGrid\Email();
			$email->addTo("$emailZaSlanje")->setFrom("administrator@bhoi.net")->setSubject("BHOI - Resetovana šifra")->setText("Nova šifra: $novaSifra");
			$sendgrid->send($email);*/
			
			$uspjeh1 = '<p style="color:green"><b>Šifra uspješno resetovana i poslana na email!</b></p>';
		}	
	}
	else
		$greska2 = '<p style="color:red"><b>Korisnik s unešenim korisničkim imenom ne postoji!</b></p>';
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
		<h1>Administracija</h1>
		<div id="admin">
		</p>
		<?php
		if (isset($_POST['obrisiNovost']))
		{
			$idvijesti = $_POST["idn"];
			$brisanjeVijesti = $veza -> prepare("delete from vijesti where id = ?;");
			$brisanjeVijesti -> execute(array($idvijesti));
			if (!$brisanjeVijesti) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Novost uspješno obrisana!'); </script>"; 
		}
		if (isset($_POST['obrisiKorisnika']))
		{
			$korisnickoImeKorisnika = $_POST["un"];
			$brisanjeKorisnika = $veza -> prepare("delete from korisnici where korisnickoIme = ?;");
			$brisanjeKorisnika -> execute(array($korisnickoImeKorisnika));
			if (!$brisanjeKorisnika) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Korisnik uspješno obrisan!'); </script>"; 
		}
		if (isset($_SESSION['korisnickoIme']))
		{
			$korisnickoIme = $_SESSION['korisnickoIme'];
			print "<div style=\"float: right;\"><form method=\"post\"><p>Prijavljeni ste kao $korisnickoIme".'</p><button style="float: right;" name="odjava" type="submit">Odjava</button></form></div>';
			print '<br><br>';
			print "<h4>Upravljanje novostima</h4><br><a target=\"_blank\" href=\"add_news.php\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"images/add.png\"></a>";
			$dobavljeneVijesti = $veza -> query("select v.id id1, v.naslov naslov1, v.autor autor1, UNIX_TIMESTAMP(v.vrijemeObjave) vrijemeObjave1 from vijesti v order by vrijemeObjave1 desc;");
			if (!$dobavljeneVijesti) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
			{
				print '<table>';
				print '<tr><th>ID</th><th>Naslov</th><th>Autor</th><th>Vrijeme objave</th><th>Opcije</th></tr>';
				foreach ($dobavljeneVijesti as $vijest) 
				{
					$id = $vijest['id1'];
					$naslov = $vijest['naslov1'];
					$autor = $vijest['autor1'];
					$vrijemeObjave = date("d.m.Y. H:i", $vijest['vrijemeObjave1']);
					print "<tr><td>$id</td><td>$naslov</td><td>$autor</td><td>$vrijemeObjave</td><td><a target=\"_blank\" href=\"edit_news.php?id=$id\"><button type=\"submit\">Promijeni</button></a><form method=\"post\"><input type=\"hidden\" name=\"idn\" value=\"$id\"><button name=\"obrisiNovost\" type=\"submit\">Obriši</button></form></td></tr>";
				}
				print '</table>';
			}
			print "<br><br><h4>Upravljanje korisnicima</h4><br><a target=\"_blank\" href=\"add_user.php\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"images/add.png\"></a>";
			$dobavljeniKorisnici = $veza -> query("select k.korisnickoIme korisnickoIme1, k.email email1 from korisnici k;");
			if (!$dobavljeniKorisnici) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
			{
				print '<table>';
				print '<tr><th>Korisničko ime</th><th>Email</th><th>Opcije</th></tr>';
				foreach ($dobavljeniKorisnici as $korisnik) 
				{
					$korisnickoImeKorisnika = $korisnik['korisnickoIme1'];
					$email = $korisnik['email1'];
					$delete = "";
					if($korisnickoIme != $korisnickoImeKorisnika)
						$delete = "<form method=\"post\"><input type=\"hidden\" name=\"un\" value=\"$korisnickoImeKorisnika\"><button name=\"obrisiKorisnika\" type=\"submit\">Obriši</button></form>";
					print "<tr><td>$korisnickoImeKorisnika</td><td>$email</td><td><a target=\"_blank\" href=\"edit_user.php?username=$korisnickoImeKorisnika\"><button type=\"submit\">Promijeni</button></a>".$delete."</td></tr>";
				}
				print '</table>';
			}
		}
		else
		{
			print "<form method=\"post\" style=\"display: block; margin-left: auto; margin-right: auto;\">";
			print '<p>Korisničko ime:<br><input type="text" name="korisnickoIme">';
			print '<br><br>Šifra:<br><input type="password" name="sifra"><br><br><button name="prijava" type="submit">Prijavi me</button><button name="reset" type="submit">Resetuj&nbsp;šifru</button></p></form>';
			print "$greska1$greska2$uspjeh1";
		}
		?>
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