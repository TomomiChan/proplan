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
			<p class="ueberschrift">Mein Profil</p>	
			
			<div class="logout">	
				<a href="index.html" > <img src="../Images/logout.png" alt="logout" /></a>
			</div>
			  		
		</header>
	
    <div class="hauptbereichunterseiten">
	<?php 
    echo "Eingeloggt ist der Benutzter ".$_SESSION['name']." ".$_SESSION['id']; 
	
	?> 	
	</div>	
	
	<footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>
	</body>
</html>
