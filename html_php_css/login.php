<?php 
	//hole die werte aus dem Formular
  	session_start();
	$_SESSION['logged_in']=false;
	$username= $_POST['uname'];	 
	$passwort= $_POST['psw'];
	
	$username = stripcslashes($username);
	$passwort = stripcslashes($passwort);
	
	$username = mysql_real_escape_string($username);
	$passwort = mysql_real_escape_string($passwort);
	
	$passwort = md5($passwort);

	//Verbinung zu Datenbank
	mysql_connect("localhost", "root", "");
	mysql_select_db("pro_db");
	// 
	$result = mysql_query("select * from user where name = '$username' and passwort = '$passwort'")or 
	die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
	
	$row = mysql_fetch_array($result);
	
	if($row['name']==$username && $row['passwort']==$passwort){
		echo "Login hat geklappt. Willkommen ".$row['name'];
		$_SESSION['logged_in']=true;
		$_SESSION['name']=$row['name'];
		$id = mysql_query("select user_id from user where name = '$username' and passwort = '$passwort' ");
		$_SESSION['id']=$id;
		echo '<meta http-equiv="refresh" content="2; URL = meineProjekte.html">';
	}else{
		echo "Login gescheitert";
		
	}
	

?>
	