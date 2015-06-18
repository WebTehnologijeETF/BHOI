<?php
define('CHARSET', 'UTF-8');
$a = '<?php $_GET["id"];?>';
$veza = new PDO("mysql:dbname=bhoi;host=localhost;charset=utf8", "bhoiuser", "pw123!");
$veza -> exec("set names utf8");
if(isset($_GET['id']))
{
	$id = $_GET['id'];
	$vijest_ = $veza -> prepare("select v.naslov naslov1, v.autor autor1, v.slika slika1, v.uvodniTekst uvodniTekst1, v.citavTekst citavTekst1, UNIX_TIMESTAMP(v.vrijemeObjave) vrijemeObjave1 from vijesti v where v.id = ?;");
	$vijest_ -> execute(array($id));
	foreach($vijest_ as $vijest)
	{
		$naslov = $vijest['naslov1'][0].mb_strtolower(substr($vijest['naslov1'], 1));
		$autor = $vijest['autor1'];
		$slika = $vijest['slika1'];
		$uvodniTekst = $vijest['uvodniTekst1'];
		$citavTekst = $vijest['citavTekst1'];
		$vrijemeObjave = date("d.m.Y. H:i", $vijest['vrijemeObjave1']);
		print '<div id="read_news">';
		print '<h1 class="title">'.$naslov.'</h1>';
		print '<h4 class="author">'.$autor.' @ '.$vrijemeObjave.'</h4><br><br>';
		if($slika != "")
			print '<br><br><br><img src="'.$slika.'" class="cover" alt=""><br><br>';
		else
			print '<br><br><br>';
		print '<p class="text">';
		print $uvodniTekst.'<br>';
		print '</p><hr><p class="text">';
		print $citavTekst.'<br><br>';
		print '</p>';
		$dobavljeniBrojKomentara = $veza -> prepare("select count(*) from komentari k where k.vijest = ?;");
		$dobavljeniBrojKomentara -> execute(array($id));
		if (!$dobavljeniBrojKomentara) 
		{
			$greska = $veza -> errorInfo();
			print "SQL greška: " . $greska[2];
			exit();
		}
		$brojKomentara = $dobavljeniBrojKomentara -> fetchColumn();
		$dobavljeniKomentari = $veza -> prepare("select k.imeAutora imeAutora1, k.emailAutora emailAutora1, k.tekst tekst1, UNIX_TIMESTAMP(k.vrijemeObjave) vrijemeObjave1 from komentari k where k.vijest = ? order by vrijemeObjave1 asc;");
		$dobavljeniKomentari -> execute(array($id));
		if (!$dobavljeniKomentari) 
		{
			$greska = $veza -> errorInfo();
			print "SQL greška: " . $greska[2];
			exit();
		}
		print "<a class=\"comments\" onclick='showComments(this)'>+ Komentari (Ukupno: $brojKomentara)</a>";
		print '<div id="comments" style="display: none;">';
		foreach($dobavljeniKomentari as $komentar)
		{
			$vrijemeObjaveKomentara = date("d.m.Y. H:i", $komentar['vrijemeObjave1']);
			$imeAutora = $komentar['imeAutora1'];
			$emailAutora = $komentar['emailAutora1'];
			$tekstKomentara = $komentar['tekst1'];
			print "<br><p><b>Vrijeme objave:</b> $vrijemeObjaveKomentara</p>";
			print "<p><b>Autor:</b> $imeAutora</p>";
			if($emailAutora != "")
				print "<p><b>Email:</b> <a href=\"mailto:$emailAutora\">$emailAutora</a></p>";
			print "<p><b>Komentar:</b> $tekstKomentara</p>";
		}
		print '</div>';
		print "<br><a target=\"_blank\" href=\"add_comment.php?id=$id\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"images/add.png\"></a><br><br>";
		print '</div>';
	}
}
else
{
	$dobavljeneVijesti = $veza -> query("select v.id id1, v.naslov naslov1, v.autor autor1, v.slika slika1, v.uvodniTekst uvodniTekst1, v.citavTekst citavTekst1, UNIX_TIMESTAMP(v.vrijemeObjave) vrijemeObjave1 from vijesti v order by vrijemeObjave1 desc;");
	if (!$dobavljeneVijesti) 
	{
		$greska = $veza -> errorInfo();
		print "SQL greška: " . $greska[2];
		exit();
	}
	print '<h1>Posljednje vijesti</h1><div id="news"><table>';
	$k = 0;
	foreach ($dobavljeneVijesti as $vijest_) 
	{
		$id = $vijest_['id1'];
		$naslov = $vijest_['naslov1'][0].mb_strtolower(substr($vijest_['naslov1'], 1));
		$autor = $vijest_['autor1'];
		$slika = $vijest_['slika1'];
		$uvodniTekst = $vijest_['uvodniTekst1'];
		$citavTekst = $vijest_['citavTekst1'];
		$vrijemeObjave = date("d.m.Y. H:i", $vijest_['vrijemeObjave1']);
		if($k % 2 == 0)
			print '<tr>';
		print '<td valign="top">';
		print '<h2 class="title">'.$naslov.'</h2>';
		print '<h3 class="author">'.$autor.' @ '.$vrijemeObjave.'</h3><br>';
		if($slika != "")
			print '<br><br><img src="'.$slika.'" alt=""><br><br>';
		else
			print '<br><br>';
		print '<p class="text">';
		print $uvodniTekst.'<br>';
		print '</p>';
		print "<a class=\"more\" onclick='readNews(".$id.")'>Opširnije</a>";
		print '</td>';
		if($k % 2 != 0)
			print '</tr>';
		$k++;
	}
	print '</table></div>';	
}		
?>