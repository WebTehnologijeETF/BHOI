<!DOCTYPE HTML SYSTEM>
<html>
	<head>
		<meta http-equiv="ContentType" content="text/html; charset=utf-8">
		<title>BHOI - Oficijelna stranica</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css">
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	</head>
	<?php
	define('CHARSET', 'UTF-8');
	$veza = new PDO("mysql:dbname=bhoi;host=localhost;charset=utf8", "bhoiuser", "pw123!");
	$veza -> exec("set names utf8");
	$err1p = $err2p = $id = $ime = $email = $komentar = "";
	function editInputData($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
		return $data;
	}
	if(isset($_POST["posalji"]))
	{
		$err1p = $err2p = "";
		$ime = editInputData($_POST["ime"]);
		$email = editInputData($_POST["email"]);
		$komentar = editInputData($_POST["komentar"]);
		if(isset($_GET['id']))
			$id = editInputData($_GET['id']);
		$valid = true;
		if($ime == "")
		{
			$err1p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($komentar == "")
		{
			$err2p = '<img src="images/error.png" class="error2" style="display: inline;" title="Polje je prazno">';
			$valid = false;
		}
		if($valid)
		{
			$noviKomentar = $veza -> prepare("insert komentari set vijest = ?, imeAutora = ?, emailAutora = ?, tekst = ?;");
			$noviKomentar -> execute(array($id, $ime, $email, $komentar));
			if (!$noviKomentar) 
			{
				$greska = $veza -> errorInfo();
				print "SQL greška: " . $greska[2];
				exit();
			}
			else
				print "<script> alert('Komentar uspješno objavljen!'); </script>"; 
		}
	}
	?>
	<body id="form_body">
		<div id="main_wrapper">
			<h1>Ostavite komentar</h1>
			<div id="form">
				<p>Polja označena sa * su obavezna</p>
				<form method="post">
				<p>Ime: *</p><input type="text" name="ime" value="<?php print $ime; ?>"><?php print $err1p; ?><br><br>
				<p>Email:</p><input type="text" name="email" value="<?php print $email; ?>"><br><br>
				<p>Tekst komentara: *</p><textarea rows="10" cols="80" name="komentar"><?php print $komentar; ?></textarea><?php print $err2p; ?>
				<br><br><button name="posalji" type="submit">Pošalji</button></form>  		  
				<br>
				<br>
			</div>
		</div>
	</body>
</html>