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
		
		include ("datenbankschnittstelle.php");
		datenbankaufbau();
		
		
		$neuertext = $_POST['textareatodo'];
		//$neuertext = stripcslashes($neuertext);				//muss nicht, da wir ja nicht aus datenbank auslesen wollen
		//$neuertext = mysql_real_escape_string($neuertext);		//Mysql befehle werden escaped
		
		$projekt_ref = $_POST['todoAbsenden'];
		//$projekt_ref  = stripcslashes($projekt_ref);
	//	$projekt_ref  = mysql_real_escape_string($projekt_ref );
		
		if(strlen($neuertext)> 100){
			$neuertext = substr($neuertext, 0, 100);
		}
		
		$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO to_do (aufgabe, bearbeitet, projekt_ref) VALUES ('$neuertext', 'FALSE', '$projekt_ref')");
		header("location:projektseite.php?projekt_id=$projekt_ref");
	}	
		
?>