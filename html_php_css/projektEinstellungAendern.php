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
		
		if(isset($_POST['nameaendern'])){
			
		}
		if(isset($_POST['beginnaendern'])){
			
		}
		if(isset($_POST['endeaendern'])){
			
		}
		if(isset($_POST['nutzerhinzufuegen'])){
			
		}
		if(isset($_POST['projektentfernen'])){
			
		}
		
		header("location:projektseite.php?projekt_id=$projektID");
	}	
		
?>