<?php

	$conn="";
	function datenbankaufbau(){
		global $conn;

    	$conn = new mysqli("212.201.22.202", "planer", "verplant", "pro_db");
		//$conn = new mysqli("localhost", "root", "", "pro_db");
  	 	 if ($conn->connect_error) {
    	die("Verbindung zur Datenbank ist fehlgeschlagen ".$conn->connect_error);
   		}

		$conn->set_charset('utf8');
	}

	function getORSetEintraege($query){
		global $conn;
		$result = $conn->query ($query);
		$row = $result->fetch_array(MYSQLI_BOTH);
		return $row;
	/*	$result = mysql_query($query)or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		$result = mysql_fetch_array($result);
		return $result;*/
		
	}

	function getORSetEintraegeSchleifen($query){
		global $conn;
		$result = $conn->query ($query);
		return $result;
		/*$result = mysql_query($query)or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		return $result;*/
		
	}

?>