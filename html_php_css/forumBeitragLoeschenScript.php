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
			$loeschen = mysql_real_escape_string($loeschen);
			
			$themaID = getORSetEintraege("select thema_ref from beitrag WHERE beitrag_id = '$loeschen'");
			$themaID = $themaID['thema_ref'];
			
			$rueckgabe = getORSetEintraege("DELETE FROM beitrag WHERE beitrag_id = '$loeschen'");
			
			header("location:forum.php?thema=$themaID");
		}
		
		if(isset($_POST['beitragThemaLoeschen'])){
			$loeschen = $_POST['beitragThemaLoeschen'];			
			//$loeschen = stripcslashes($loeschen);
			$loeschen = mysql_real_escape_string($loeschen);
			
			$themaID = getORSetEintraege("select thema_ref from beitrag WHERE beitrag_id = '$loeschen'");
			$themaID = $themaID['thema_ref'];
			
			echo "$loeschen <br> $themaID[0]";
			
			$rueckgabe = getORSetEintraege("DELETE FROM beitrag WHERE thema_ref = '$themaID[0]'");
			
			$projektID = getORSetEintraege("SELECT projekt_ref FROM thema WHERE thema_id = '$themaID[0]'");
			
			$rueckgabe = getORSetEintraege("DELETE FROM thema WHERE thema_id = '$themaID[0]'");
			
			header("location:projektseite.php?projekt_id=$projektID[0]");
		}
	}	
		
?>