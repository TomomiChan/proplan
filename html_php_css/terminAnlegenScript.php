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
		
		$neuertext = $_POST['textareatermin'];
		//$neuertext = mysql_real_escape_string($neuertext);		//Mysql befehle werden escaped
		
		$terminDatum_projektID = $_POST['terminAnlegen'];
		//$terminDatum_projektID = mysql_real_escape_string($terminDatum_projektID);
		list ($terminDatum, $projektID) = explode('/', $terminDatum_projektID);
		
		$stundeUhrzeit = $_POST['uhrzeit_stunde'];
		$minuteUhrzeit = $_POST['uhrzeit_minute'];
		/*$stundeUhrzeit = mysql_real_escape_string($stundeUhrzeit);
		$minuteUhrzeit = mysql_real_escape_string($minuteUhrzeit);*/

		$neueUhrzeit = $stundeUhrzeit . ":" . $minuteUhrzeit;
		$neueUhrzeit = date('H:i:s',strtotime($neueUhrzeit));
		
		if(strlen($neuertext)> 100){
			$neuertext = substr($neuertext, 0, 100);
		}

		$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO termin (termin_name, datum, uhrzeit, projekt_ref) VALUES ('$neuertext', '$terminDatum', '$neueUhrzeit', '$projektID')");
		header("location:projektseite.php?projekt_id=$projektID");
	}	
		
?>