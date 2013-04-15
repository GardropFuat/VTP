<?php
/**
 *
 * File Name:       MakeFav.php
 * Description:     Helper function that adds a favorite to the database
 * Author:          Travis Rous
 * Created:         
 * Last Modified:   Anudeep 12/03/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

session_start();

include("libraries/DbConnector.php");
include("includes/functions.php");

// Create new database instance
$Db = new DbConnector();

$userId = $_SESSION['vtpUserId'];
$fav = $Db->getFavorites($userId);
return addToFavorites($userId, $_POST["r"]);
?>