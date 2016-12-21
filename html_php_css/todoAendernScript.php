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
		
		
		$neuertext = $_POST['textareatodo'];
		//$neuertext = stripcslashes($neuertext);
		$neuertext = mysql_real_escape_string($neuertext);
		
		$todoID = $_POST['todoAendern'];
		//$todoID = stripcslashes($todoID);
		$todoID = mysql_real_escape_string($todoID);
		
		if(strlen($neuertext)> 100){
			$neuertext = substr($neuertext, 0, 100);
		}
		
		$rueckgabe = getORSetEintraege("UPDATE to_do SET aufgabe = '$neuertext' WHERE to_do_id = '$todoID'");
		$projekt_id = getORSetEintraege("SELECT projekt_ref FROM to_do WHERE to_do_id = '$todoID'");
		$projekt_id = $projekt_id['projekt_ref'];
		header("location:projektseite.php?projekt_id=$projekt_id");
	}	
		
?>