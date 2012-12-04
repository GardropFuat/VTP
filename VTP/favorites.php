<?php
/**
 *
 * File Name:       index.php
 * Description:     Base file for the project.
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Anudeep 10/09/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

session_start();

//  set default time zone
date_default_timezone_set("America/Denver");

//  display/hide PHP errors 0->hide , 1-> show(default)
ini_set('display_errors', 1);

include("includes/errorLog.php");
include("libraries/DbConnector.php");
include("includes/functions.php");

// Create new database instance
$Db = new DbConnector();

// Get user Favorites from DB
$userId = $_SESSION['vtpUserId'];
$fav = $Db->getFavorites($userId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Video Tag Portal - Favorites</title>
                            <!--    Style Sheets   -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <link href="css/jquery.dropdown.css" rel="stylesheet" type="text/css"></link>
        <link href="css/main.css" rel="stylesheet" type="text/css"></link>
                            <!--    Javascript files   -->
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="http://popcornjs.org/code/dist/popcorn-complete.js"></script>
        <script src="libraries/jquery.dropdown.js" type="text/javascript"></script>
        <script src="includes/functions.js" type="text/javascript"></script>
        <script language="JavaScript" type="text/javascript">
            function getlink (selectedSite)
            {
              document.site.ytUrl.value = selectedSite ;
              document.site.submit() ;
            }
        </script>
    </head>
    <body>
        <h1>My Favorites</h1>
        <h2> &nbsp </h2>
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
	</body>
</html>