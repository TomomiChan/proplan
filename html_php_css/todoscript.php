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
		
		mysql_connect("localhost", "root", "");
		mysql_select_db("pro_db");
		mysql_query ('SET NAMES utf8'); 
		
		if(isset($_POST['bearbeiten'])){
			$bearbeiten = $_POST['bearbeiten'];
			$bearbeiten = stripcslashes($bearbeiten);
			$bearbeiten = mysql_real_escape_string($bearbeiten);
			
			$result = mysql_query("select projekt_ref FROM to_do WHERE to_do_id = '$bearbeiten'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$projektID = mysql_fetch_array($result);
			$projektID = $projektID['projekt_ref'];
			
			$result = mysql_query("select name FROM projekt WHERE projekt_id = '$projektID'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
			$projektname = mysql_fetch_array($result);
			
			$todo = mysql_query("select aufgabe FROM to_do WHERE to_do_id = '$bearbeiten'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
			$todo_aufgabe = mysql_fetch_array($todo);
			
			
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

							document.getElementById(\"uebrigeZeichen\").innerHTML = 'Es können maximal 110 Zeichen geschrieben werden: (' + charsToGo + '&nbsp;Zeichen übrig)'; 
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
					
						<div id=\"todo\"><h3>TO-DO - Bearbeiten</h3>
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
									<button type=\"submit\" class=\"todoButtonForm\" name=\"todoAendern\" value=\"$bearbeiten\">TO-DO ändern</button>
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
			$erledigt = $_POST['erledigt'];
			$erledigt = stripcslashes($erledigt);
			$erledigt = mysql_real_escape_string($erledigt);
		
			$rueckgabe = mysql_query("UPDATE to_do SET bearbeitet = '1' WHERE to_do_id = '$erledigt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$result = mysql_query("select projekt_ref from to_do WHERE to_do_id = '$erledigt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$projekt_id = mysql_fetch_array($result);
			$projekt_id = $projekt_id['projekt_ref'];
			header("location:projektseite.php?projekt_id=$projekt_id");
		}
		if(isset($_POST['loeschen'])){
			$loeschen = $_POST['loeschen'];
			$loeschen = stripcslashes($loeschen);
			$loeschen = mysql_real_escape_string($loeschen);
			
			$result = mysql_query("select projekt_ref from to_do WHERE to_do_id = '$loeschen'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$projekt_id = mysql_fetch_array($result);
			$projekt_id = $projekt_id['projekt_ref'];
			
			$rueckgabe = mysql_query("DELETE FROM to_do WHERE to_do_id = '$loeschen'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			
			header("location:projektseite.php?projekt_id=$projekt_id");
		}

	}

?>

