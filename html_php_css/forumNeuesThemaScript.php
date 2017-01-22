<?php
/**
  * Das Dokument laesst in der Datenbank ein neues Thema, sowie den ersten Beitrag zu diesem Thema anlegen, mit den uebergeben Atributen
  * @author Christoph Suhr
  */
session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){		//Ist der Nutzer ueberhaupt noch in der Session
		$berechtigung = 0;
		header("location:index.php");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$benutzer_id = $_SESSION['id'];
		
		//Verbinung zu Datenbank

		include ("datenbankschnittstelle.php");
		datenbankaufbau();
		
		$projektID = $_POST['forumNeuesThema'];	 
		//$projektID = mysql_real_escape_string($projektID);
		
		$themaName = $_POST['themaName'];
		//$themaName = mysql_real_escape_string($themaName);
		
		$text = $_POST['textareaNeuesThema'];	 
		//$text = mysql_real_escape_string($text);
		
		$tag = time();
		$tag = date('Y-m-d H:i:s',$tag);		//Wann und um wie viel Uhr wurde das Thema und der Beitrag erstellt, wichtig um spaeter die Thema ID zu bekommen
	}
	
	//Das Neue Thema wird angelegt, doch das Dokument kennt die ID ja noch nicht
	$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO thema (name, projekt_ref, datumProjekt) VALUES ('$themaName', '$projektID', '$tag')");
	/*Um sich diese zu holen gebrauchen wir nicht nur den Namen und ProjektID, sondern auch die genaue Uhrzeit
	Da folgende Faelle auftreten koennten, wenn man $tag nicht benutzt:
	Es existiert der Themen Name schon (Wenn sehr große Projekte existieren, haben die Nutzer ja nicht unbedingt ein ueberblick darueber)
	Dann wuerde die Datenbank den letzten Eintrag mit diesen Namen rauswerfen, wenn nun ein Nutzer so gut wie gleichzeitig ein Thema mit selben Namen erstellt und die Anfrage sich unglücklicher weise dazwischen schiebt, holt sich die Datenbank die falsche ID
	Und Das man einfach den letzten Eintrag aus der Datenbank holt, geht auch nicht, da wie angesprochen ein anderer Nutzer zur fast gleichen zeit ein Thema erstellen koennte (und da ich nicht weiß wie das Anfragen Haendling auf dem Server ist, da ich mich noch nicht so auskenne
	gehe ich auf Nummer sicher und Referenzier auch gleich mit auf das Datum)
	*/
	$themaID = getORSetEintraege("SELECT thema_id FROM thema WHERE name = '$themaName' AND projekt_ref = '$projektID' AND datumProjekt = '$tag'");
	//Jetzt wird die Themen ID gebraucht um den Beitrag richtig zuweisen zu koennen
	$rueckgabe = getORSetEintraegeSchleifen("INSERT INTO beitrag (beitrag_text, datum, thema_ref, user_ref) VALUES ('$text', '$tag', '$themaID[0]', '$benutzer_id')");
	header("location:forum.php?thema=$themaID[0]");
	
?>