<?php 
	session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.php");
	} else{
		$berechtigung = 1;
		//echo "Eingeloggt ist der Benutzter ".$_SESSION['name']." ".$_SESSION['id'];
		$benutzer = $_SESSION['name'];
		$email = $_SESSION['email'];
		$userID = $_SESSION['id'];
		include ("datenbankschnittstelle.php");
		datenbankaufbau();
	}
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
			<a href = "meineProjekte.php"><img class="proplan" src="../Images/proplan.png" alt="proplan" /> </a>
			<p class="ueberschrift">Mein Profil</p>	
			
			<div class="logout">	
            	<a href="logout.php" > <img src="../Images/logout.png" alt="logout" /></a>
			</div>
        
			  		
		</header>
        
	
    <script language="JavaScript">
		function passwortAbgleich(){
			var passwort1 = document.passwortbereich.neuesPasswort.value;
			var passwort2 = document.passwortbereich.wiederholtesPasswort.value;
			if (passwort1 != passwort2) {
			alert ("Fehler. Bitte überprüfen Sie ihre Passwortangaben");
			document.passwortbereich.neuesPasswort.focus();
			return false;
			}
			
			if(passwort1.length<8)
			{
				alert ("Das Passwort muss eine Länge von mindestens 8 Zeichen betragen");
				document.passwortbereich.neuesPasswort.focus();
				return false;
			}
			
			if (passwort1 == passwort2){
				alert ("Passwort geändert");
				return false;
			}			
		}
    </script>
        
    <div class="hauptbereichunterseiten">
		<div id="inhalt"><h3>Profil bearbeiten</h3>
		<form id ="profiltabelle" method="post" action="update.php">	

			<table id="inneretabelle">
			<tbody>
				<tr>
					<td id="user_name">
						Name:
						<div class = "eingabe">	<input type="text" placeholder= <?=$benutzer?> name="neuerName" required></div>
					</td>
					<td>
						<button type="submit" id="button4" name="button" value="name_aendern">Name ändern</button>
					</td> 
				</tr>
		</form>
     
		<form id = "profiltabelle" method="POST" action="update.php" name = "passwortbereich" onSubmit="return passwortAbgleich()">
				<tr>
					<td id="user_pw">
						Passwort:
						<div class = "eingabe"><input type="password" placeholder="******" name="neuesPasswort" required></div>
					</td>
					<td>
						<button type="submit" id="button4" value="passwort_aendern">Passwort ändern</button>
					</td>
				</tr>
				<tr>
					<td>
						<div class = "eingabe">
							<input type="password" placeholder="passwort wiederholen" name="wiederholtesPasswort" required>
						</div>
					</td>
				</tr>
            
		</form>
    
		<form id = "profiltabelle" method="POST" action="update.php">
            
				<tr>
					<td id="user_email">
						Email:
						<div class = "eingabe"> <input type="email" placeholder=<?=$email?> name="neueEmail" required></div>
					</td>
					<td>
						<button type="submit" id="button4" value="email_aendern">Email ändern</button>
					</td>
				</tr>
				</table>
		</form>
		</tbody>
			<div id=profilbild>
				<?php
				if($berechtigung==1){
					$pfad = getORSetEintraege("select bild from user where user_id = '$userID'");
					$bildpfad = $pfad['bild'];
					if ($pfad['bild']!=""){
						echo "<img  src=\"$bildpfad\" height=\"110px\" width=\"100px\">";
					}else{
						echo"<img src='../Images/profilbild_rechteck.png' height=\"110px\" width=\"100px\"/>";
					}
				}
				?>
        	
			
        </div>
			<div id="profilbild_upload">
				<form action = "upload.php" method="POST" enctype="multipart/form-data" >
					<p id = "pBeschriftung">Neues Profilbild?</p> <input type="file" name="bild"  />
					<input type="submit" name="upload" value="Upload"  id="button4"/>
				</form>    
			</div>
		</div>
	</div>	
    

    
	
	<footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>
	</body>
</html>
