<?php 
/**
  * Das Dokument zerstoert die aktuelle Sitzung, wenn es aufgerufen wird und verweisst auf die Hauptseite zurueck
  * @author Christoph Suhr
  * 
  */
	session_start();
	session_destroy();
	header("location:index.php");
	exit();
?>