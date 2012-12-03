<?php
	session_start();
	$userId = $_SESSION['vtpUserId'];
	require 'libraries\DbConnector.php';
	$Db = new DbConnector();
	$fav = $Db->getFavorites($userId);
	
	include("includes/functions.php");
	//return 'called';
	return addToFavorites($userId, $_POST["r"]);
?>