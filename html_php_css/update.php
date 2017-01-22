<?php
/**
*Dokument behandelt die Aenderungen von Profilname, Email und Passwort
*@autor Alice Markmann
**/
	session_start();
	//Datenbankverbindung
	include ("datenbankschnittstelle.php");
	datenbankaufbau();
	$userID = $_SESSION['id'];
	
	//Username wird in der Datenbank geaendert
	if (isset($_POST["button"])&& $_POST["button"]=="name_aendern"){
	$neuerName = $_POST['neuerName'];
	$result = getORSetEintraegeSchleifen("UPDATE user SET name='$neuerName' WHERE user_id ='$userID'");
		if($result){
			$_SESSION['name'] = $neuerName;
			header("Location: profil.php"); 
		}
	}
	
	//Passwort wird in der Datenbank geaendert
	if (isset($_POST['neuesPasswort'])){					
	$neuesPasswort = $_POST['neuesPasswort'];		
	$neuesPasswort = md5($neuesPasswort);
	$result = getORSetEintraegeSchleifen("UPDATE user SET passwort = '$neuesPasswort' WHERE user_id='$userID'");
		if($result){
			header("Location: profil.php"); 
		}
		
	}
	//Email wird in der Datenbank geaendert
	if (isset($_POST['neueEmail'])){
	$neueEmail = $_POST['neueEmail'];		
	$result = getORSetEintraegeSchleifen("UPDATE user SET email='$neueEmail' WHERE user_id='$userID'");
		if($result){
			$_SESSION['email'] = $neueEmail;		
			header("Location: profil.php");
		}
	}

	
	
?>