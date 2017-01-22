<?php
/**
  * Das Dokument stellt die Anfrage zum Einfuegen von Zeilen in die Datenbanktabelle Beitrag
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
		
		$themaID = $_POST['forumAntworten'];	 
		//$themaID = mysql_real_escape_string($themaID);
		
		$text = $_POST['textareaforum'];	 
		//$text = mysql_real_escape_string($text);
		
		$tag = time();
		$tag = date('Y-m-d H:i:s',$tag);		//Holt sich die aktuelle Zeit und bastelt diese in das passende Format fuer die Datenbank
	}
	
	
	$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO beitrag (beitrag_text, datum, thema_ref, user_ref) VALUES ('$text', '$tag', '$themaID', '$benutzer_id')");
	header("location:forum.php?thema=$themaID");
	
?>