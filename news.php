<?php
    function cmp($f1, $f2)
    {
    	  $f1Lines = $f2Lines = "0000-00-00 00:00:00";
        $file_stream = fopen($f1, "r"); 
			  if ($file_stream) 
			  {
            $f1Lines = file($f1, FILE_IGNORE_NEW_LINES);
            fclose($file_stream);
        }
        $file_stream = fopen($f2, "r"); 
        if ($file_stream) 
			  {
            $f2Lines = file($f2, FILE_IGNORE_NEW_LINES);
            fclose($file_stream);
        }
        $d1 = $f1Lines[0][9].$f1Lines[0][10].$f1Lines[0][11].$f1Lines[0][12].'-'.$f1Lines[0][6].$f1Lines[0][7].'-'.$f1Lines[0][3].$f1Lines[0][4].' '.$f1Lines[0][15].$f1Lines[0][16].$f1Lines[0][17].$f1Lines[0][18].$f1Lines[0][19].$f1Lines[0][20].$f1Lines[0][21].$f1Lines[0][22];
        $d2 = $f2Lines[0][9].$f2Lines[0][10].$f2Lines[0][11].$f2Lines[0][12].'-'.$f2Lines[0][6].$f2Lines[0][7].'-'.$f2Lines[0][3].$f2Lines[0][4].' '.$f2Lines[0][15].$f2Lines[0][16].$f2Lines[0][17].$f2Lines[0][18].$f2Lines[0][19].$f2Lines[0][20].$f2Lines[0][21].$f2Lines[0][22];
        return strtotime($d2) - strtotime($d1);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST')
	  {
		    $vijest = json_decode($_POST["vijest"], true);
        echo '<div id="read_news">';
		    echo '<h1 class="title">'.$vijest["naslov"].'</h1>';
        echo '<h4 class="author">'.$vijest["autor"].' @ '.$vijest["datum"].'</h4><br><br>';
        if($vijest["slika"] != "")
		        echo '<br><br><br><img src="'.$vijest["slika"].'" class="cover" alt=""><br><br>';
        else
            echo '<br><br><br>';
        echo '<p class="text">';
        echo $vijest["osnovno"].'<br>';
        echo '</p><hr><p class="text">';
        echo $vijest["opsirno"].'<br><br>';
        echo '</p>';
        echo '</div>';
	  }
	  else
	  {
		    $allFiles = array();
        foreach (glob("novosti/*.txt") as $file)
        {
            array_push($allFiles, $file);
        }
        usort($allFiles, "cmp");
        $k = 0;
        echo '<h1>Posljednje vijesti</h1><div id="news"><table>';
		    foreach ($allFiles as $file) 
		    {
			      $file_stream = fopen($file, "r"); 
			      if ($file_stream) 
			      {
				        $lines = file($file, FILE_IGNORE_NEW_LINES);
				        fclose($file_stream);
				        $datum = $lines[0];
				        $autor = $lines[1];
				        $naslov = $lines[2][0].mb_strtolower(substr($lines[2],1));
				        $slika = $lines[3];
				        $osnovno = "";
				        $opsirnije = false;
				        $opsirno = "";
				        for($i = 4; $i < count($lines); $i++)
				        {
					          if($lines[$i] == '--') 
					          {
						            $opsirnije = true;
						            continue;
					          }		
					          if(!$opsirnije) 
						            $osnovno = $osnovno.' '.$lines[$i];
					          else 
						            $opsirno = $opsirno.' '.$lines[$i];
				        }
                if($k % 2 == 0)
                    echo '<tr>';
                echo '<td valign="top">';
                echo '<h2 class="title">'.$naslov.'</h2>';
                echo '<h3 class="author">'.$autor.' @ '.$datum.'</h3><br>';
                if($slika != "")
		                echo '<br><br><img src="'.$slika.'" alt=""><br><br>';
                else
                    echo '<br><br>';
                echo '<p class="text">';
                echo $osnovno.'<br>';
                echo '</p>';
                if($opsirnije) 
					      {
						        $vijest = json_encode(array("datum"=>$datum, "autor"=>$autor, "naslov"=>$naslov, "slika"=>$slika, "osnovno"=>$osnovno, "opsirno"=>$opsirno));
						        echo "<a class=\"more\" onclick='readNews(".$vijest.")'>Opširnije</a>";
					      }	
                else
                    echo '<br><br>';
                echo '</td>';
                if($k % 2 != 0)
                    echo '</tr>';
                $k++;
				    }
			  }
        echo '</table></div>';
    }		
?>