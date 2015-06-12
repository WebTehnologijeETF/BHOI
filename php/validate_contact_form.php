<?php
define('CHARSET', 'UTF-8');
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
$imePrezime = editInputData(htmlentities($_REQUEST['imePrezime']));
$email = editInputData(htmlentities($_REQUEST['email']));
$website = editInputData(htmlentities($_REQUEST['website']));
$poruka = editInputData(htmlentities($_REQUEST['poruka']));
if(!validateName($imePrezime))
	print "0";
else
	print "1";
if(!preg_match("/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]/i", $email))
	print "0";
else
	print "1";
if(!preg_match("/^(www)+\.[A-Z0-9.-]+\.[A-Z]/i", $website) && $website != "?")
	print "0";
else
	print "1";
if($poruka == "")
	print "0";
else
	print "1";
?>