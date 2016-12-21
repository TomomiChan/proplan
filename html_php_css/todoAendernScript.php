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
		
		$todoID = $_POST['todoAendern'];
		$todoID = stripcslashes($todoID);
		$todoID = mysql_real_escape_string($todoID);
		
		if(strlen($neuertext)> 100){
			$neuertext = substr($neuertext, 0, 100);
		}
		
		$rueckgabe = mysql_query("UPDATE to_do SET aufgabe = '$neuertext' WHERE to_do_id = '$todoID'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		$result = mysql_query("select projekt_ref from to_do WHERE to_do_id = '$todoID'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		$projekt_id = mysql_fetch_array($result);
		$projekt_id = $projekt_id['projekt_ref'];
		header("location:projektseite.php?projekt_id=$projekt_id");
	}	
		
?>