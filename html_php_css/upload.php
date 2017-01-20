 <?php
/**
*Behandelt den Bildupload
*@autor Alice Markmann
**/
 	session_start();
	$ladeseiteneu = false;
	$bildupdate = false;
	//Datenbankverbindung
	include ("datenbankschnittstelle.php");
	datenbankaufbau();
	$userID = $_SESSION['id'];
	$bilddatei = '../uploads/'. basename($_FILES["bild"]["name"]);
	$bildname =($_FILES['bild']['name']);
    $bildDateityp = pathinfo($bilddatei,PATHINFO_EXTENSION);

	$pfad = getORSetEintraege("select bild from user where user_id='$userID' ");
	$bilddatenbank = $pfad['bild'];

	/*if ($bilddatenbank !=""){
		unlink("[../uploads/]$bilddatenbank");
		$bildupdate = true;
	}else{
		$bildupdate = true;
	}*/

  // Maximale Dateigroesse fuer Bilder
	$max_size = 500*1024; //500 KB
	if($_FILES['bild']['size'] > $max_size) {
	   die("Bitte keine Dateien größer 500kb hochladen");
	}

  // Nur bestimmte Bild Dateitypen
    if($bildDateityp != "jpg" && $bildDateityp != "jpeg" && $bildDateityp != "png" && $bildDateityp != "bmp" ) {
		die("Bitte nur Bilder vom Typ JPG, JPEG, BMP und PNG hochladen");
	}
  //die hochgeladene Datei wird in den Ordner "uploads" abgelegt,der Pfad wird in der Datenbank abgelegt
	if(isset($_POST['upload'])){
		move_uploaded_file($_FILES['bild']['tmp_name'], '../uploads/'.$_FILES['bild']['name']); //verschiebt die Datei in den Ordner uploads
		$endung = pathinfo($bilddatei);
		$endung = $endung['extension'];
		rename($bilddatei,"../uploads/$userID.$endung");
		$result = getORSetEintraegeSchleifen("UPDATE user SET bild = '../uploads/$userID.$endung' WHERE user_id='$userID' ");
		$ladeseiteneu = true;
	}
	//Seite neu laden
	if ($ladeseiteneu){
		header("Location: profil.php");
	}

?>
