<?php
session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.php");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$benutzer_id = $_SESSION['id'];
		
		//Verbinung zu Datenbank

		include ("datenbankschnittstelle.php");
		datenbankaufbau();
		
	}
?>
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
				<p class="ueberschrift">Neues Projekt </p>	
           		<p class="pfad">
					<a href="meineProjekte.php">Meine Projekte ></a>
					Neues Projekt
				</p>
			
				<div class="logout">	
					<a href="logout.php"> <img src="../Images/logout.png" alt="logout" /></a>
				</div>
  
				<div class="profil">
					<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
				</div>

				</div>
            </div>
		</header>
        
        
         <div class="hauptbereichunterseiten">
            <div id="inhalt"><h3>Projekt - Anlegen</h3>         
            <img id ="ordnerBild"  src="../Images/ordnerGrau.png"  alt="ordner" />
    	
         	<form id="formularProjekt" method="post" action="neuesProjektAnlegen.php">	
			
    			<table id = "neueProjektTabelle">
					<tr>
						<td>
                   			Projektname: <div class = "eingabeProjekt"><input id= "pName" type="text" name="projektname" placeholder="Projektname" required></div>
                  	 	</td>
               		</tr>
               		<tr>
						<td>
                   			 Projektbeginn:<input class = "datumfeld" type="number" min="2001" max ="3030" name="beginnJahr"  placeholder="Jahr" required>
                            <input class = "datumfeld" type="number" min="01" max="12" name="beginnMonat"  placeholder="Monat" required>
                            <input class = "datumfeld" type="number" min="01" max="31" name="beginn"  placeholder="Tag" required>
                   		</td>
                	</tr>
                	<tr>
						<td>
                    		Projektende: <input class = "datumfeld" type="number" min="2001" max ="3030" name="endeJahr"  placeholder="Jahr" required>
                            <input class = "datumfeld" type="number" min="01" max="12" name="endeMonat"  placeholder="Monat" required>
                            <input class = "datumfeld" type="number" min="01" max="31" name="ende"  placeholder="Tag" required>
                        </td>
                	</tr>
                    <tr>
						<td>
                    		Teammitglieder:
                            <div class = "eingabeProjekt">
								<textarea name="textareaprojekt" class="textareaprojekt" rows="5" cols="24" placeholder="Emailadressen mit Komma getrennt eingeben: maxmuster@domain.de, andre@domain.de, ..."></textarea> 
                            </div>
                        </td>
                	</tr>
                   

               		<tr>
                   		<td id = "neuerProjektbutton">
                			<button type="submit" id="button4" value="speichern" name="speichern">Projekt Anlegen</button>
                		</td>
					</tr>

            	</table>
      		</form>
         
         </div>
         </div>
         
         <footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>
	</body>
</html>
