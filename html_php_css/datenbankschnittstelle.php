<?php
	function datenbankaufbau(){
		mysql_connect("localhost", "root", "");
		mysql_select_db("pro_db");
		mysql_query ('SET NAMES utf8');
	}

	function getORSetEintraege($query){
		$result = mysql_query($query)or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		$result = mysql_fetch_array($result);
		return $result;
	}

	function getORSetEintraegeSchleifen($query){
		$result = mysql_query($query)or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		return $result;
	}

?>