<?php
	session_start();

	include ("datenbankschnittstelle.php");
	datenbankaufbau();
	$userID = $_SESSION['id'];
	
	
	if (isset($_POST["button"])&& $_POST["button"]=="name_aendern"){
	$neuerName = $_POST['neuerName'];
	$result = getORSetEintraegeSchleifen("UPDATE user SET name='$neuerName' WHERE user_id ='$userID'");
		if($result){
			$_SESSION['name'] = $neuerName;
			header("Location: profil.php"); 
		}
	}
	
	if (isset($_POST['neuesPasswort'])){
	//echo "passwort übergeben";					
	$neuesPasswort = $_POST['neuesPasswort'];		//Hier muessen ueberall noch die Escape Sachen rein da man hier sql injecttion betreiben kann
	$neuesPasswort = md5($neuesPasswort);
	$result = getORSetEintraegeSchleifen("update user set passwort = '$neuesPasswort' where user_id='$userID'");
		if($result){
			header("Location: profil.php"); 
		}
		
	}
	
	if (isset($_POST['neueEmail'])){
	//echo "email übergeben";
	$neueEmail = $_POST['neueEmail'];		//original stand dort :$neuesPasswort = $_POST['neueEmail'];	ich habs mal in $neueEmail geaendert
	$result = getORSetEintraegeSchleifen("update user set email='$neueEmail' where user_id='$userID'");
		if($result){
			$_SESSION['email'] = $neueEmail;		//hab ich auch noch hinzugefuegt
			header("Location: profil.php");
		}
	}

	
	
?>