<?php
/**
 *
 * File Name:       head_std.php
 * Description:     Basic header for most of the pages
 * Author:          Anudeep Potlapally
 * Created:         03/06/2013
 * Last Modified:
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

include_once 'config.php';
include_once 'libraries/DbConnector.php';
include_once 'includes/functions.php';

// Create new database instance
$Db = new DbConnector();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8" />
        <meta name="google" value="notranslate" />
        <meta http-equiv="Content-Language" content="en_US" />
        <title>Video Tag Portal</title>
                            <!--    Style Sheets   -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <link href="css/jquery.dropdown.css" rel="stylesheet" type="text/css"></link>
        <link href="css/main.css" rel="stylesheet" type="text/css"></link>
                            <!--    Javascript files   -->
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="http://popcornjs.org/code/dist/popcorn-complete.js"></script>
        <script src="libraries/jquery.dropdown.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s&sensor=true"></script>
        <script src="includes/functions.js" type="text/javascript"></script>
        <?php
            include 'includes/headJS.php';
        ?>
    </head>
    <body>
		<?php
            include("header.php");
        ?>