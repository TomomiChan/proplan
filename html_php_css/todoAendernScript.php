<?php

/**
  * Das Dokument Updatet die Datenbankeintraege in der Tabelle Todo, mit den ueberlieferten Atributen
  * @author Christoph Suhr
  */
  
session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){		//Ist der Nutzer ueberhaupt noch in der Session
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
		//$neuertext = stripcslashes($neuertext);					//SQL Sicherheitsabfragen, in der PHP Version nicht mehr unterstuetzt
		//$neuertext = mysql_real_escape_string($neuertext);
		
		$todoID = $_POST['todoAendern'];
		//$todoID = stripcslashes($todoID);
		//$todoID = mysql_real_escape_string($todoID);
		
		if(strlen($neuertext)> 100){					//Pruefen ob der String groeßer ist als 100 Zeichen
			$neuertext = substr($neuertext, 0, 100);	//Schneidet ihn ab
		}
		
		$rueckgabe = getORSetEintraegeSchleifen("UPDATE to_do SET aufgabe = '$neuertext' WHERE to_do_id = '$todoID'");
		$projekt_id = getORSetEintraege("SELECT projekt_ref FROM to_do WHERE to_do_id = '$todoID'");
		$projekt_id = $projekt_id['projekt_ref'];
		header("location:projektseite.php?projekt_id=$projekt_id");
	}	
		
?>