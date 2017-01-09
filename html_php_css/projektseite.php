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

		$result = getORSetEintraegeSchleifen("SELECT * FROM user_projekte WHERE user_ref = '$benutzer_id'");
		$i=0;
		while($row = $result->fetch_array(MYSQLI_BOTH)){		//in row stehen jetzt die einzelnen reihen aus der tabelle user_projekte z.B. (1 1) oder (1 4) / die user_id wurde bei der abfrage aus der Datenbank festgelegt
			$projekte[$i] = $row['projekt_ref'];		//ueberweise dem array nur die projekt_referenzen, nicht mehr die user_id
			$i++;										//zaehler fuer array
		}	
		
	}
	$aktuelles_projekt = $_GET['projekt_id'];	 
	//$aktuelles_projekt = stripcslashes($aktuelles_projekt);
	//$aktuelles_projekt = mysql_real_escape_string($aktuelles_projekt);
	
	$nutzer_ist_berechtigt = FALSE;				// Variable um zu gucken ob der Nutzer fuer das Projekt registriert ist
	for($i = 0; $i < count($projekte); $i++){		//geht alle Projekte in der Session durch
		if($aktuelles_projekt == $projekte[$i]){	//und gleicht dieses mit dem Projekt aus der Adresszeile ab
			$nutzer_ist_berechtigt = TRUE;			// Wenn er berechtigt ist true
		}
	}
	if(!$nutzer_ist_berechtigt){					//Ansonsten wird er auf eine andere Seite weitergeleitet
		header("location:fehler.php?fehlercode=Nicht_ihr_projekt");
	}
	
	/**Forumsthemen**/
	$result = getORSetEintraegeSchleifen("SELECT * FROM thema WHERE projekt_ref = '$aktuelles_projekt'");
	$j = 0;
	
	while($row = $result->fetch_array(MYSQLI_BOTH)){		
		$themaID[$j] = $row['thema_id'];	
		$themaName[$j] = $row['name'];	
		$j++;
	}	

	
	/**Projektzeiten*/
	$projektBeginn = getORSetEintraege("SELECT beginn_projekt FROM projekt WHERE projekt_id = '$aktuelles_projekt'");
	$projektEnde = getORSetEintraege("SELECT ende_projekt FROM projekt WHERE projekt_id = '$aktuelles_projekt'");

	/**Kalendereinträge**/
	$result = getORSetEintraegeSchleifen("SELECT * FROM termin WHERE projekt_ref = '$aktuelles_projekt'");
	$j = 0;
	
	while($row = $result->fetch_array(MYSQLI_BOTH)){		
		$terminID[$j] = $row['termin_id'];	
		$terminName[$j] = $row['termin_name'];	
		$terminDatum[$j] = $row['datum'];	
		$terminUhrzeit[$j] = $row['uhrzeit'];	
		$j++;
	}	
		
	/*for($i=0; $i < count($terminID); $i++){		//Testausgabe
		echo $terminID[$i];
		echo $terminName[$i];
		echo $terminDatum[$i];
		echo $terminUhrzeit[$i];
		echo "<br>";
	}*/
	
	/**Kalender**/			//Grund Kalender ist von der Website:http://www.webmasterpro.de/coding/article/einfacher-php-kalender.html
	//Allerdings wurde dieses Beispiel sehr, sehr stark abgewandelt, sodass man Eintraege und Hoverbefehle hat usw. ... (nur damit es kein Copyright Problem gibt, auch wenn nur noch das Grundgeruest uebrig ist ...)
	function monthBack( $timestamp ){
		return mktime(0,0,0, date("m",$timestamp)-1,date("d",$timestamp),date("Y",$timestamp) );
	}
	function yearBack( $timestamp ){
		return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)-1 );
	}
	function monthForward( $timestamp ){
		return mktime(0,0,0, date("m",$timestamp)+1,date("d",$timestamp),date("Y",$timestamp) );
	}
	function yearForward( $timestamp ){
		return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)+1 );
	}

	function fassezusammen($terDat){	//Falls ein Tag mehrere Termine hat uebergabe Wert ist das Datum welches mehrere Termine hat
		global $terminID;
		global $terminName;
		global $terminDatum;		
		global $terminUhrzeit;
		$temp = date_format(date_create($terDat),'d.m.y');		
		for($j=0; $j < count($terminID); $j++){		//geht alle Termine durch
			if ($terminDatum[$j] == $terDat){		//Wenn das Datum gleich ist
				$temp .= "<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr<br>------";		//haenge String an
			}
		}
		
		return $temp;
	}
	
	function getCalender($date,$headline = array('Mo','Di','Mi','Do','Fr','Sa','So')) {
		global $terminID;
		global $terminName;
		global $terminDatum;		//$eintragnull = new DateTime($terminDatum[0]);	//echo $eintragnull->format('Y-m-d H:i:s');
		global $terminUhrzeit;	
		//echo strtotime($terminDatum[0]);	//wandelt in Time um, braucht man, da Date mit Time() als zweites argument arbeitet 
		global $projektBeginn;
		global $projektEnde;
		global $aktuelles_projekt;
		
		$mehrfachdatum = array();		//Es koennen mehrere Termine an einen Tag auftauchen, diese Sammel ich hier und setze sie auf true oder false
		for($i=0; $i < count($terminID); $i++){	//Als erstes muss es aber einmal komplett gefuellt werden, damit es spaeter nicht zu exeptions kommt
			$mehrfachdatum[$i]=FALSE;
		}
		for($i=0; $i < count($terminID); $i++){		//geh alle durch
			for($j=$i; $j < count($terminID); $j++){	//damit keine doppelt genommen werden wird j auf i gesetzt
				if($terminDatum[$i] == $terminDatum[$j] && $i != $j){	//wenn er ein Datum findet 
					$mehrfachdatum[$i] = TRUE;		//setzt er es auf True
					$mehrfachdatum[$j] = TRUE;
				}
			}
		}
	
		$sum_days = date('t',$date);
		$LastMonthSum = date('t',mktime(0,0,0,(date('m',$date)),0,date('Y',$date)));		//der scheiß war falsch im Internet -_- fehlersuche =10min ... hier stand 1 statt 0
    
		foreach( $headline as $key => $value ) {
			echo "<div class=\"day headline\">".$value."</div>\n";
		}
    
		for( $i = 1; $i <= $sum_days; $i++ ) {
		
			$day_name = date('D',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
			$day_number = date('w',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        
			if( $i == 1) {
				$s = array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'));
				for( $b = $s; $b > 0; $b-- ) {
					$x = $LastMonthSum-($b-1);			//der scheiß war falsch im Internet -_- fehlersuche =10min ... hier muss man nach der aenderung oben -1 nehmen
					echo "<div class=\"day before\">".sprintf("%02d",$x)."</div>\n";
				}
			} 

			$eintragen = FALSE;
			for($j=0; $j < count($terminID); $j++){	//Zaehlt alle Termine durch
				//Fuer Eintraege
				if($i == date('d',strtotime($terminDatum[$j]))&& date('m.Y',strtotime($terminDatum[$j])) == date('m.Y',$date)){ 	//Wenn der Termineintrag aus der DB mit dem aktuellen uebereinstimmt und wir im richtigen Monat sind dann
					$eintragen = TRUE;					//Wenn er einen Eintrag hat 
					if( $i == date('d',$date) && date('m.Y',$date) == date('m.Y')) {	//Wenn der Tag $i der heutige ist
						if($i == date('d',strtotime($projektBeginn[0]))&& date('m.Y',strtotime($projektBeginn[0])) == date('m.Y',$date)){ //Kontrolle ob das ProjektBeginn auf dem Tag liegt
							if ($mehrfachdatum[$j]){	//Wenn es mehrere Termine gibt
								$max=0;					//max = soll die maximale id speichern bei doppelten Datumseintraegen
								for($z = 0; $z < count($terminID); $z++){ //geh wieder alle Termine durch
									if($terminDatum[$z]==$terminDatum[$j])$max=$z;	//Wenn ein Termin Datum gleich dem jetztigen ist setz ich max auf die zaehlvariable, so wird diese bis zum letzten Eintrag mit der grad zu guckendem Datumsstelle ($terminDatum[$j]) ueberschrieben
								}
								$letzte_id_mitdemDatum = $terminID[$max];	//Somit gab ich die letzte ID mit dem gleichen Datum
								if ($letzte_id_mitdemDatum == $terminID[$j]){	//und kontrollier, ob die letzte ID mit dem gleichen Datum gleich der gerade zu pruefenden ID($terminID[$j]) uebereinstimmt, wenn dies der Fall ist, sind wir bei der letzten ID mit dem doppelten Datum angekommen und koennen problemlos einmal echo schreiben und das dies spaeter nochmal passiert
									echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
											<div class=\"day eintragheutigerTagprojektBeginn\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
												<div class=\"hovereintrag\">Projekt Beginn - ".fassezusammen($terminDatum[$j])."</div>	
											</div>\n
										</button></form>";
								}
							} else{
								echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
										<div class=\"day eintragheutigerTagprojektBeginn\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
											<div class=\"hovereintrag\">Projekt Beginn - ".date_format(date_create($terminDatum[$j]),'d.m.y')."<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr</div>
										</div>\n
									</button></form>";	
							}
						}
						elseif($i == date('d',strtotime($projektEnde[0]))&& date('m.Y',strtotime($projektEnde[0])) == date('m.Y',$date)){	//Kontrolle ob ProjektEnde auf dem Tag liegt
							if ($mehrfachdatum[$j]){	//Wenn es mehrere Termine gibt
								$max=0;					//max = soll die maximale id speichern bei doppelten Datumseintraegen
								for($z = 0; $z < count($terminID); $z++){ //geh wieder alle Termine durch
									if($terminDatum[$z]==$terminDatum[$j])$max=$z;	//Wenn ein Termin Datum gleich dem jetztigen ist setz ich max auf die zaehlvariable, so wird diese bis zum letzten Eintrag mit der grad zu guckendem Datumsstelle ($terminDatum[$j]) ueberschrieben
								}
								$letzte_id_mitdemDatum = $terminID[$max];	//Somit gab ich die letzte ID mit dem gleichen Datum
								if ($letzte_id_mitdemDatum == $terminID[$j]){	//und kontrollier, ob die letzte ID mit dem gleichen Datum gleich der gerade zu pruefenden ID($terminID[$j]) uebereinstimmt, wenn dies der Fall ist, sind wir bei der letzten ID mit dem doppelten Datum angekommen und koennen problemlos einmal echo schreiben und das dies spaeter nochmal passiert
									echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
											<div class=\"day eintragheutigerTagprojektEnde\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
												<div class=\"hovereintrag\">Projekt Beginn - ".fassezusammen($terminDatum[$j])."</div>	
											</div>\n
										</button></form>";
								}
							} else{
								echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
										<div class=\"day eintragheutigerTagprojektEnde\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
											<div class=\"hovereintrag\">Projekt Ende - ".date_format(date_create($terminDatum[$j]),'d.m.y')."<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr</div>
										</div>\n
									</button></form>";
							}
						}
						else{
							if ($mehrfachdatum[$j]){	//Wenn es mehrere Termine gibt
								$max=0;					//max = soll die maximale id speichern bei doppelten Datumseintraegen
								for($z = 0; $z < count($terminID); $z++){ //geh wieder alle Termine durch
									if($terminDatum[$z]==$terminDatum[$j])$max=$z;	//Wenn ein Termin Datum gleich dem jetztigen ist setz ich max auf die zaehlvariable, so wird diese bis zum letzten Eintrag mit der grad zu guckendem Datumsstelle ($terminDatum[$j]) ueberschrieben
								}
								$letzte_id_mitdemDatum = $terminID[$max];	//Somit gab ich die letzte ID mit dem gleichen Datum
								if ($letzte_id_mitdemDatum == $terminID[$j]){	//und kontrollier, ob die letzte ID mit dem gleichen Datum gleich der gerade zu pruefenden ID($terminID[$j]) uebereinstimmt, wenn dies der Fall ist, sind wir bei der letzten ID mit dem doppelten Datum angekommen und koennen problemlos einmal echo schreiben und das dies spaeter nochmal passiert
									echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
											<div class=\"day eintragheutigerTag\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
												<div class=\"hovereintrag\">Projekt Beginn - ".fassezusammen($terminDatum[$j])."</div>	
											</div>\n
										</button></form>";
								}
							} else{ 
								echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
										<div class=\"day eintragheutigerTag\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
											<div class=\"hovereintrag\">".date_format(date_create($terminDatum[$j]),'d.m.y')."<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr</div>	
										</div>\n
									</button></form>";		//soll er ihn printen wie in day eintragheutigerTag bestimmt	
							}
						}	
					}else {		//Wenn kein Eintrag am "heutigen" ($i) Tag vorhanden ist
						if($i == date('d',strtotime($projektBeginn[0]))&& date('m.Y',strtotime($projektBeginn[0])) == date('m.Y',$date)){ //Ist das ProjektBeginn an dem Tag
							if ($mehrfachdatum[$j]){	//Wenn es mehrere Termine gibt
								$max=0;					//max = soll die maximale id speichern bei doppelten Datumseintraegen
								for($z = 0; $z < count($terminID); $z++){ //geh wieder alle Termine durch
									if($terminDatum[$z]==$terminDatum[$j])$max=$z;	//Wenn ein Termin Datum gleich dem jetztigen ist setz ich max auf die zaehlvariable, so wird diese bis zum letzten Eintrag mit der grad zu guckendem Datumsstelle ($terminDatum[$j]) ueberschrieben
								}
								$letzte_id_mitdemDatum = $terminID[$max];	//Somit gab ich die letzte ID mit dem gleichen Datum
								if ($letzte_id_mitdemDatum == $terminID[$j]){	//und kontrollier, ob die letzte ID mit dem gleichen Datum gleich der gerade zu pruefenden ID($terminID[$j]) uebereinstimmt, wenn dies der Fall ist, sind wir bei der letzten ID mit dem doppelten Datum angekommen und koennen problemlos einmal echo schreiben und das dies spaeter nochmal passiert
									echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
											<div class=\"day eintragprojektBeginn\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
												<div class=\"hovereintrag\">Projekt Beginn - ".fassezusammen($terminDatum[$j])."</div>	
											</div>\n
										</button></form>";
								}
							} else{ 		//Wenn das Datum nicht mehrmals vorkommt kann man einfach so ausgeben
								echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminID[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
										<div class=\"day eintragprojektBeginn\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
											<div class=\"hovereintrag\">Projekt Beginn - ".date_format(date_create($terminDatum[$j]),'d.m.y')."<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr</div>
										</div>\n
									</button></form>";
							}								
						} 
						elseif($i == date('d',strtotime($projektEnde[0]))&& date('m.Y',strtotime($projektEnde[0])) == date('m.Y',$date)){	//Ist das ProjektEnde an dem Tag
							if ($mehrfachdatum[$j]){	//Wenn es mehrere Termine gibt
								$max=0;					//max = soll die maximale id speichern bei doppelten Datumseintraegen
								for($z = 0; $z < count($terminID); $z++){ //geh wieder alle Termine durch
									if($terminDatum[$z]==$terminDatum[$j])$max=$z;	//Wenn ein Termin Datum gleich dem jetztigen ist setz ich max auf die zaehlvariable, so wird diese bis zum letzten Eintrag mit der grad zu guckendem Datumsstelle ($terminDatum[$j]) ueberschrieben
								}
								$letzte_id_mitdemDatum = $terminID[$max];	//Somit gab ich die letzte ID mit dem gleichen Datum
								if ($letzte_id_mitdemDatum == $terminID[$j]){	//und kontrollier, ob die letzte ID mit dem gleichen Datum gleich der gerade zu pruefenden ID($terminID[$j]) uebereinstimmt, wenn dies der Fall ist, sind wir bei der letzten ID mit dem doppelten Datum angekommen und koennen problemlos einmal echo schreiben und das dies spaeter nochmal passiert
									echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
											<div class=\"day eintragprojektEnde\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
												<div class=\"hovereintrag\">Projekt Ende - ".fassezusammen($terminDatum[$j])."</div>	
											</div>\n
										</button></form>";
								}
							} else{ 		//Wenn das Datum nicht mehrmals vorkommt kann man einfach so ausgeben
								echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
										<div class=\"day eintragprojektEnde\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
											<div class=\"hovereintrag\">Projekt Ende - ".date_format(date_create($terminDatum[$j]),'d.m.y')."<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr</div>
										</div>\n
									</button></form>";
							}
						}
						else{
							if ($mehrfachdatum[$j]){	//Wenn es mehrere Termine gibt
								$max=0;					//max = soll die maximale id speichern bei doppelten Datumseintraegen
								for($z = 0; $z < count($terminID); $z++){ //geh wieder alle Termine durch
									if($terminDatum[$z]==$terminDatum[$j])$max=$z;	//Wenn ein Termin Datum gleich dem jetztigen ist setz ich max auf die zaehlvariable, so wird diese bis zum letzten Eintrag mit der grad zu guckendem Datumsstelle ($terminDatum[$j]) ueberschrieben
								}
								$letzte_id_mitdemDatum = $terminID[$max];	//Somit gab ich die letzte ID mit dem gleichen Datum
								if ($letzte_id_mitdemDatum == $terminID[$j]){	//und kontrollier, ob die letzte ID mit dem gleichen Datum gleich der gerade zu pruefenden ID($terminID[$j]) uebereinstimmt, wenn dies der Fall ist, sind wir bei der letzten ID mit dem doppelten Datum angekommen und koennen problemlos einmal echo schreiben und das dies spaeter nochmal passiert
									echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
											<div class=\"day eintrag\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
												<div class=\"hovereintrag\">".fassezusammen($terminDatum[$j])."</div>	
											</div>\n
										</button></form>";
								}
							} else{ 		//Wenn das Datum nicht mehrmals vorkommt kann man einfach so ausgeben
								echo "<form action=\"terminbearbeiten.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"termin_bearbeiten\" value=\"$terminDatum[$j]/$aktuelles_projekt\" class=\"buttonkalender\">
										<div class=\"day eintrag\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
											<div class=\"hovereintrag\">".date_format(date_create($terminDatum[$j]),'d.m.y')."<br>".$terminName[$j]."<br> Um: ".date_format(date_create($terminUhrzeit[$j]),'H:i')." Uhr</div>
										</div>\n
									</button></form>";				//soll er ihn printen wie in day eintrag bestimmt
								}	

						}
					}
				}
			}
			//Kein Eintrag
			if( $i == date('d',$date) && date('m.Y',$date) == date('m.Y') && !$eintragen) {		// kontrolliert ob es der heutige Tag ist und ob er einen Eintrag hat, wenn kein Eintrag dann 
				if($i == date('d',strtotime($projektBeginn[0]))&& date('m.Y',strtotime($projektBeginn[0])) == date('m.Y',$date)){ //Kontrolliert ob ein ProjektBeginn auf dem Tag liegt
						echo "<form action=\"neuerTermin.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"neuerTerminAnlegen\" value=\"".date('m.Y',$date)."/".$i."/".$aktuelles_projekt."\" class=\"buttonkalender\">
								<div class=\"day currentprojektBeginn\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
									<div class=\"hovereintrag\">Projekt Beginn</div>
								</div>\n
							</button></form>";								
				}
				elseif($i == date('d',strtotime($projektEnde[0]))&& date('m.Y',strtotime($projektEnde[0])) == date('m.Y',$date)){	//Kontrolliert ob ein ProjektEnde auf dem Tag liegt
						echo "<form action=\"neuerTermin.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"neuerTerminAnlegen\" value=\"".date('m.Y',$date)."/".$i."/".$aktuelles_projekt."\" class=\"buttonkalender\">
								<div class=\"day currentprojektEnde\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
									<div class=\"hovereintrag\">Projekt Ende</div>
								</div>\n
							</button></form>";	
				}else{
					echo "<form action=\"neuerTermin.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"neuerTerminAnlegen\" value=\"".date('m.Y',$date)."/".$i."/".$aktuelles_projekt."\" class=\"buttonkalender\">
							<div class=\"day current\">".sprintf("%02d",$i)."</div>\n		
						</button></form>";					//Printe heutigen Tag aus
				}
			} else {
				if (!$eintragen){	//Wenn kein Eintrag an diesem Tag vorhanden  printe normalen Tag aus
					if($i == date('d',strtotime($projektBeginn[0]))&& date('m.Y',strtotime($projektBeginn[0])) == date('m.Y',$date)){ 
							echo "<form action=\"neuerTermin.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"neuerTerminAnlegen\" value=\"".date('m.Y',$date)."/".$i."/".$aktuelles_projekt."\" class=\"buttonkalender\">
									<div class=\"day normalprojektBeginn\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
										<div class=\"hovereintrag\">Projekt Beginn</div>
									</div>\n
								</button></form>";
					}elseif($i == date('d',strtotime($projektEnde[0]))&& date('m.Y',strtotime($projektEnde[0])) == date('m.Y',$date)){
							echo "<form action=\"neuerTermin.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"neuerTerminAnlegen\" value=\"".date('m.Y',$date)."/".$i."/".$aktuelles_projekt."\" class=\"buttonkalender\">
									<div class=\"day day normalprojektEnde\">".sprintf("%02d",$i)."<div class=\"hovereintragdreieck\"></div><div class=\"hovereintragdreieckinnen\"></div>
										<div class=\"hovereintrag\">Projekt Ende</div>
									</div>\n
								</button></form>";
					}else{
						echo "<form action=\"neuerTermin.php\" method=\"Post\" class=\"formkalender\"><button type=\"submit\" name=\"neuerTerminAnlegen\" value=\"".date('m.Y',$date)."/".$i."/".$aktuelles_projekt."\" class=\"buttonkalender\">
								<div class=\"day normal\">".sprintf("%02d",$i)."</div>\n		
							</button></form>";		//Ausgabe ohne Eintrag
					}
				}
			} 
        
			if( $i == $sum_days) {
				$next_sum = (6 - array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun')));
				for( $c = 1; $c <=$next_sum; $c++) {
					echo "<div class=\"day after\"> ".sprintf("%02d",$c)." </div>\n"; 
				}
			}
		
		}
	

	}

	if( isset($_REQUEST['timestamp'])){ 
		$date = $_REQUEST['timestamp'];
	} else {
		$date = time();
	}
	$arrMonth = array(
    "January" => "Januar",
    "February" => "Februar",
    "March" => "M&auml;rz",
    "April" => "April",
    "May" => "Mai",
    "June" => "Juni",
    "July" => "Juli",
    "August" => "August",
    "September" => "September",
    "October" => "Oktober",
    "November" => "November",
    "December" => "Dezember"
	);
    
	$headline = array('Mon','Die','Mit','Don','Fre','Sam','Son');
/**Kalender Ende**/
?>


<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<title> Proplaner </title>
		<link rel="stylesheet" href="style.css">

	</head>

	<body>

		<header class="headerunterseiten">
			<div class="lilabannerunterseiten">
				<img class="gluehbirneunterseiten" src="../Images/gluehbirne.png" width="135px"/>
				<img class="lesezeichenunterseiten" src="../Images/lesezeichen.png" />
                <a href = "meineProjekte.php"><img class="proplan" src="../Images/proplan.png" alt="proplan" /> </a>
				<p class="ueberschrift">
				<?php 
					$projektname = getORSetEintraege("SELECT name FROM projekt WHERE projekt_id = '$aktuelles_projekt'");
					echo $projektname[0];
				?>
				</p>	
		
				<div class="logout">	
					<a href="logout.php" > <img src="../Images/logout.png" alt="logout" /></a>
				</div>
  
				<div class="profil">
					<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
				</div>
        
				<p class="pfad">
					<a href="meineProjekte.php">Meine Projekte ></a>
					<?php 
						echo $projektname[0];
					?> 
				</p>
			</div>
		</header>

		<div class="hauptbereichunterseiten">
			<form name="einstellungform" class="einstellungform" action='projektEinstellung.php' method='POST'>
				<button class="einstellbutton" type="submit" name="einstellen" value="<?php echo $aktuelles_projekt; ?>"><img src="../Images/zahnrad.png" width="40px" height="40px"></button>
			</form>
			<div id="todo"><h3>TO-DO</h3>
	
			<?php  
			$result = getORSetEintraegeSchleifen("SELECT * FROM to_do WHERE projekt_ref = '$aktuelles_projekt'");
			$x=0;
			while($row = $result->fetch_array(MYSQLI_BOTH)){		
				$todos[$x][0][0] = array($row['to_do_id'],$row['aufgabe'],$row['bearbeitet']);
				$x++;	
			}
			//print_r($todos[0][0][0]);
			
			if(!isset($todos)){
				
			} else {
																//Da Dreidimensionale Arrays doof sind zum Vorstellen, hier mal ne Erklärung
				for($i=0; $i < count($todos); $i++){			//Itterieren über die erste Zeile heisst ueberalle Todos die zum Projekt existieren
					foreach ($todos[$i][0] as $todo) {			//Holt sich die Zeile in dem die Atribute drin stehen und itteriert ueber diese, die Attribute stehen in einem Zweidimensionalen Array
						echo "<div class=\"listetodo\">";
						
						if (strlen($todo[1])<=55){				//Gucken ob der Text ueber zwei Spalten gehen muss
							echo "<div class=\"aufgabetext\">";
							echo $todo[1];						//deshalb muss man hier noch sagen, welche Stelle des Arrays : $todo[0] = ids ; $todo[1] = aufgabe ; $todo[2] =  bearbeitet oder nicht in 0 oder 1
							echo "</div>";
						} else {
							echo "<div class=\"aufgabetexthoeher\">";
							echo $todo[1];						//deshalb muss man hier noch sagen, welche Stelle des Arrays : $todo[0] = ids ; $todo[1] = aufgabe ; $todo[2] =  bearbeitet oder nicht in 0 oder 1
							echo "</div>";
						}
						
						echo "<div class=\"zeichen\">";
						if($todo[2]==1){		//Wenn in Datenbank steht erledigt Printe nur den Haken ohne Anklickfunktion und den Loeschbutton aus
							echo"
							<form name=\"todoform\" action='todoscript.php' method='POST'><div class=\"buttontodoerledigt\"><img src=\"../Images/haken.png\" width=\"50px\"></div>
							<button class=\"buttontodo\" type=\"submit\" name=\"loeschen\" value=\"$todo[0]\"><img src=\"../Images/muelleimer.png\" width=\"23px\"></button>
							</div></div></form>";
						} else{
								echo"<form name=\"todoform\" action='todoscript.php' method='POST'>
									<button class=\"buttontodo\" type=\"submit\" name=\"bearbeiten\" value=\"$todo[0]\"><img src=\"../Images/bearbeiten.png\" width=\"24px\"></button>
									<button class=\"buttontodo\" type=\"submit\" name=\"erledigt\" value=\"$todo[0]\"><img src=\"../Images/haken.png\" width=\"50px\"></button>
									<button class=\"buttontodo\" type=\"submit\" name=\"loeschen\" value=\"$todo[0]\"><img src=\"../Images/muelleimer.png\" width=\"23px\"></button>
								</form> 
							  </div>
							  </div>";	
						}
					}
				}
			}
			?>

				<form class="neuesButton" action="neuestodo.php" method="Post">
					<button type="submit" id="button3" name="neuesToDo" value="<?php echo $aktuelles_projekt;?>">To-Do anlegen</button>
				</form>
			</div>
	

			<div class="calender">
			
				<div class="pagination">
					<a href="?timestamp=<?php echo yearBack($date)."&projekt_id=$aktuelles_projekt"; ?>" class="last">|&laquo;</a> <!-- Hier dran denken das man die projektID wieder ranhaengt, sonst hat kein Nutzer zugriff auf diese Seite!-->
					<a href="?timestamp=<?php echo monthBack($date)."&projekt_id=$aktuelles_projekt"; ?>" class="last">&laquo;</a> 
					<div class="pagihead">
						<span><?php echo $arrMonth[date('F',$date)];?> <?php echo date('Y',$date); ?></span>
					</div>
					<a href="?timestamp=<?php echo monthForward($date)."&projekt_id=$aktuelles_projekt"; ?>" class="next">&raquo;</a>
					<a href="?timestamp=<?php echo yearForward($date)."&projekt_id=$aktuelles_projekt"; ?>" class="next">&raquo;|</a>  
				</div>
				<?php getCalender($date,$headline); ?>
				<div class="clear"></div>
				
			</div>
	
	
	
			<div id="forum"><h4>Forum</h4>
			<?php  
			if(isset($themaID)){
				
				
				for($i=0; $i < count($themaID); $i++){	
					$userID = getORSetEintraege("SELECT user_ref FROM beitrag WHERE thema_ref = '$themaID[$i]' ORDER BY beitrag_id DESC LIMIT 1;");				
					$userName = getORSetEintraege("SELECT name FROM user WHERE user_id = '$userID[0]'");
					$beitragDatum = getORSetEintraege("SELECT datum FROM beitrag WHERE thema_ref = '$themaID[$i]' ORDER BY beitrag_id DESC LIMIT 1;");	
					echo "<div class=\"thema\">
							<div class=\"formthema\">";
							if(strlen($themaName[$i])<69){
								echo "<div class=\"mittig\"><a href=\"forum.php?thema=$themaID[$i]\">$themaName[$i]</a></div></div>";
							}else {
								echo "<a href=\"forum.php?thema=$themaID[$i]\">$themaName[$i]</a></div>";
							}
							echo"<div class=\"informationThema\">Letzter Beitrag von $userName[0] am ".date('d.m.Y \u\m H:i',strtotime($beitragDatum[0]))."</div>
						</div>";		
				}
			}
			?>
	
				<form class="neuesButton" action="neuesThema.php" method="Post">
					<button type="submit" id="button3" name="neuesThema" value="<?php echo $aktuelles_projekt;?>">Neues Thema</button>
				</form>
	
			</div>	
 	
	
		</div>

		<footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>


	</body>
</html>