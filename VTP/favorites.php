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
</head>
<?php
	echo "<h1>My Favorites</h1>";
	$userId = '123';
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