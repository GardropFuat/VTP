<?php
	
include_once( "head_std.php" );

$userId = $_SESSION['vtpUserId'];
$fav = $Db->setContainerPos($_POST['data'], $userId);

echo ($userId);
print_r($_POST);

?>