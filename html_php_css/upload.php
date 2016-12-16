 <?php 
 	session_start();
	$ladeseiteneu = false;
	$bildupdate = false;
	mysql_connect("localhost", "root", "");
	mysql_select_db("pro_db");
	$userID = $_SESSION['id'];
	$bilddatei = '../uploads/'. basename($_FILES["bild"]["name"]);
	$bildname =($_FILES['bild']['name']);
	
	
	$result = mysql_query("select bild from user where user_id='$userID' ");
	$pfad = mysql_fetch_array($result);
	$bilddatenbank = $pfad['bild'];
	
	if ($bilddatenbank !=""){
		unlink("[../uploads/]$bilddatenbank");
		$bildupdate = true;
	}else{
		$bildupdate = true;
	}
	
	
	$max_size = 500*1024; //500 KB
	if($_FILES['bild']['size'] > $max_size) {
	die("Bitte keine Dateien größer 500kb hochladen");
	}	

	
	if(isset($_POST['upload'])&& $bildupdate){
	
	move_uploaded_file($_FILES['bild']['tmp_name'], '../uploads/'.$_FILES['bild']['name']); //verschiebt die Datei in den Ordner uploads
	mysql_query("update user set bild = '$bilddatei' where user_id='$userID' ")or 
	die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
	$ladeseiteneu = true;
	
	}
	
	if ($ladeseiteneu){
		header("Location: profil.php");	
	}
	

?>