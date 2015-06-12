<?php
define('CHARSET', 'UTF-8');
function editInputData($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_SUBSTITUTE, CHARSET);
	return $data;
}
$emailAdresa = editInputData(htmlentities($_REQUEST['email']));
$poruka = editInputData(htmlentities($_REQUEST['poruka']));
require("sendgrid-php/sendgrid-php.php");
$service_plan_id = "sendgrid_56d99";
$account_info = json_decode(getenv($service_plan_id), true);
$sendgrid = new SendGrid("amehanovic1", "woot123.");
$email = new SendGrid\Email();
$email->addTo("amehanovic1@etf.unsa.ba")->addCc("vljubovic@etf.unsa.ba")->setFrom($emailAdresa)->setSubject("BHOI - Kontakt obrazac")->setText($poruka);
$sendgrid->send($email);
print "Zahvaljujemo se što ste nas kontaktirali!";
?>