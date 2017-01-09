<?php 
	//hole die werte aus dem Formular
  	session_start();
	$_SESSION['logged_in']=false;
	$email= $_POST['email'];	 
	$passwort= $_POST['psw'];
	
	/*$username = stripcslashes($username);
	$passwort = stripcslashes($passwort);
	
	$username = mysql_real_escape_string($username);
	$passwort = mysql_real_escape_string($passwort);*/
	
	$passwort = md5($passwort);

	//Verbinung zu Datenbank
	include ("datenbankschnittstelle.php");
	datenbankaufbau();
	// 
	$row = getORSetEintraege("SELECT * FROM user WHERE email = '$email' and passwort = '$passwort'");
	
	
	if($row['email']==$email && $row['passwort']==$passwort){
		//echo "Login hat geklappt. Willkommen ".$row['name'];		// Hab ich erstmal rausgenommen, damit das beim testen nicht so lang dauert
		$_SESSION['logged_in']=true;
		$_SESSION['email']=$row['email'];
		
		$row = getORSetEintraege("select user_id,name from user where email = '$email' and passwort = '$passwort' ");
		$_SESSION['id']=$row['user_id'];
		$_SESSION['name']=$row['name'];
		
		echo '<meta http-equiv="refresh" content="0; URL = meineProjekte.php">';	//Hier hab ich die Zeit zum Umspringen mal auf 0 gesetzt
	}else{
		echo "Login gescheitert";
		
	}
	

?>
	