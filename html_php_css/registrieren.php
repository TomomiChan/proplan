<?php 
	//hole die werte aus dem Formular
  	session_start();

    // Values aus dem Formular holen
	$username= $_POST['username'];
    $email= $_POST['email'];
    $passwort= $_POST['password'];

    // Entferne die Quotes
	$username = stripcslashes($username);
    $email = stripcslashes($email);
	$passwort = stripcslashes($passwort);
    
    // Entferne special Charakters
	$username = mysql_real_escape_string($username);
    $email = mysql_real_escape_string($email);
	$passwort = mysql_real_escape_string($passwort);
    
    // MD5 Verschlüsselung des Passworts
	$passwort = md5($passwort);
    // Variable für die Datenbank
    $dbname = "pro_db";

    // Herstellung der Verbindung zur Datenbank
    $conn = new mysqli("localhost", "root", "", $dbname);
	
    // Ueberpruefung der Verbindung
    if ($conn->connect_error) {
        die("Verbindung zur Datenbank ist fehlgeschlagen ".$conn->connect_error);
    } 
    echo "Verbindung erfolgreich";
    
    // Zielverzeichnis zur Speicherung der Dateien
    $target_dir = "../uploads/";
    // Variable fuer das File das hochgeladen werden soll
    $target_file = $target_dir. basename($_FILES["picture"]["name"]);
    // Boolscher Wert fuer den erfolgreichen Upload
    $uploadOk = 1;
    // Hole dir den Dateityp des Bildes
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Ueberpruefung ob die Datein eine Bilddatei ist
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if($check !== false) {
            echo "Die Datei ist ein Bild - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Die Datei ist kein Bild";
            $uploadOk = 0;
        }
    }

    // Ueberpruefung ob das Bild schon vorhanden ist
    if (file_exists($target_file)) {
        echo "Das Bild ist schon vorhanden";
        $uploadOk = 0;
    }
    // Ueberpruefung der zulaessigen Dateigroesse
    if ($_FILES["picture"]["size"] > 500000) {
        echo "Das Bild ist zu groß. Die maximale Dateigroesse ist 500 KB";
        $uploadOk = 0;
    }
    // Nur bestimme Bildformate erlauben
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
       && $imageFileType != "gif" ) {
        echo "Sorry, nur JPG, JPEG, PNG & GIF Bildadateien sind erlaubt.";
        $uploadOk = 0;
    }
    // Wenn UploadOk auf 1 ist, wird das Bild hochgeladen, ansonsten Fehlerausgabe  
    if ($uploadOk == 0) {
        echo "Sorry, dein Bild wurde nicht hochgeladen";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        echo "Dein Bild". basename( $_FILES["picture"]["name"]). " wurde erfolgreich hochgeladen";
        } else {
            echo "Sorry, irgendwas ist schief gelaufen :S";
        }
    }

    // Datenbankeintrag eines neuen Users
    $result = $conn->query("INSERT INTO user(email, passwort, name, bild) VALUES ('$email','$passwort','$username','$target_file')"); 
   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<title> Proplaner </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="headerunterseiten">
			<div class="lilabannerunterseiten">
			<img class="lesezeichenunterseiten" src="../Images/lesezeichen.png" />
			<img class="gluehbirneunterseiten" src="../Images/gluehbirne.png" width="135px" alt="gluehbirne" />
			<img class="proplan" src="../Images/proplan.png" alt="proplan" />
			<p class="ueberschrift">Registrierung erfolgreich :)</p>	
			
			<div class="logout">	
				<a href="index.html" > <img src="../Images/logout.png" alt="logout" /></a>
			</div>
  
			<div class="profil">
				<a href="profil.html"><img src="../Images/profil_weiß.png" alt="profil" /></a>
			</div>
			</div>   		
		</header>
    <div class="hauptbereichunterseiten">
        
        <a href = "index.html" class="ueberschrift" id="regerfolgreich">
            Zurück zur Startseite ...
        </a>

    </div>
	<footer>
		<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
	</footer>
</body>
</html>