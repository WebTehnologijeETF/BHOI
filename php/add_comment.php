<?php
define('CHARSET', 'UTF-8');
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
if($ime == "" && $komentar == "")
	print "Err1";
else if($ime == "")
	print "Err2";
else if($komentar == "")
	print "Err3";
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