<?php
/**
 *
 * File Name:       getFriends
 * Description:     Find the friends that are uploading videos to our site
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Travis 3/05/13
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */
include("libraries/facebook-api-php-client/facebook.php");
include_once( "head_std.php" );
$test = $userId[0];
$fav = $Db->getFavorites($_SESSION['vtpUserId']);

$facebook = new Facebook(array(
                'appId'  => '200590423408456',
                'secret' => '22eae2f5ee955789dcf2529993a04ca6',
            ));

$facebook = $facebook->api('me');
//$("#mydiv").width(width);
?>
        
            <script type='text/javascript'>
                function getlink (selectedSite)
                {
                  document.site.ytUrl.value = selectedSite ;
                  document.site.submit() ;
                }
            </script>


            <h1><?php echo $facebook["name"]; ?></h1>
            <?php echo ('<img src="http://graph.facebook.com/'.$facebook['id'].'/picture" height="100" width"100"><br>');
            echo('<a href='.$facebook['link'].'>View Facebook Profile</a><br>');
            ?>

            <div id="profileContainer">
                <div id="test">
                <div id="favorites" style="width:50%; float:left;">
                    <h2>Favorites</h2>

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



                </div>
                <div id="uploads" style="width:50%; float:right;">
                    <h2>Uploads</h2>
                </div>
            </div>
            </div>

    
<?php
    include_once( "tail_std.php" );
?>