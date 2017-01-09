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
		
		if(isset($_POST['beitragLoeschen'])){
			$loeschen = $_POST['beitragLoeschen'];			
			//$loeschen = stripcslashes($loeschen);
		//	$loeschen = mysql_real_escape_string($loeschen);
			
			$themaID = getORSetEintraege("SELECT thema_ref FROM beitrag WHERE beitrag_id = '$loeschen'");
			$themaID = $themaID['thema_ref'];
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM beitrag WHERE beitrag_id = '$loeschen'");
			//echo "$loeschen <br> $themaID";
			
			header("location:forum.php?thema=$themaID");
		}
		
		if(isset($_POST['beitragThemaLoeschen'])){
			$loeschen = $_POST['beitragThemaLoeschen'];			
			//$loeschen = stripcslashes($loeschen);
		//	$loeschen = mysql_real_escape_string($loeschen);
			
			$themaID = getORSetEintraege("SELECT thema_ref FROM beitrag WHERE beitrag_id = '$loeschen'");
			$themaID = $themaID[0];
			
			//echo "$loeschen <br> $themaID";
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM beitrag WHERE thema_ref = '$themaID'");
			
			$projektID = getORSetEintraege("SELECT projekt_ref FROM thema WHERE thema_id = '$themaID'");
			
			$rueckgabe = getORSetEintraegeSchleifen("DELETE FROM thema WHERE thema_id = '$themaID'");
			
			header("location:projektseite.php?projekt_id=$projektID[0]");
		}
	}	
		
?>