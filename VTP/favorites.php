<html>
<head>
<script language="JavaScript" type="text/javascript">
<!--
function getlink (selectedSite)
{
  document.site.ytUrl.value = selectedSite ;
  document.site.submit() ;
}
-->
</script>
<link href="css/main.css" rel="stylesheet" type="text/css"></link>
</head>
<?php
	session_start();
	echo "<h1>My Favorites</h1>";
	echo "<h2> &nbsp </h2>";
	$userId = $_SESSION['vtpUserId'];
	require 'libraries\DbConnector.php';
	$Db = new DbConnector();
	$fav = $Db->getFavorites($userId);
	//$Db->disconnect();
	include("includes/functions.php");
?>
	<table>
	
	
<?php
	echo "<form name=\"site\" method=\"post\" action=\"index.php\">";
	foreach ($fav as $x)
	{
		//  get video title from youtube
		$videoData = file_get_contents("http://youtube.com/get_video_info?video_id=".$x['videoId']);
		$site = "http://www.youtube.com/watch?v=".$x['videoId'];
		parse_str($videoData);
		if (is_null($title))
		{
		}
		else
		{
			echo "<tr><td>";
			echo "<input type=\"hidden\" name=\"ytUrl\" >";
			echo "<a href=\"javascript:getlink('".$site."')\">".$title."</a>";
			echo "</form>";
			//$videoTitle = $title;
			
			//echo $videoTitle;
			echo "</td></tr>";
		}
		echo "<tr><td>";
		echo "<img src=\"//img.youtube.com/vi/".$x['videoId']."/2.jpg\" alt=\"".$x['videoId']."\">";
		echo "</td></tr>";
	}

?>
	
	</table>
</html>