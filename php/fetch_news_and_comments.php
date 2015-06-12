<?php
define('CHARSET', 'UTF-8');
function editInputData($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
	return $data;
}
try
{
	$veza = new PDO("mysql:dbname=bhoi;host=localhost;charset=utf8", "bhoiuser", "pw123!");
}
catch(PDOException $exception)
{
	print "Greška prilikom spajanja na bazu podataka";
}
$upit1 = $veza -> query("select * from vijesti order by vrijemeObjave desc;");
$upit2 = $veza -> query("select * from komentari order by vrijemeObjave asc;");
if(!$upit1 || !$upit2)
	print "Greška prilikom korištenja servisa";
else
	print "{\"vijesti\":".json_encode($upit1 -> fetchAll()).",\"komentari\":".json_encode($upit2 -> fetchAll())."}";
?>