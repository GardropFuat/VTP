<?php
/**
 *
 * File Name:       MakeFav.php
 * Description:     
 * Author:          Travis Rous
 * Created:         
 * Last Modified:   Anudeep 12/03/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

session_start();

//  display/hide PHP errors 0->hide , 1-> show(default)
ini_set('display_errors', 1);

include("includes/errorLog.php");
include("libraries/DbConnector.php");
include("includes/functions.php");

// Create new database instance
$Db = new DbConnector();

$userId = $_SESSION['vtpUserId'];
$fav = $Db->getFavorites($userId);
return addToFavorites($userId, $_POST["r"]);
?>