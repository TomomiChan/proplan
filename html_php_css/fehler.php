<?php
/**
  * Das Dokument zeigt eine Fehler Meldung an, die per GET Methode uebergeben wird
  * @author Christoph Suhr
  * 
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
	
	}
	
	$fehler_meldung = $_GET['fehlercode'];	
	echo $fehler_meldung;

?>