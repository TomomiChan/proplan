<?php
/**
  * Das Dokument stellt die Anfrage zum Bearbeiten von Zeilen in der Datenbanktabelle Projekt
  * @author Christoph Suhr
  */
session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.php");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$benutzer_id = $_SESSION['id'];
		
		include ("datenbankschnittstelle.php");
		datenbankaufbau();
		
		if(isset($_POST['nameaendern'])){			//steht was in Nameaendern
					
			$neuerName = $_POST['projektname'];
			//$neuertext = stripcslashes($neuertext);
			//$neuerName = mysql_real_escape_string($neuerName);
		
			$projektID = $_POST['nameaendern'];
			//$terminID = stripcslashes($terminID);
			//$projektID = mysql_real_escape_string($projektID);
		
			if(strlen($neuerName)> 100){
				$neuerName = substr($neuerName, 0, 100);
			}

			$rueckgabe = getORSetEintraegeSchleifen("UPDATE projekt SET name = '$neuerName' WHERE projekt_id = '$projektID'");

			header("location:projektseite.php?projekt_id=$projektID");
		}
		if(isset($_POST['beginnaendern'])){		//steht was in beginnaendern
		
			$pBeginnJahr = $_POST['beginnJahr'];
			$pBeginnMonat = $_POST['beginnMonat'];
			$pBeginnTag = $_POST['beginnTag'];
			//$pBeginnJahr = mysql_real_escape_string($pBeginnJahr);
			//$pBeginnMonat = mysql_real_escape_string($pBeginnMonat);
			//$pBeginnTag = mysql_real_escape_string($pBeginnTag);
			
			$neurBeginn = $pBeginnJahr . "-" . $pBeginnMonat . "-" . $pBeginnTag;

			$neurBeginn = date('Y-m-d',strtotime($neurBeginn));	//um auf nummersicher zu gehen in das Dateformat umwandeln

			$projektID = $_POST['beginnaendern'];
			//$terminID = stripcslashes($terminID);
			//$projektID = mysql_real_escape_string($projektID);
			
			$rueckgabe = getORSetEintraegeSchleifen("UPDATE projekt SET beginn_projekt = '$neurBeginn' WHERE projekt_id = '$projektID'");

			header("location:projektseite.php?projekt_id=$projektID");
		}
		if(isset($_POST['endeaendern'])){	//steht was in endeaendern
			$pEndeJahr = $_POST['endeJahr'];
			$pEndeMonat = $_POST['endeMonat'];
			$pEndeTag = $_POST['endeTag'];
			//$pEndeJahr = mysql_real_escape_string($pEndeJahr);
			//$pEndeMonat = mysql_real_escape_string($pEndeMonat);
			//$pEndeTag = mysql_real_escape_string($pEndeTag);
			
			$neuesEnde = $pEndeJahr . "-" . $pEndeMonat . "-" . $pEndeTag;

			$neuesEnde = date('Y-m-d',strtotime($neuesEnde)); //um auf nummersicher zu gehen in das Dateformat umwandeln

			$projektID = $_POST['endeaendern'];
			//$terminID = stripcslashes($terminID);
			//$projektID = mysql_real_escape_string($projektID);
			
			$rueckgabe = getORSetEintraegeSchleifen("UPDATE projekt SET ende_projekt = '$neuesEnde' WHERE projekt_id = '$projektID'");

			header("location:projektseite.php?projekt_id=$projektID");
		}
		if(isset($_POST['nutzerhinzufuegen'])){		//steht was in nutzerhinzufuegen
			$projektID = $_POST['nutzerhinzufuegen'];
			//$terminID = stripcslashes($terminID);
			//$projektID = mysql_real_escape_string($projektID);
			$emails = $_POST['textareanutzerhinzufuegen'];
			$emails = str_replace(' ','',$emails); 			//Leerzeichen aus dem String werden entfernt
			$arrayEmails = explode(',',$emails);			//der String wird an den Kommas aufgebrochen und in ein Array gepackt, um die Emails einzelnd ansprechen zu koennen
			for ($i=0; $i < count($arrayEmails);$i++){		//Geht die Emails durch
				$user_ref = getORSetEintraege("SELECT user_id FROM user WHERE email = '$arrayEmails[$i]'");	//Holt sich die Nutzer ID zur Email
				$schon_vorhanden = getORSetEintraegeSchleifen("SELECT * FROM user_projekte WHERE user_ref = '$user_ref[0]' AND projekt_ref = '$projektID'");	//Guckt ob der Nutzer schon im Projekt vorhanden ist
				if($user_ref=="" or mysqli_num_rows($schon_vorhanden) != 0){	//Wenn es gar keine ID zur Email gibt, oder der Nutzer schon im Projekt ist, passiert einfach nichts
				}else{	
					$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO user_projekte (user_ref, projekt_ref) VALUES ('$user_ref[0]','$projektID')");		//ansonsten wird er dem projekt zugeordnet
				}
			}
			header("location:projektseite.php?projekt_id=$projektID");
		}
		if(isset($_POST['projektentfernen'])){	//steht was in projektentfernen
			$projektID = $_POST['projektentfernen'];
			//$terminID = stripcslashes($terminID);
			//$projektID = mysql_real_escape_string($projektID);
			$projektErsteller = getORSetEintraege("SELECT ersteller_ref FROM projekt WHERE projekt_id = '$projektID'");		//Guckt wer Projekt ersteller ist
			if($projektErsteller[0]==$benutzer_id){	//Wenn Projektersteller mit der ID die das Projekt loeschen will ueberinstimmt ...Ab hier muss man aufpassen, das man jeden Eintrag in der Datenbank loescht, der mit dem Projekt zu tun hat, bevor man das Projekt selbst aus der Datenbank loescht
				$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM user_projekte WHERE projekt_ref = '$projektID'");		//Loescht alle aus der Referenztabelle die mit dem projekt zu tun haben
				$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM to_do WHERE projekt_ref = '$projektID'");				//Loescht alle ToDos vom Projekt
				$result = getORSetEintraegeSchleifen("SELECT thema_id FROM thema WHERE projekt_ref = '$projektID'");		//holt sich alle Themen ids
				$j = 0;
				while($row = $result->fetch_array(MYSQLI_BOTH)){		//Muss alle Themen IDs durch gehen 
					$themaID[$j] = $row['thema_id'];	
					$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM beitrag WHERE thema_ref = '$themaID[$j]'");	//Um jeden Beitrag zu allen Themen zu loeschen
					$j++;
				}	
				$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM thema WHERE projekt_ref = '$projektID'");			//Danach kann man alle themen mit der Projektreferenz loeschen
				$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM termin WHERE projekt_ref = '$projektID'");			//Termin mit Projektreferenz loeschen
				$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM projekt WHERE projekt_id = '$projektID'");			//Als letztes das Projekt selbst
			}else {
				$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM user_projekte WHERE user_ref = '$benutzer_id' AND projekt_ref = '$projektID'");	//Wenn die Anfrage nicht vom ersteller kommt, wird nur die Referenz auf das Projekt geloescht
			}
			
			header("location:meineProjekte.php");
		}
		
		//header("location:projektseite.php?projekt_id=$projektID");
	}	
		
?>