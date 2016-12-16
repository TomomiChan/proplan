<?php
	session_start();

	mysql_connect("localhost", "root", "");
	mysql_select_db("pro_db");
	$userID = $_SESSION['id'];
	
	
	if (isset($_POST ["button"])&& $_POST["button"]=="name_aendern"){
	$neuerName = $_POST['neuerName'];
	$result = mysql_query("update user set name='$neuerName' where user_id ='$userID'")or 
	die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		if($result){
			$_SESSION['name'] = $neuerName;
			header("Location: profil.php"); 
		}
	}
	
	if (isset($_POST['neuesPasswort'])){
	//echo "passwort übergeben";
	$neuesPasswort = $_POST['neuesPasswort'];
	$neuesPasswort = md5($neuesPasswort);
	$result = mysql_query("update user set passwort = '$neuesPasswort' where user_id='$userID' ")or 
	die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		if($result){
			header("Location: profil.php"); 
		}
		
	}
	
	if (isset($_POST['neueEmail'])){
	echo "email übergeben";
	$neuesPasswort = $_POST['neueEmail'];
	mysql_query("update user set email = '$neueEmail' where user_id='$userID' ")or 
	die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		if($result){
			header("Location: profil.php");
		}
	}

	
	
?>