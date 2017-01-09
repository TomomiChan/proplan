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
		
		$projektID = $_POST['forumNeuesThema'];	 
		//$projektID = mysql_real_escape_string($projektID);
		
		$themaName = $_POST['themaName'];
		//$themaName = mysql_real_escape_string($themaName);
		
		$text = $_POST['textareaNeuesThema'];	 
		//$text = mysql_real_escape_string($text);
		
		$tag = time();
		$tag = date('Y-m-d H:i:s',$tag);
	}
	
	$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO thema (name, projekt_ref, datumProjekt) VALUES ('$themaName', '$projektID', '$tag')");
	$themaID = getORSetEintraege("SELECT thema_id FROM thema WHERE name = '$themaName' AND projekt_ref = '$projektID' AND datumProjekt = '$tag'");
	
	$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO beitrag (beitrag_text, datum, thema_ref, user_ref) VALUES ('$text', '$tag', '$themaID[0]', '$benutzer_id')");
	header("location:forum.php?thema=$themaID[0]");
	
?>