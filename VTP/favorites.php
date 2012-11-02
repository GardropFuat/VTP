<?php
	echo "<h1>My Favorites</h1>";
	$userId = '123';
	require 'E:\xampp\htdocs\Testing Folder\libraries\DbConnector.php';
	$Db = new DbConnector();
	$fav = $Db->getFavorites($userId);
	//$Db->disconnect();
	include("includes/functions.php");
?>
	<table>
<?php
	foreach ($fav as $x)
	{
		//  get video title from youtube
		$videoData = file_get_contents("http://youtube.com/get_video_info?video_id=".$x['videoId']);
		parse_str($videoData);
		if (is_null($title))
		{
		}
		else
		{
			$videoTitle = $title;
			echo "<tr><td>";
			echo $videoTitle;
			echo "</td></tr>";
		}
		echo "<tr><td>";
		echo "<img src=\"//img.youtube.com/vi/".$x['videoId']."/2.jpg\" alt=\"".$x['videoId']."\">";
		echo "</td></tr>";
	}

?>
	</table>