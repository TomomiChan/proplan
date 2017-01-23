<?php
/**
  * Das Dokument stellt die Verbindung zur Datenbank da und bietet zwei Funktionen um die Datenbank auszulesen und zu fuellen
  * @author Christoph Suhr
  *
  */

	/*
	 *Globale Variable um die Connection von der function datenbanlaufbau fuer alle weiteren funktionen weiter benutzen zu koennen
	 */
	$conn="";

   /**
	 * Versucht eine Verbindung zur Datenbank auf zu bauen und stellt die Verbindung Global bereit
     * @throws String, wenn die Verbindung fehlgeschlagen ist
     */
	function datenbankaufbau(){
		global $conn;

    	$conn = new mysqli("212.201.22.202", "planer", "verplant", "pro_db");
		//$conn = new mysqli("localhost", "root", "", "pro_db");
  	 	 if ($conn->connect_error) {
    	die("Verbindung zur Datenbank ist fehlgeschlagen ".$conn->connect_error);
   		}

		$conn->set_charset('utf8');
	}

	/**
	 * Versucht eine Verbindung zur Datenbank auf zu bauen und stellt die Verbindung Global bereit
     * @param $query String, der die SQL Anweisung enthaelt die uebermittelt werden soll
	 * @return $row ein Array, welches die Eintraege beinhaltet
     */
	function getORSetEintraege($query){
		global $conn;
		$result = $conn->query ($query);
		$row = $result->fetch_array(MYSQLI_BOTH);	//Keys des Array kann über Index und ueber Spalten Name angesprochen werden
		return $row;

	/*	$result = mysql_query($query)or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		$result = mysql_fetch_array($result);
		return $result;*/
	}

	/**
	 * Versucht eine Verbindung zur Datenbank auf zu bauen und stellt die Verbindung Global bereit
     * @param $query String, der die SQL Anweisung enthaelt die uebermittelt werden soll
	 * @return $result, je nach SQL Anweisung ein Boolean oder die reine Datenbankrueckgabe (damit man sie an anderer Stelle per whileschleife auslesen kann)
     */
	function getORSetEintraegeSchleifen($query){
		global $conn;
		$result = $conn->query($query);
		return $result;

		/*$result = mysql_query($query)or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		return $result;*/
	}

?>
