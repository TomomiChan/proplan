<?php
/**
  * Das Dokument stellt die Anfrage zum Loeschen von Zeilen aus der Datenbanktabelle Beitrag
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
		
		if(isset($_POST['beitragLoeschen'])){		//Nur ein einzelner Beitrag wird aus dem Thema geloescht
			$loeschen = $_POST['beitragLoeschen'];			
			//$loeschen = stripcslashes($loeschen);
		//	$loeschen = mysql_real_escape_string($loeschen);
			
			$themaID = getORSetEintraege("SELECT thema_ref FROM beitrag WHERE beitrag_id = '$loeschen'");
			$themaID = $themaID['thema_ref'];
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM beitrag WHERE beitrag_id = '$loeschen'");
			//echo "$loeschen <br> $themaID";
			
			header("location:forum.php?thema=$themaID");		//Wird zurueck zum Thema geleitet
		}
		
		if(isset($_POST['beitragThemaLoeschen'])){			//Wenn hingegen das ganze Thema geloescht werden soll 
			$loeschen = $_POST['beitragThemaLoeschen'];			
			//$loeschen = stripcslashes($loeschen);
		//	$loeschen = mysql_real_escape_string($loeschen);
			
			$themaID = getORSetEintraege("SELECT thema_ref FROM beitrag WHERE beitrag_id = '$loeschen'");
			$themaID = $themaID[0];
			
			//echo "$loeschen <br> $themaID";
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM beitrag WHERE thema_ref = '$themaID'");	//Muessen erst alle Beitraege zum Thema aus der Datenbank entfernt werden
			
			$projektID = getORSetEintraege("SELECT projekt_ref FROM thema WHERE thema_id = '$themaID'");	
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM thema WHERE thema_id = '$themaID'");		//Erst danach wird das Thema geloescht
			
			header("location:projektseite.php?projekt_id=$projektID[0]");
		}
	}	
		
?>