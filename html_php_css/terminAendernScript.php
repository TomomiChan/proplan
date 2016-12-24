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
		
		
		$neuertext = $_POST['textareatermin'];
		//$neuertext = stripcslashes($neuertext);
		$neuertext = mysql_real_escape_string($neuertext);
		
		$neueUhrzeit = $_POST['uhrzeit'];
		//$neuertext = stripcslashes($neuertext);
		$neueUhrzeit = mysql_real_escape_string($neueUhrzeit);
		$neueUhrzeit = date('H:i:s',strtotime($neueUhrzeit));
		
		
		$terminID = $_POST['terminAendern'];
		//$terminID = stripcslashes($terminID);
		$terminID = mysql_real_escape_string($terminID);
		
		if(strlen($neuertext)> 100){
			$neuertext = substr($neuertext, 0, 100);
		}
		
		echo $neueUhrzeit;
		
		$rueckgabe = getORSetEintraegeSchleifen("UPDATE termin SET termin_name = '$neuertext' WHERE termin_id = '$terminID'");
		$rueckgabe = getORSetEintraegeSchleifen("UPDATE termin SET uhrzeit = '$neueUhrzeit' WHERE termin_id = '$terminID'");
		$projekt_id = getORSetEintraege("SELECT projekt_ref FROM termin WHERE termin_id = '$terminID'");
		$projekt_id = $projekt_id['projekt_ref'];
		header("location:projektseite.php?projekt_id=$projekt_id");
	}	
		
?>