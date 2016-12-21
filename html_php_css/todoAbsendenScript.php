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
		
		mysql_connect("localhost", "root", "");
		mysql_select_db("pro_db");
		mysql_query ('SET NAMES utf8'); 
		
		
		$neuertext = $_POST['textareatodo'];
		$neuertext = stripcslashes($neuertext);
		$neuertext = mysql_real_escape_string($neuertext);
		
		$projekt_ref = $_POST['todoAbsenden'];
		$projekt_ref  = stripcslashes($projekt_ref );
		$projekt_ref  = mysql_real_escape_string($projekt_ref );
		
		if(strlen($neuertext)> 100){
			$neuertext = substr($neuertext, 0, 100);
		}
		
		$rueckgabe = mysql_query("INSERT INTO to_do (aufgabe, bearbeitet, projekt_ref) VALUES ('$neuertext', 'FALSE', '$projekt_ref')")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		header("location:projektseite.php?projekt_id=$projekt_ref");
	}	
		
?>