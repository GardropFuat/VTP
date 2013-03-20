<?php
	
include_once( "head_std.php" );

$userId = $_SESSION['vtpUserId'];
$fav = $Db->setContainerPos($_POST['data'], $_POST['data2'],$_POST['data3'],$userId);
//$fav = $Db->setContainerPos('200', $userId);

?>