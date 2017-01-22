<?php
/**
  * Das Dokument stellt die Anfrage zum Updaten von Zeilen aus der Datenbanktabelle Beitrag
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
		
		//Verbinung zu Datenbank
		include ("datenbankschnittstelle.php");
		datenbankaufbau(); 
		
		
		$neuertext = $_POST['textareaforum'];
		//$neuertext = stripcslashes($neuertext);
		//$neuertext = mysql_real_escape_string($neuertext);
		
		$beitragID = $_POST['forumBeitragBearbeiten'];
		//$terminID = stripcslashes($terminID);
	//	$beitragID = mysql_real_escape_string($beitragID);
		
		$bearbeitet = getORSetEintraege("SELECT bearbeitet FROM beitrag WHERE beitrag_id = '$beitragID'");		//Auf was steht der bearbeiten Zaehler in der Datenbank
		$bearbeitet[0] +=1;																						//Zaehle ihn um eins hoch
		
		$tag = time();
		$tag = date('Y-m-d H:i:s',$tag);
		
		$themaID = getORSetEintraege("SELECT thema_ref FROM beitrag WHERE beitrag_id = '$beitragID'");
		
		//echo "$neuertext <br> $bearbeitet[0] <br> $tag <br> $beitragID";
		$rueckgabe = getORSetEintraegeSchleifen("UPDATE beitrag SET beitrag_text = '$neuertext', bearbeitet = '$bearbeitet[0]', bearbeitet_datum = '$tag'  WHERE beitrag_id = '$beitragID'");
		
		header("location:forum.php?thema=$themaID[0]");
	}
		
		
?>