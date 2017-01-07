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
		
		include ("datenbankschnittstelle.php");
		datenbankaufbau();
		
		if(isset($_POST['bearbeiten'])){
			$bearbeiten = $_POST['bearbeiten'];			//ID des jeweiligen TODOS
			//$bearbeiten = stripcslashes($bearbeiten);
			$bearbeiten = mysql_real_escape_string($bearbeiten);
			
			$projektID = getORSetEintraege("select projekt_ref FROM to_do WHERE to_do_id = '$bearbeiten'");
			$projektID = $projektID['projekt_ref'];
			
			$projektname = getORSetEintraege("select name FROM projekt WHERE projekt_id = '$projektID'");
			
			
			$todo_aufgabe = getORSetEintraege("select aufgabe FROM to_do WHERE to_do_id = '$bearbeiten'");

			
			echo "<html>
			<head>
				<meta charset=\"utf-8\">
				<link href=\"https://fonts.googleapis.com/css?family=Ubuntu\" rel=\"stylesheet\">
				<title> Proplaner </title>
				<link rel=\"stylesheet\" href=\"style.css\">
				
				
				<script type=\"text/javascript\">  		// Javascript leicht abgewandelt von der Seite : https://www.lima-city.de/thread/javascript-zeilen-einer-textarea-begrenzen
  
					// globale Zählervariable  
					var charsToGo;  
					function charCounter(charInputSrcName, maxCharCount) {  
  
						// Zugriffsvariablen festlegen  
						var charInputSrc = document.getElementById(charInputSrcName);  
  
						if (charInputSrc != null) {  
						// Länge des Feldinhaltes prüfen  
							if (charInputSrc.value.length <= maxCharCount) {  
							// Anzahl Restzeichen berechnen und Zeichenanzeige aktualisieren  
							charsToGo = maxCharCount - charInputSrc.value.length;  

							document.getElementById(\"uebrigeZeichen\").innerHTML = 'Es können maximal 100 Zeichen geschrieben werden: (' + charsToGo + '&nbsp;Zeichen übrig)'; 
							}  
							else{  
								// Eingegebenes Zeichen wieder abschneiden  
								charInputSrc.value = charInputSrc.value.substring(0, maxCharCount);  
								charsToGo = maxCharCount - charInputSrc.value.length;  
							}
						}  
					}  
				</script>
				
				
			</head>
				<body>
					<header class=\"headerunterseiten\">
						<div class=\"lilabannerunterseiten\">
							<img class=\"lesezeichenunterseiten\" src=\"../Images/lesezeichen.png\" />
							<img class=\"gluehbirneunterseiten\" src=\"../Images/gluehbirne.png\" width=\"135px\" alt=\"gluehbirne\" />
							<img class=\"proplan\" src=\"../Images/proplan.png\" alt=\"proplan\" />
							<p class=\"ueberschrift\">TO-DO Bearbeiten</p>	
			
							<div class=\"logout\">	
								<a href=\"logout.php\"> <img src=\"../Images/logout.png\" alt=\"logout\" /></a>
							</div>
  
							<div class=\"profil\">
								<a href=\"profil.php\"><img src=\"../Images/profil_weiß.png\" alt=\"profil\" /></a>
							</div>
							
							<p class=\"pfad\">
								<a href=\"meineProjekte.php\">Meine Projekte ></a>
								<a href=\"projektseite.php?projekt_id=$projektID\">"; 
								echo $projektname['name']; 
								echo" ></a>
								TO-DO bearbeiten
							</p>
							
						</div>   		
					</header>
	
					<div class=\"hauptbereichunterseiten\">
					
						<div id=\"inhalt\"><h3>TO-DO - Bearbeiten</h3>
							<form name=\"todoformAendern\" action='todoAendernScript.php' method='POST'>
								<textarea name=\"textareatodo\" id=\"textareatodo\" rows=\"2\" cols=\"55\" placeholder=\"Schreiben sie ihre Aufgabe ...\" 
									onKeyDown=\"return charCounter('textareatodo', 99);\"  
									onKeyUp=\"return charCounter('textareatodo', 99);\"  
									onChange=\"return charCounter('textareatodo', 99);\">"; echo $todo_aufgabe['aufgabe']; echo "</textarea>
								<div id=\"uebrigeZeichen\">
									<noscript>
										In Ihrem Browser ist JavaScript deaktiviert. Um den vollen Umfang der Seite nutzen zu können aktivieren sie JavaScript!
									</noscript>
								Es können maximal 100 Zeichen geschrieben werden:</div>
									<button type=\"submit\" class=\"buttonForm\" name=\"todoAendern\" value=\"$bearbeiten\">TO-DO ändern</button>
							</form>
						</div>
						
					</div>	
	
					<footer>
						<a href=\"impressum.html\">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href=\"kontakt.html\">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href=\"agb.html\">AGB</a>
					</footer>
				</body>
			</html>";

			//echo $bearbeiten;
			//echo "bearbeitet";
		}
		if(isset($_POST['erledigt'])){
			$erledigt = $_POST['erledigt'];			//ID des jeweiligen TODOS
			//$erledigt = stripcslashes($erledigt);
			$erledigt = mysql_real_escape_string($erledigt);
		
			$rueckgabe = getORSetEintraege("UPDATE to_do SET bearbeitet = '1' WHERE to_do_id = '$erledigt'");
			$projekt_id = getORSetEintraege("SELECT projekt_ref FROM to_do WHERE to_do_id = '$erledigt'");
			$projekt_id = $projekt_id['projekt_ref'];
			header("location:projektseite.php?projekt_id=$projekt_id");
		}
		if(isset($_POST['loeschen'])){
			$loeschen = $_POST['loeschen'];			//ID des jeweiligen TODOS
			//$loeschen = stripcslashes($loeschen);
			$loeschen = mysql_real_escape_string($loeschen);
			
			$projekt_id = getORSetEintraege("select projekt_ref from to_do WHERE to_do_id = '$loeschen'");
			$projekt_id = $projekt_id['projekt_ref'];
			
			$rueckgabe = getORSetEintraege("DELETE FROM to_do WHERE to_do_id = '$loeschen'");
			
			header("location:projektseite.php?projekt_id=$projekt_id");
		}

	}

?>

