<?php
session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.php");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$benutzer_id = $_SESSION['id'];
		
		//Verbinung zu Datenbank
		include ("datenbankschnittstelle.php");
		datenbankaufbau(); 
		
		if(isset($_POST['terminLoeschen'])){
			$loeschen = $_POST['terminLoeschen'];			//ID des jeweiligen Termins
			//$loeschen = stripcslashes($loeschen);
			//$loeschen = mysql_real_escape_string($loeschen);
			
			$projekt_id = getORSetEintraege("select projekt_ref from termin WHERE termin_id = '$loeschen'");
			$projekt_id = $projekt_id['projekt_ref'];
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM termin WHERE termin_id = '$loeschen'");
			
			header("location:projektseite.php?projekt_id=$projekt_id");
		}
		
		if(isset($_POST['terminAendern'])){
		
			$neuertext = $_POST['textareatermin'];
			//$neuertext = stripcslashes($neuertext);
			//$neuertext = mysql_real_escape_string($neuertext);
		
			$stundeUhrzeit = $_POST['uhrzeit_stunde'];
			$minuteUhrzeit = $_POST['uhrzeit_minute'];
			/*$stundeUhrzeit = mysql_real_escape_string($stundeUhrzeit);
			$minuteUhrzeit = mysql_real_escape_string($minuteUhrzeit);*/

			$neueUhrzeit = $stundeUhrzeit . ":" . $minuteUhrzeit;


			$neueUhrzeit = date('H:i:s',strtotime($neueUhrzeit));
		
		
			$terminID = $_POST['terminAendern'];
			//$terminID = stripcslashes($terminID);
			//$terminID = mysql_real_escape_string($terminID);
		
			if(strlen($neuertext)> 100){
				$neuertext = substr($neuertext, 0, 100);
			}
		
		
			$rueckgabe = getORSetEintraegeSchleifen("UPDATE termin SET termin_name = '$neuertext' WHERE termin_id = '$terminID'");
			$rueckgabe = getORSetEintraegeSchleifen("UPDATE termin SET uhrzeit = '$neueUhrzeit' WHERE termin_id = '$terminID'");
			$projekt_id = getORSetEintraege("SELECT projekt_ref FROM termin WHERE termin_id = '$terminID'");
			$projekt_id = $projekt_id['projekt_ref'];
			header("location:projektseite.php?projekt_id=$projekt_id");
		}
	}	
		
?>