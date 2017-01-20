<?php 
/**
* Prueft alle Eingaben des Logins und leitet zur Seite "Meine Projekte" weiter
*@autor Alice Markmann
**/
	//Werte der Inputfelder des Logins werden per Post geholt
  	session_start();
	$_SESSION['logged_in']=false;
	$email= $_POST['email'];	 
	$passwort= $_POST['psw'];
	
	/*$username = stripcslashes($username);
	$passwort = stripcslashes($passwort);
	
	$username = mysql_real_escape_string($username);
	$passwort = mysql_real_escape_string($passwort);
	die Methoden wurden auskommentiert, da sie mir der PHP Version des Serves nicht kompatibel sind, 
	sollten normalerweise vor einer SQL Injection schützen*/
	
	// md5() kryptographische Hashfunktion, die aus dem eingegebenen Passwort einen 128-Bit-Hashwert erzeugt
	$passwort = md5($passwort);

	//Verbinung zur Datenbank, Datenbankzugriffe werden ueber die datenbankschnittstelle.php ausgefuehrt
	include ("datenbankschnittstelle.php");
	datenbankaufbau();
	
	//Die eingegebenen Daten des Logins werden aus der Datenbank ausgelsen, die Zeile in der die Email und Passwort zufinden sind werden in $row gespeichert
	$row = getORSetEintraege("SELECT * FROM user WHERE email = '$email' and passwort = '$passwort'");
	
	/**Sessionvariablen werden gesetzt 
	* User_id und der dazugehoerige Name wird aus der Datenbank geholt und der Session uebergeben
	**/
	if($row['email']==$email && $row['passwort']==$passwort){
		$_SESSION['logged_in']=true;
		$_SESSION['email']=$row['email'];
	
		$row = getORSetEintraege("select user_id,name from user where email = '$email' and passwort = '$passwort' ");
		$_SESSION['id']=$row['user_id'];
		$_SESSION['name']=$row['name'];
	//Seite neu Laden	
		echo '<meta http-equiv="refresh" content="0; URL = meineProjekte.php">';	
	}else{
		echo "Login gescheitert";
		
	}
	

?>
	